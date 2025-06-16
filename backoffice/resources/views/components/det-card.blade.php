@props(["prod"])

<div class="card text-center detCard">
    @if (isset($prod->hot))
        <div class="hot">
            <p>HOT</p>
        </div>
    @endif
    <img src="{{ asset("storage/loading.gif") }}" data-src="{{asset("storage/prods/$prod->img")}}" alt="..."
        class="detImg lazy-load">
    <form action="{{ route("user.addToCart", $prod) }}" method="POST">
        @csrf
        <div class="card-body">
            <h5 class="card-title">{{ucfirst($prod->nome)}}</h5>
            <p class="card-title">{{ucfirst($prod->categoria)}}</p>
            {{ $prod->descrizione }}
            <!-- <p class="card-title">{{implode(" - ", $prod->taglie)}}</p> -->
            <br>
            <div class="tagliaCont">
                <label class="mt-3" for="taglia">Taglia:</label>
                <select name="taglia" id="taglia" class="form-control text-center" style="width:50px; ">
                    @foreach ($prod->taglie as $taglia)
                        <option value="{{ $taglia }}">{{$taglia}}</option>
                    @endforeach
                </select>
            </div>
            <p class="card-text d-flex align-items-center w-100 justify-content-center gap-2 mt-3">
                @php
                    $revs = $prod->reviews;
                    $somma = 0;
                    foreach ($revs as $rev) {
                        $somma += $rev->voto;
                    }

                    $avg = $somma / count($revs);
                  @endphp
                {{ round($avg, 2) }} <i class="bi bi-star-fill" style="color: gold; font-size: 22px;"></i>
            </p>
            <div class="d-flex gap-2 w-100 justify-content-center">
                <p class="card-title fs-2 {{ $prod->scontato ? "oldPrice" : "" }}">
                    <b>
                        {{ $prod->prezzo }}€
                    </b>
                </p>
                @if ($prod->scontato)
                    <p class="card-title fs-2 discountedPrice">
                        {{ $prod->prezzo - ($prod->prezzo / 100 * $prod->sconto)  }}€
                    </p>
                @endif
            </div>
            <button type="submit" class="btn">
                <i class="bi bi-cart2"></i>
            </button>
    </form>
</div>
</div>