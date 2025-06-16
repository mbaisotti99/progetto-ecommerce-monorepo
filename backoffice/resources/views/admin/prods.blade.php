@extends("layouts.master")
@section("titolo", "Prodotti Admin")
@section("contenuto")
    <div class="container text-center">
        <a href="{{ route("prods-admin.create") }}" class="btn btn-primary my-5 fs-4">
            Crea nuovo Prodotto
        </a>
        <table class="table table-striped my-5">
            <tr>
                <th>Immagine</th>
                <th>Nome</th>
                <th>Taglie Disponibili</th>
                <th>Descrizione</th>
                <th>Categoria</th>
                <th>Prezzo</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($prods as $prod)
                <tr>
                    <td><img src="{{asset("storage/prods/$prod->img")}}" alt="..." width="300"></td>
                    <td>{{ $prod->nome }}</td>
                    <td>{{ implode(" - ", $prod->taglie) }}</td>
                    <td>{{ $prod->descrizione }}</td>
                    <td>{{ $prod->categoria }}</td>
                    <td>
                        @if ($prod->scontato == 1)
                        <div class="d-flex gap-2">
                            <p class="oldPrice">
                                {{ number_format($prod->prezzo, 2, ".") }}€
                            </p>
                            <p class="discountedPrice">
                                {{ number_format($prod->prezzo - ($prod->prezzo / 100 * $prod->sconto), 2, ".") }}€
                            </p>
                        </div>
                        @else
                        {{ number_format($prod->prezzo, 2, ".") }}€
                        @endif
                    </td>
                    <td><a href="{{ route("prods-admin.edit", $prod->id) }}" class="btn btn-warning fs-3">Modifica</a></td>
                    <td>
                        <button type="button" class="btn btn-danger fs-3" data-bs-toggle="modal"
                            data-bs-target="#deleteProdModal">
                            Elimina
                        </button>
                    </td>
                </tr>

                <div class="modal fade" id="deleteProdModal" tabindex="-1" aria-labelledby="deleteProdModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="deleteProdModalLabel">Elimina Prodotto</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Sei sicuro di voler eliminare questo prodotto?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <form action="{{route("prods-admin.destroy", $prod->id)}}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-danger">Elimina</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </table>
        {{ $prods->links('pagination::bootstrap-5') }}
    </div>
@endsection