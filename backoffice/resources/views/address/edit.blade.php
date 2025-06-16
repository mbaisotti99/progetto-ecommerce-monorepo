@extends("layouts.master")
@section("titolo", "Modifica Indirizzo")
@section("contenuto")
@php
        $provs = config("province");
    @endphp
    <div class="container cent">
        <form action="{{ route("address.update", $address) }}" method="POST">
            @csrf
            @method("PUT")
            <div class="p-5 row my-5">
                <div class="col-6 py-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" name="nome" id="nome" value="{{ $address->nome }}"/>
                </div>
                <div class="col-6 py-3">
                    <label for="cognome" class="form-label">Cognome:</label>
                    <input type="text" class="form-control" name="cognome" id="cognome" value="{{ $address->cognome }}"/>
                </div>
                <div class="col-6 py-3">
                    <label for="indirizzo" class="form-label">Indirizzo:</label>
                    <input type="text" class="form-control" name="indirizzo" id="indirizzo" value="{{ $address->indirizzo }}"/>
                </div>
                <div class="col-6 py-3">
                    <label for="civico" class="form-label">Numero Civico:</label>
                    <input type="text" class="form-control" name="civico" id="civico" value="{{ $address->civico }}"/>
                </div>
                <div class="col-6 py-3">
                    <label for="localita" class="form-label">Località:</label>
                    <input type="text" class="form-control" name="localita" id="localita" value="{{ $address->localita }}" />
                </div>
                <div class="col-6 py-3">
                    <label for="provincia" class="form-label">Provincia:</label>
                    <select name="provincia" id="provincia" class="form-control">
                        @foreach ($provs as $prov)
                            <option value="{{ $prov }}" {{ $address->provincia = $prov ? "selected" : "" }}>{{ $prov }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 py-3">
                    <label for="cap" class="form-label">CAP:</label>
                    <input type="number" class="form-control" name="cap" id="cap" value="{{ $address->cap }}"/>
                </div>
                <div class="col-6 py-3">
                    <button type="submit" class="btn btn-success fs-3">Salva</button>
                </div>
            </div>
        </form>
    </div>
@endsection