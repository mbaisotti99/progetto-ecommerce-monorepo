@extends("layouts.master")
@section("titolo", "Tutti i Prodotti")

@section("contenuto")

    <div class="container">

        <h1 class="text-center my-5">
            Tutti i nostri Prodotti
        </h1>

        <div class="row mb-5">
            @foreach ($prods as $prod)

                <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                    <x-best-card :prod="$prod">
                        <x-slot:desc>
                            <p class="card-text">{{$prod->descrizione}}</p>
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

        {{ $prods->links('pagination::bootstrap-5') }}


    </div>

@endsection