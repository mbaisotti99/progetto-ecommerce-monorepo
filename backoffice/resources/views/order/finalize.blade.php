@extends("layouts.master")
@section("titolo", "Finalizza ordine")

@section("contenuto")

    <div class="container cent">
        <h1 class="text-center my-5">Controlla il tuo ordine</h1>
        <x-invoice-card 
        :invoice="$invoice"
        />
        <div class="d-flex justify-content-around gap-5">
            <form action="{{route("order.finalize", $invoice->id)}}" method="POST">
                @csrf
                <button class="btn btn-success mt-5" type="submit">Conferma ordine</button>
            </form>
            <form action="{{route("order.cancel", $invoice->id)}}" method="POST">
                @csrf
                @method("DELETE")
                <button class="btn btn-secondary mt-5" type="submit">Annulla </button>
            </form>
        </div>
    </div>
@endsection