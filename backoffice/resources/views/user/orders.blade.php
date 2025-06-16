@php
    use Carbon\Carbon;
@endphp
@extends("layouts.master")
@section("contenuto")
    <div class="container">
        <h1 class="text-center my-5">
            I miei Ordini
        </h1>
        @if (session('success'))
            <div class="alert alert-success my-3">
                {{ session('success') }}
            </div>
        @endif
        <div class="orders">
            @foreach ($invoices as $order)
                <table class="table table-striped my-5">
                    <tr>
                        <th class="d-flex align-items-center gap-2">
                            <div class="dot {{$order->status}}">
                            </div>{{ ucfirst($order->status) . " " . Carbon::parse($order->updated_at)->format("d-m-Y") }}
                        </th>
                        <th>Prodotto</th>
                        <th>Quantità</th>
                        <th>Taglia</th>
                        <th>Prezzo</th>
                    </tr>
                    @foreach ($order->products as $prod)
                        <tr>
                            <td>
                                <img src="{{asset("storage/prods/$prod->img")}}" alt="...">
                            </td>
                            <td>
                                {{$prod->nome}}
                            </td>
                            <td>
                                {{$prod->pivot->quantita}}
                            </td>
                            <td>
                                {{$prod->pivot->taglia}}
                            </td>
                            <td>
                                @if ($prod->scontato)
                                    <div class="d-flex gap-2">
                                        <p class="card-text">
                                            {{ $prod->prezzo - ($prod->prezzo / 100 * $prod->sconto)  }}€
                                        </p>
                                        <p class="card-text">
                                            <b>
                                                (-{{ $prod->sconto }}%)
                                            </b>
                                        </p>
                                    </div>
                                @else
                                    {{ $prod->prezzo }}€
                                @endif
                            </td>
                        </tr>
                        @if ($order->status == "consegnato" && !$prod->reviews->pluck("utente")->contains(Auth::user()->name))

                            <tr>
                                <div class="w-100">
                                    <td colspan="5" class="text-center">
                                        <a href="{{ route("user.writeReview", $prod->id) }}" class="btn btn-primary">
                                            Scrivi una Recensione
                                        </a>
                                    </td>
                                </div>
                            </tr>

                        @endif
                    @endforeach
                    <tr>
                        <td>
                            <b>
                                {{$order->ship->nome}}
                            </b>
                        </td>
                        <td>{{ $order->address->nome . " " . $order->address->cognome }}</td>
                        <td>{{ $order->address->indirizzo . " " . $order->address->civico }}</td>
                        <td>
                            {{ $order->address->localita . " (" . $order->address->provincia . ") " . $order->address->cap }}
                        </td>
                        <td>
                            {{ $order->ship->costo }}€
                        </td>
                    </tr>
                    @if ($order->coupon)
                        <tr>
                            <td colspan="4">
                                Coupon <b>{{$order->coupon}}</b>
                            </td>
                            <td>
                                <b>
                                    - {{ config("coupons")[$order->coupon] }}%
                                </b>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="3"></td>
                        <td><b>Totale:</b></td>
                        <td><b>
                                {{ number_format($order->costo, 2, ",", ".") }}€
                            </b>
                        </td>
                    </tr>
                    @if ($order->note)
                        <tr>
                            <td>Note ordine:</td>
                            <td colspan="4">
                                {{ $order->note }}
                            </td>
                        </tr>
                    @endif
                    @if ($order->status == "spedito")
                        <tr>
                            <td colspan="4"></td>
                            <td>
                                <a href="{{ route("user.orderReceived", $order->id) }}" class="btn btn-success fs-4">
                                    Conferma Consegna
                                </a>
                            </td>
                        </tr>
                    @endif

                </table>
                <hr>
            @endforeach
        </div>
        {{ $invoices->links('pagination::bootstrap-5') }}
    </div>
@endsection
@section("titolo", "I miei Ordini")