<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $prods = Product::paginate(9);
        foreach ($prods as $prod) {
            if ($prod->reviews->avg("voto") > 4) {
                $prod->hot = true;
            }
        }

        return view("products.index", compact("prods"));
    }

    public function filtered($cat)
    {
        $prods = Product::where("categoria", $cat)->paginate(6);
        return view("products.filtered", compact("prods", "cat"));
    }

    public function details(Product $prod)
    {
        return view("products.details", compact("prod"));
    }

    public function discounted()
    {
        $prods = Product::with('reviews')
            ->where("scontato", 1)
            ->orderByDesc('sconto')
            ->paginate(6)
            ->through(function ($product) {
                $averageRating = $product->reviews->avg('voto');
                $product->average_rating = $averageRating;

                if ($averageRating > 4) {
                    $product->hot = true;   
                }

                return $product;
            });

        return view("products.discounted", compact("prods"));
    }

}
