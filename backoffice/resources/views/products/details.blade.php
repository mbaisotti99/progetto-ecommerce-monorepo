@extends("layouts.master")
@section("titolo", "Dettagli $prod->nome")
@section("contenuto")
@php
$sortedRevs = $prod->reviews->sortByDesc("data");
@endphp
<script>
    document.addEventListener("DOMContentLoaded", function(){
        const prod = document.querySelector(".prodCont")
        const rev = document.querySelector(".revBox")
        rev.style.maxHeight = `${prod.offsetHeight + 400}px`;
    })
</script>
    <div class="container cent">
        <div class="row mb-5">
            <div class="col-lg-5 col-xl-5 col-md-12 prodCont">
                <x-det-card :prod="$prod"></x-det-card>
            </div>
            <div class="col-lg-7 col-xl-7 col-md-12 revBox">
                @foreach ($sortedRevs as $rev)
                    <x-rev-card :rev="$rev"></x-rev-card>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
@endsection