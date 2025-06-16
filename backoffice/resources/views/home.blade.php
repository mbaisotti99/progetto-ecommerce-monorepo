@extends("layouts.master")
@section("titolo", "Home")
@section("contenuto")
    <div class="container ">
        <div class="d-flex justify-content-center mt-5">
            <a href="{{ route("products.index") }}" class="btn btn-primary fs-2">
                Tutti i prodotti
            </a>
        </div>
        @if (Auth::check() && Auth::user()->role == "admin")

        <div class="adminPanelCont mt-3">
            <h1 class="text-center mt-5">
                Pannello Admin
            </h1>
            <div class="adminPanel">
                <a href="{{ route("prods-admin.index") }}" class="btn btn-outline-dark fs-3">Prodotti</a>
                <a href="{{ route("admin.orders") }}" class="btn btn-outline-dark fs-3">Utenti & Ordini</a>
            </div>
        </div>

        @endif
        <h1 class="text-center my-5">In evidenza</h1>
        <div class="row">
            @foreach ($bestProds as $prod)
                <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                    <x-best-card :prod="$prod">
                        <x-slot:desc>
                            <!-- <p class="card-text">{{$prod->descrizione}}</p> -->
                        </x-slot:desc>
                        <x-slot:add>
                            <!-- <a href="{{ route("user.addToCart", $prod) }}" class="btn">
                                <i class="bi bi-cart2"></i>
                            </a> -->
                            <div class="btn btn-primary"><a href="{{ route("products.details", $prod) }}">Dettagli</a></div>
                        </x-slot:add>
                    </x-best-card>
                </div>
            @endforeach
        </div>
        <h1 class="text-center my-5">
            Prodotti Scontati
        </h1>
        <div class="row my-5">
            @foreach ($discountedProds as $prod)
                <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                    <x-best-card :prod="$prod">
                        <x-slot:desc>
                            <!-- <p class="card-text">{{$prod->descrizione}}</p> -->
                        </x-slot:desc>
                        <x-slot:add>
                            <!-- <a href="{{ route("user.addToCart", $prod) }}" class="btn">
                                <i class="bi bi-cart2"></i>
                            </a> -->
                            <div class="btn btn-primary"><a href="{{ route("products.details", $prod) }}">Dettagli</a></div>
                        </x-slot:add>
                    </x-best-card>
                </div>
            @endforeach
        </div>
    </div>
@endsection