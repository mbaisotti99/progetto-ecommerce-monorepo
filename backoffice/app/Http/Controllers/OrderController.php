<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Ship;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Faker\Generator;
use Illuminate\Container\Container;

class OrderController extends Controller
{
    public function checkout()
    {
        $order = Auth::user()->order;
        $addresses = Auth::user()->addresses;
        $speds = Ship::all();

        return view("order.checkout", compact("order", "addresses", "speds"));
    }

    public function storeInvoice(Request $request)
    {
        $newInv = new Invoice();
        $faker = Container::getInstance()->make(Generator::class);
        $address = $request->address;
        $total = $request->total;

        try{
            $spedizione = Ship::findOrFail($request->spedizione);
        } catch (ModelNotFoundException $e){
            return redirect()->back()->with('error', 'Qualcosa è andato storto!');
        }

        $order = Auth::user()->order;

        $newInv->codice = $faker->randomNumber(8, true);
        $newInv->address_id = $address;
        $newInv->user_id = Auth::user()->id;
        $newInv->order_id = Auth::user()->order->id;
        $newInv->status = "bozza";
        $newInv->ship_id = $spedizione->id;

        $couponSconto = false;
        if (Auth::user()->order->coupon){
            $couponSconto = config("coupons")[Auth::user()->order->coupon];
            $newInv->coupon = Auth::user()->order->coupon;
        }

        $newInv->costo =  $total + $spedizione->costo;
        
        $newInv->save();
        foreach (Auth::user()->order->products as $prod) {
            $newInv->products()->attach($prod, [
                "taglia" => $prod->pivot->taglia,
                "quantita" => $prod->pivot->quantita,
            ]);
        }

        return view("order.finalize", ["invoice" => $newInv, "order" => $order]);
    }

    public function finalize($invoice)
    {
        try{
            Invoice::find($invoice)->update([
                'status' => 'confermato'
            ]);
        } catch (ModelNotFoundException $e){
            return redirect()->back()->with('error', 'Qualcosa è andato storto!');
        }

        foreach(Auth::user()->invoices as $inv){
            if ($inv->status == "bozza"){
                $inv->delete();
            }
        }


        Auth::user()->order->delete();

        return redirect(route("user.orders"))->with("success", "Ordine inviato con successo!");
    }

    public function cancel($invoice)
    {
        $inv = Invoice::find($invoice);
        $inv->delete();

        return redirect(route("user.cart"));
    }

    
}
