<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function details()
    {
        return view("user.details");
    }

    public function orders()
    {
        $invoices = Auth::user()->invoices()->orderByDesc("created_at")->paginate(5);
        return view("user.orders", compact("invoices"));
    }

    public function orderReceived($order)
    {
        $order = Invoice::find($order);

        $order->status = "consegnato";
        $order->update();

        return redirect(route("user.orders"));
    }


    public function cart()
    {
        $order = Auth::user()->order()->with([
            'products' => function ($q) {
                $q->withPivot('taglia', 'quantita');
            }
        ])->first();
        return view("user.cart", compact("order"));
    }

    public function addToCart(Product $prod, Request $req)
    {
        $user = Auth::user();
        $taglie = ["XXS", "XS", "S", "M", "L", "XL", "XXL"];
        $size = $req->taglia;

        if (!in_array($size, $taglie)) {
            return redirect()->back()->with('error', 'Qualcosa è andato storto!');
        }

        if (!isset($user->order)) {
            $newOrder = new Order();
            $newOrder->user_id = $user->id;
            $newOrder->save();

            $newOrder->products()->attach($prod, ["taglia" => $size]);
        } else {
            $existingProd = $user->order->products->filter(function ($item) use ($prod, $size) {
                return $item->id == $prod->id && $item->pivot->taglia == $size;
            })->first();
            if ($existingProd) {
                DB::table('order_product')
                    ->where('order_id', $user->order->id)
                    ->where('product_id', $prod->id)
                    ->where('taglia', $size)
                    ->update([
                        'quantita' => $existingProd->pivot->quantita + 1
                    ]);

            } else {

                $user->order->products()->attach($prod, ["taglia" => $size]);

            }
        }

        return redirect(route("user.cart"));
    }

    public function updateCart(Request $req, Product $prod)
    {

        $taglie = ["XXS", "XS", "S", "M", "L", "XL", "XXL"];


        $newSize = $req->taglia;
        $newQuantita = $req->qty;
        $oldSize = $req->old_taglia;
        $oldQuantita = $req->old_quantita;
        $user = Auth::user();
        $curOrder = $user->order;

        if (!in_array($newSize, $taglie)) {
            return redirect()->back()->with('error', 'Qualcosa è andato storto!');
        }

        if (!is_numeric($newQuantita)){
            return redirect()->back()->with('error', 'Qualcosa è andato storto!');
        }

        if ($newQuantita !== $oldQuantita) {
            if ($newQuantita > 0) {
                DB::table('order_product')
                    ->where('order_id', $curOrder->id)
                    ->where('product_id', $prod->id)
                    ->where('taglia', $oldSize)
                    ->update([
                        'quantita' => $newQuantita
                    ]);
            } else {
                DB::table('order_product')
                    ->where('order_id', $curOrder->id)
                    ->where('product_id', $prod->id)
                    ->where('taglia', $oldSize)
                    ->delete();
            }
        }

        if ($newSize !== $oldSize) {
            $sameSizeProd = $curOrder->products->filter(function ($item) use ($prod, $newSize) {
                return $item->id == $prod->id && $item->pivot->taglia == $newSize;
            })->first();
            if ($sameSizeProd) {

                $sumQty = $newQuantita + $sameSizeProd->pivot->quantita;

                DB::table("order_product")
                    ->where("order_id", $curOrder->id)
                    ->where('product_id', $prod->id)
                    ->delete();

                $curOrder->products()->attach($prod->id, [
                    "taglia" => $newSize,
                    "quantita" => $sumQty
                ]);
            } else {
                DB::table('order_product')
                    ->where('order_id', $curOrder->id)
                    ->where('product_id', $prod->id)
                    ->where('taglia', $oldSize)
                    ->update([
                        'taglia' => $newSize
                    ]);
            }
        }



        $order = Auth::user()->order()->with([
            'products' => function ($q) {
                $q->withPivot('taglia', 'quantita');
            }
        ])->first();

        return redirect(route("user.cart", compact("order")));
    }

    public function removeFromCart(Product $prod, $taglia)
    {
        $curOrder = Auth::user()->order;
        DB::table('order_product')
            ->where('order_id', $curOrder->id)
            ->where('product_id', $prod->id)
            ->where('taglia', $taglia)
            ->delete();

        if (count(Auth::user()->order->products) == 0) {
            Auth::user()->order->delete();
            return redirect(route("user.cart"));
        }

        $order = Auth::user()->order()->with([
            'products' => function ($q) {
                $q->withPivot('taglia', 'quantita');
            }
        ])->first();

        return redirect(route("user.cart", compact("order")));
    }


    public function writeReview($prod)
    {
        $prod = Product::find($prod);

        return view("user.review", compact("prod"));
    }


    public function storeReview($prod, Request $request)
    {

        $data = $request->all();

        $newRev = new Review();
        $newRev->utente = Auth::user()->name;
        $newRev->voto = $data["stars"];
        $newRev->data = now();
        $newRev->testo = $data["text"];
        $newRev->product_id = $prod;

        $newRev->save();

        return redirect(route("products.details", $prod));
    }

    public function applyCoupon(Request $request)
    {
        $data = $request->all();

        $coupons = config("coupons");
        $inputCode = strtoupper(trim($data["coupon"]));

        if (array_key_exists($inputCode, $coupons)) {
            Auth::user()->order->coupon = $inputCode;
            Auth::user()->order->update();
        } else {
            return redirect()->back()->with('error', 'Coupon non valido!');
        }

        return redirect(route("user.cart"));


    }
}




