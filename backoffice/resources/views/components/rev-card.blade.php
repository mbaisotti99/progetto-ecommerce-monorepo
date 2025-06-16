@props(["rev"])
<div class="revCard my-3">
    <div class="d-flex justify-content-between">
        <h4 class="card-title">
            {{ $rev->utente }}
        </h4>
        <div class="d-flex gap-1">
            @for ($i = 0; $i < $rev->voto; $i++)
                <i class="bi bi-star-fill" style="color:gold;"></i>
            @endfor
        </div>
    </div>
    <p class="card-text">
        {{ $rev->testo }}
    </p>
    <p class="text-secondary">
        {{ $rev->data }}
    </p>
</div>