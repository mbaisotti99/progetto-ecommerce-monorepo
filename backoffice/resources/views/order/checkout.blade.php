@extends("layouts.master")
@section("titolo", "Checkout")
@section("contenuto")
    <div class="container">
        @php
        session_start();
        $grandTotal = $_SESSION["total"];
        @endphp

        @if (count($addresses) > 0)
        <!-- Send Order -->
            <form action="{{ route("order.storeInvoice") }}" method="POST">
                @csrf 
                <input type="hidden" value={{ $grandTotal }} name="total">
                <h1 class="text-center my-5">
                    Seleziona un indirizzo
                </h1>
                @if(session('error'))
                    <div class="d-flex w-100 justify-content-center  my-3">
                        <div class="alert alert-danger w-50 text-center">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
                <div class="selectAddress d-flex gap-5 fs-2">
                    <select name="address" id="" class="form-control">
                        @foreach ($addresses as $add )
                        <option value={{ $add->id }}>{{$add->indirizzo . " - " . $add->localita}}</option>
                        @endforeach
                    </select>

                    <label for="spedizione" class="form-label">Tipo di spedizione: </label>
                    <select name="spedizione" id="spedizione" class="form-control">
                        @foreach ($speds as $sped)
                            <option value={{ $sped->id }}>{{$sped->nome . " - " . $sped->costo . "€"}}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">Usa questo indirizzo</button>
                </div>
            </form>
            
            
            <hr>
            <p class="text-center text-secondary my-5">
                oppure
            </p>
            <hr>
        @endif

        <h1 class="my-5 text-center">
            Crea un nuovo Indirizzo
        </h1>

        <div class="cent">
            <x-create-address>
                <x-slot:page>
                    checkout
                </x-slot:page>
            </x-create-address>
        </div>

    </div>
@endsection