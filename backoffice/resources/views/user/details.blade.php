@extends("layouts.master")
@section("contenuto")
    @php

        $user = Auth::user();

    @endphp
    <div class="container cent">

        <div class="card text-center fs-2  mt-5 ">
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Nome</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email Verificata?</th>
                    <td>{{ $user->email_verified_at ? $user->email_verified_at : "Non Verificata" }}</td>
                </tr>
                <tr>
                    <th>Ruolo</th>
                    <td>{{ $user->role }}</td>
                </tr>
            </table>
            <a href="{{ route("logout") }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn btn-warning">Esci</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

        <div class="card my-5 text-center p-5">
            <h1>I miei Indirizzi</h1>
            @if (count($user->addresses) > 0)

                <table class="table-striped table">
                    <tr>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Indirizzo</th>
                        <th>Localita</th>
                        <th>CAP</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach ($user->addresses as $address)
                        <tr>
                            <td>
                                {{$address->nome}}
                            </td>
                            <td>
                                {{$address->cognome}}
                            </td>
                            <td>
                                {{$address->indirizzo . " " . $address->civico}}
                            </td>
                            <td>
                                {{$address->localita . " (" . $address->provincia . ")"}}
                            </td>
                            <td>
                                {{$address->cap}}
                            </td>
                            <td>
                                <a href="{{ route("address.edit", $address) }}" class="btn btn-warning">Modifica</a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    Elimina
                                </button>
                                <!-- <a href="{{ route("address.destroy", $address) }}" class="btn btn-danger">Elimina</a> -->
                            </td>
                        </tr>

                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="deleteModalLabel">Elimina Indirizzo</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Sei sicuro di voler eliminare questo indirizzo?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form action="{{route("address.destroy", $address)}}" method="POST">
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

            @else
                <div class="alert text-bg-secondary">
                    <h2 class="text-center p-3">Nessun Indirizzo</h2>
                </div>
            @endif
            <a href="{{ route("address.create") }}" class="btn btn-primary mt-5">Crea nuovo</a>
        </div>

    </div>

@endsection

@section("titolo", "Profilo")