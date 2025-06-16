@props(["prod"])

<div class="card text-center">
  @if (isset($prod->hot))
    <div class="hot">
    <p>HOT</p>
    </div>
  @endif

  <img src="{{ asset("storage/loading.gif") }}" data-src="{{asset("storage/prods/$prod->img")}}"
    class="card-img-top lazy-load" alt="{{$prod->nome}}">
  <div class="card-body">
    <h5 class="card-title">{{ucfirst($prod->nome)}}</h5>
    <p class="card-title">{{ucfirst($prod->categoria)}}</p>
    {{ $desc }}
    <p class="card-title">{{implode(" - ", $prod->taglie)}}</p>
    <p class="card-text d-flex align-items-center w-100 justify-content-center gap-2">
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
          {{ number_format($prod->prezzo, 2, ".") }}€
        </b>
      </p>
      @if ($prod->scontato)
        <p class="card-title fs-2 discountedPrice">
          {{ number_format($prod->prezzo - ($prod->prezzo / 100 * $prod->sconto), 2, ".")  }}€
        </p>
      @endif
    </div>
    {{ $add }}
  </div>
</div>