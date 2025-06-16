<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prods = Product::orderByDesc("created_at")->paginate(10);

        return view("admin.prods", compact("prods"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cats = Categorie::cases();

        return view("products.create", compact("cats"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $taglie = ["XS", "S", "M", "L", "XL", "XXL"];

        $categorie = array_map(fn($e) => $e->value, Categorie::cases());

        $data = $request->all();

        if (
            !empty(array_diff($data["taglie"], $taglie))
            ||
            !in_array($data["categoria"], $categorie)
            ||
            !is_numeric($data["prezzo"])
            ||
            !is_numeric($data["sconto"])
        ) {
            return redirect()->back()->with('error', 'Qualcosa è andato storto!');
        }

        $newProd = new Product();

        if (array_key_exists("img", $data)) {
            $img_path = Storage::putFile("prods", $data["img"]);
            $img_name = basename($img_path);
            $newProd->img = $img_name;
        } else {
            $newProd->img = null;
        }

        $newProd->nome = $data["nome"];
        $newProd->descrizione = $data["descrizione"];
        $newProd->categoria = $data["categoria"];
        $newProd->taglie = $data["taglie"];

        if ($data["sconto"] > 0) {
            $newProd->scontato = 1;
            $newProd->sconto = $data["sconto"];
        }

        $newProd->prezzo = $data["prezzo"];

        $newProd->save();

        return redirect(route("prods-admin.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cats = Categorie::cases();
        $prod = Product::find($id);
        return view("products.edit", compact("prod", "cats"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $product)
    {
        $prod = Product::find($product);
        $data = $request->all();

        $taglie = ["XS", "S", "M", "L", "XL", "XXL"];

        $categorie = array_map(fn($e) => $e->value, Categorie::cases());

        if (
            !empty(array_diff($data["taglie"], $taglie))
            ||
            !in_array($data["categoria"], $categorie)
            ||
            !is_numeric($data["prezzo"])
            ||
            !is_numeric($data["sconto"])
        ) {
            return redirect()->back()->with('error', 'Qualcosa è andato storto!');
        }

        if (array_key_exists("img", $data)) {
            Storage::delete($prod->img);
            $img_path = Storage::putFile("prods", $data["img"]);
            $filename = basename($img_path);
            $prod->img = $filename;
        }

        if ($data["sconto"] > 0) {
            $prod->scontato = 1;
            $prod->sconto = $data["sconto"];
        } else {
            $prod->scontato = 0;
            $prod->sconto = null;
        }

        $prod->nome = $data["nome"];
        $prod->descrizione = $data["descrizione"];
        $prod->categoria = $data["categoria"];
        $prod->prezzo = $data["prezzo"];
        $prod->taglie = $data["taglie"];



        $prod->update();

        return redirect(route("prods-admin.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($prod)
    {
        $prod = Product::find($prod);
        $prod->delete();

        return redirect(route("prods-admin.index"));
    }
}
