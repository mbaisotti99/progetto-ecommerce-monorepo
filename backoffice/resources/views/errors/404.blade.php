@extends("layouts.master")
@section("titolo", "Pagina non trovata")
@section("contenuto")
    <div class="container cent">
        <div class="notFound">
            <img src="{{ asset("storage/loading.gif") }}" data-src="{{ asset("storage/404.avif") }}" alt="404" class="lazy-load">
            <h1 class="text-center my-5">
                Pagina non trovata!
            </h1>
            <a href="{{ route("home") }}" class="btn btn-primary fs-3">Torna alla home</a>
        </div>
    </div>
@endsection