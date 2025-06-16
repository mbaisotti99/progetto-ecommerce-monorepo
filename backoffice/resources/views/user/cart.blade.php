@extends("layouts.master")
@section("contenuto")

    @php
        $grandTotal = null;
        session_start();
        if ($order) {
            $grandTotal = 0;
            if ($order->coupon) {
                $validCoupon = config("coupons")[$order->coupon];
            }

            $sconto = false;
            foreach ($order->products as $prod) {
                if ($prod->scontato) {
                    $sconto = $prod->prezzo / 100 * $prod->sconto;
                }
                if ($prod->pivot->quantita == 1) {
                    $grandTotal += !$prod->scontato ? $prod->prezzo : $prod->prezzo - $sconto;
                } else {
                    $totaleProd = (!$prod->scontato ? $prod->prezzo : $prod->prezzo - $sconto) * $prod->pivot->quantita;
                    $grandTotal += $totaleProd;
                }
            }

            if (isset($validCoupon) && $validCoupon) {
                $grandTotal -= $grandTotal / 100 * $validCoupon;
            }

            $grandTotal = round($grandTotal, 2);
        }

        $_SESSION["total"] = $grandTotal;

    @endphp


    <div class="container d-flex justify-content-center align-items-center h-100 pb-5">
        @if ($order && count($order->products->toArray()) > 0)
            <div class="row w-100 mt-5">

                @foreach ($order->products as $prod)
                    <div class="col-12">
                        <x-cart-card :prod="$prod">
                        </x-cart-card>
                    </div>

                @endforeach
                @if(session('error'))
                    <div class="d-flex w-100 justify-content-center  my-3">
                        <div class="alert alert-danger w-50 text-center">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
                <div class="col-12 d-flex justify-content-between ">
                    <form class="d-flex gap-2 align-items-center" action="{{ route("user.applyCoupon") }}" method="POST">
                        @csrf
                        <label for="coupon">Coupon: </label>
                        <input required type="text" id="coupon" name="coupon" class="form-control" style="width: 150px">
                        <button class="btn btn-outline-primary" {{ isset($validCoupon) && $validCoupon ? "disabled" : "" }}>Applica</button>
                        @if (isset($validCoupon) && $validCoupon)
                            <div class="alert alert-success" style="width: 250px">
                                Applicato sconto del {{ $validCoupon }}%
                            </div>
                        @endif
                    </form>
                    <p class="fs-2 mt-5">
                        <b>
                            Totale: {{ number_format($grandTotal, 2, ",", ".") }}€
                        </b>
                    </p>
                </div>
                <div class="col-12 d-flex justify-content-around mt-5">
                    <a href="{{ route("home") }}" class="btn btn-primary">Continua lo shopping</a>
                    <a href="{{ route("order.checkout") }}" class="btn btn-success">Procedi al Checkout</a>
                </div>
            </div>
        @else
            <div class="alert alert-dark">
                <h1>Nessun prodotto nel carrello</h1>
            </div>
        @endif
    </div>

@endsection

@section("titolo", "Carrello")