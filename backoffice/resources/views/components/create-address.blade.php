<div class="card p-5">
    <form action="{{ route("address.store") }}" method="POST">
        @csrf
        @php
            $provs = config("province")
        @endphp
        <input type="hidden" name="page" value="{{$page}}">
        <div class="row">
            <div class="col-6 my-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control">
            </div>


            <div class="col-6 my-3">
                <label for="cognome" class="form-label">Cognome:</label>
                <input type="text" name="cognome" id="cognome" class="form-control">
            </div>


            <div class="col-6 my-3">
                <label for="indirizzo" class="form-label">Indirizzo:</label>
                <input type="text" name="indirizzo" id="indirizzo" class="form-control">
            </div>


            <div class="col-6 my-3">
                <label for="civico" class="form-label">Numero civico:</label>
                <input type="text" name="civico" id="civico" class="form-control">
            </div>


            <div class="col-6 my-3">
                <label for="localita" class="form-label">Località:</label>
                <input type="text" name="localita" id="localita" class="form-control">
            </div>


            <div class="col-6 my-3">
                <label for="provincia" class="form-label">Provincia></label>
                <select name="provincia" id="provincia" class="form-control">
                    @foreach ($provs as $prov )
                     <option value="{{ $prov }}">{{$prov}}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-6 my-3">
                <label for="cap" class="form-label">CAP</label>
                <input type="number" class="form-control" name="cap" id="cap">
            </div>


            <button type="submit" class="btn btn-success">Salva indirizzo</button>
        </div>

    </form>
</div>