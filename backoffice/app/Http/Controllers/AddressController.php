<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("address.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $page = $request->page;
        $data = $request->all();
        $newAddress = new Address();

        if (
            !in_array($data["provincia"], config("province"))
            ||
            !is_numeric($data["cap"])
        ) {
            return redirect()->back()->with('error', 'Qualcosa è andato storto!');
        }

        $newAddress->nome = $data["nome"];
        $newAddress->cognome = $data["cognome"];
        $newAddress->indirizzo = $data["indirizzo"];
        $newAddress->civico = $data["civico"];
        $newAddress->localita = $data["localita"];
        $newAddress->provincia = $data["provincia"];
        $newAddress->cap = $data["cap"];
        $newAddress->user_id = Auth::user()->id;

        $newAddress->save();

        if ($page == "checkout") {
            return redirect(route("order.checkout"));
        } else {
            return redirect(route("user.details"));
        }
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
    public function edit(Address $address)
    {
        return view("address.edit", compact("address"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        $data = $request->all();

        $address->nome = $data["nome"];
        $address->cognome = $data["cognome"];
        $address->indirizzo = $data["indirizzo"];
        $address->civico = $data["civico"];
        $address->localita = $data["localita"];
        $address->provincia = $data["provincia"];
        $address->cap = $data["cap"];

        $address->update();

        return redirect(route("user.details"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();

        return redirect(route("user.details"));
    }
}
