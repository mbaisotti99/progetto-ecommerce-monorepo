@extends("layouts.master")
@section("titolo", "Ordini Admin")
@section("contenuto")
    <div class="container">
        <h1 class="text-center my-5">
            Gestisci gli ordini degli utenti
        </h1>
        <div class="row">
            @foreach ($users as $user)
                @php
                    $orderToShip = 0;
                    $successfulOrders = 0;
                @endphp
                <div class="col-4">
                    <div class="userAdminCard {{ $user->role == "admin" ? "adminOrder" : "userOrder" }}">
                        <div class="d-flex gap-2 align-items-center">
                            <h3>{{ $user->name }}</h3>
                            @if ($user->role == "admin")
                                <div class="badge text-bg-danger mb-3">Admin</div>
                            @endif
                        </div>
                        <p class="card-text">
                            {{ $user->email }}
                        </p>
                        @if (count($user->invoices->toArray()) == 0)
                            <p class="card-text">
                                L'utente non ha effettuato nessun ordine
                            </p>
                        @else
                            @foreach ($user->invoices as $order)
                                @php
                                    if ($order->status == "confermato") {
                                        $orderToShip++;
                                    } else if ($order->status == "consegnato") {
                                        $successfulOrders++;
                                    }
                                @endphp
                            @endforeach
                            @if ($orderToShip > 0)
                                <div class="d-flex gap-2 mb-3">
                                    <div class="dot confermato"></div>
                                    <p class="card-text ">
                                        {{ $orderToShip }} ordin{{ $orderToShip == 1 ? "e" : "i" }} in attesa di spedizione
                                    </p>
                                </div>
                            @endif
                            @if ($successfulOrders > 0)
                                <div class="d-flex gap-2 mb-3">
                                    <div class="dot consegnato"></div>
                                    <p class="card-text">
                                        {{ $successfulOrders }} ordin{{ $successfulOrders == 1 ? "e" : "i" }}
                                        ricevut{{ $successfulOrders == 1 ? "o" : "i" }} con successo
                                    </p>
                                </div>
                            @endif
                            <a href="{{route("admin.showOrders", $user->id)}}" class="btn btn-primary">Visualizza Ordini</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection