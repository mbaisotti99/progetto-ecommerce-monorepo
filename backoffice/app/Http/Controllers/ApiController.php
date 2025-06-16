<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        $prods = Product::with('reviews')
            ->get()
            ->map(function ($product) {

                $averageRating = $product->reviews->avg('voto');
                $product->average_rating = $averageRating;
                if ($averageRating > 4) {
                    $product->hot = true;
                }
                return $product;
            })
        ;

        if (!$prods) {
            return response()->json([
                "success" => false,
                "message" => "Prodotti non trovati."
            ], 404);
        }

        return response()->json([
            "success" => true,
            "data" => $prods,
        ]);
    }

    public function best()
    {
        $bestProds = Product::with('reviews')
            ->get()
            ->map(function ($product) {

                $averageRating = $product->reviews->avg('voto');
                $product->average_rating = $averageRating;
                if ($averageRating > 4) {
                    $product->hot = true;
                }
                return $product;
            })
            ->sortByDesc('average_rating')
            ->take(9);

        if (!$bestProds) {
            return response()->json([
                "success" => false,
                "message" => "Prodotti non trovati."
            ], 404);
        }

        return response()->json([
            "success" => true,
            "data" => array_values($bestProds->toArray()),
        ]);
    }

    public function filterCat(string $cat)
    {
        $prods = Product::where("categoria", $cat)
            ->with('reviews')
            ->get()
            ->map(function ($product) {

                $averageRating = $product->reviews->avg('voto');
                $product->average_rating = $averageRating;
                if ($averageRating > 4) {
                    $product->hot = true;
                }
                return $product;
            })
            ->sortByDesc('average_rating');

        if (!$prods) {
            return response()->json([
                "success" => false,
                "message" => "Prodotti non trovati."
            ], 404);
        }

        return response()->json([
            "success" => true,
            "data" => $prods,
        ]);
    }

    public function search(string $search)
    {
        $prods = Product::where("nome", "LIKE", "%$search%")
            ->with('reviews')
            ->get()
            ->map(function ($product) {

                $averageRating = $product->reviews->avg('voto');
                $product->average_rating = $averageRating;
                if ($averageRating > 4) {
                    $product->hot = true;
                }
                return $product;
            })
            ->sortByDesc('average_rating');

        if ($prods->isEmpty()) {
            return response()->json([
                "success" => false,
                "message" => "Nessun risultato"
            ]);
        }

        return response()->json([
            "success" => true,
            "data" => $prods
        ]);
    }

    public function show($id)
    {
        $prod = Product::with("reviews")->find($id);

        if (!$prod) {
            return response()->json([
                "success" => false,
                "message" => "Prodotto non trovato."
            ], 404);
        }

        $averageRating = $prod->reviews->avg('voto');
        $prod->average_rating = $averageRating;
        if ($averageRating > 4) {
            $prod->hot = true;
        }

        return response()->json([
            "success" => true,
            "data" => $prod,
        ]);
    }


    public function advancedSearch(Request $request)
    {
        $data = $request->all();

        $taglieArr = ["XS", "S", "M", "L", "XL", "XXL"];


        ["nome" => $nome, "categoria" => $categoria, "prezzoMin" => $prezzoMin, "prezzoMax" => $prezzoMax, "isTagliaFiltered" => $isTagliaFiltered, "taglie" => $taglie] = $data;

        if ($isTagliaFiltered && empty($taglie)) {
            return response()->json([
                "success" => false,
                "message" => "Nessun prodotto trovato",
            ]);
        }

        if (
    //         !in_array($categoria, array_map(
    //       fn (Categorie $categorie) => $categorie->value,
    //       Categorie::cases()
    //    ))
    //         ||
            !empty(array_diff($taglie, $taglieArr))
            ||
            !is_numeric($prezzoMax)
            ||
            !is_numeric($prezzoMin)
        ) {
            return response()->json([
                "success" => false,
                "message" => "Qualcosa è andato storto!",
            ]);
        }

        $prods = $isTagliaFiltered ?

            Product::when($nome !== "", function ($q) use ($nome) {
                return $q->where("nome", "LIKE", "%$nome%");
            })
                ->whereIn("categoria", $categoria)
                ->where("prezzo", ">=", $prezzoMin)
                ->where("prezzo", "<=", $prezzoMax)
                ->when(!empty($taglie), function ($query) use ($taglie) {
                    foreach ($taglie as $taglia) {
                        $query->whereJsonContains("taglie", $taglia);
                    }
                })
                ->with('reviews')
                ->get()
                ->map(function ($product) {

                    $averageRating = $product->reviews->avg('voto');
                    $product->average_rating = $averageRating;
                    if ($averageRating > 4) {
                        $product->hot = true;
                    }
                    return $product;
                })

            :

            Product::when($nome !== "", function ($q) use ($nome) {
                return $q->where("nome", "LIKE", "%$nome%");
            })
                ->whereIn("categoria", $categoria)
                ->where("prezzo", ">=", $prezzoMin)
                ->where("prezzo", "<=", $prezzoMax)
                ->with('reviews')
                ->get()
                ->map(function ($product) {

                    $averageRating = $product->reviews->avg('voto');
                    $product->average_rating = $averageRating;
                    if ($averageRating > 4) {
                        $product->hot = true;
                    }
                    return $product;
                });

        if ($data["discounted"] === true) {
            $prods = $prods->filter(function ($prod) {
                return $prod->scontato == 1;
            });
        }

        if ($prods->isEmpty()) {

            return response()->json([
                "success" => false,
                "message" => "Nessun prodotto trovato",
            ]);

        }


        return response()->json([
            "success" => true,
            "data" => array_values($prods->toArray()),
        ]);



    }
}
