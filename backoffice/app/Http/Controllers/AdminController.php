<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminOrders () {
        $users = User::all();

        return view("admin.orders", compact("users"));
    }

    public function showOrders ($user) {
        $user = User::find($user);

        return view("admin.showOrders", compact("user"));
    }

    public function changeOrderStatus ($order, Request $request){
        $order = Invoice::find($order);
        $data = $request->all();

        if (array_key_exists("notes", $data) && $data["notes"] !== "" && $data["notes"] !== null){
            $order->note = $data["notes"];
        }

        $order->status = $data["status"];
        $order->update();

        return redirect(route("admin.showOrders", $order->user->id));
    }

    public function shipOrder ($order, Request $request){
        $order = Invoice::find($order);

        if (array_key_exists("notes", $request->all()) && $request->notes !== ""){
            $order->note = $request->notes;
        }

        $order->status = "spedito";
        $order->update();

        return redirect(route("admin.showOrders", $order->user->id));
    }
}
