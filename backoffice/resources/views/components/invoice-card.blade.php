@props(["invoice"])

<table class="table table-striped invCard">
            <tr>
                <th>
                    Prodotto
                </th>
                <th>
                    Taglia
                </th>
                <th>
                    Quantità
                </th>
                <th>
                    Prezzo
                </th>
            </tr>
            @foreach ($invoice->products as $prod)
                <tr>
                    <td>
                        {{$prod->nome}}
                    </td>
                    <td>
                        {{$prod->pivot->taglia}}
                    </td>
                    <td>
                        {{$prod->pivot->quantita}}
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
            @endforeach
            <tr>
                <td>{{$invoice->ship->nome}}</td>
                <td></td>
                <td>1</td>
                <td>{{$invoice->ship->costo}}€</td>
            </tr>
            @if ($invoice->coupon)
                <tr>
                    <td colspan="3">
                        Coupon <b>{{ $invoice->coupon }}</b>
                    </td>
                    <td>
                        <b>
                            - {{ config("coupons")[$invoice->coupon] }}%
                        </b>
                    </td>
                </tr>
            @endif
            <tr>
                <td></td>
                <td></td>
                <td><b>Totale</b></td>
                <td><b> {{ number_format($invoice->costo, 2, ",", ".") }}€</b></td>
            </tr>
        </table>
        <h2 class="my-3">
            Indirizzo di spedizione
        </h2>
        <div class="card p-4 my-3">
            {{ $invoice->address->nome . " " . $invoice->address->cognome }} <br>
            {{ $invoice->address->indirizzo . " " . $invoice->address->civico }} <br>
            {{ $invoice->address->localita . " (" . $invoice->address->provincia . ") " . $invoice->address->cap }}
        </div>