@extends("layouts.master")
@section("titolo", "Gestisci Ordini")

@section("contenuto")
    <div class="container">
        <h1 class="text-center my-5">
            Ordini di {{ $user->name }}
        </h1>
        @foreach ($user->invoices as $invoice)
                <div class="invCont mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="my-3">#{{ $invoice->codice }}</h2>
                        <div class="d-flex gap-2">
                            <div class="dot {{$invoice->status}}"></div>
                            {{ ucfirst($invoice->status) . " " . Carbon\Carbon::parse($invoice->updated_at)->format("d-m-Y") }}
                        </div>
                    </div>
                    <x-invoice-card :invoice="$invoice" />
                    @if ($invoice->note)
                        <div class="my-5">
                            <h4>Note Ordine:</h4>
                            <p>
                                {{ $invoice->note }}
                            </p>
                        </div>
                    @endif
                </div>
                @if ($invoice->status == "confermato")
                <div class="orderTools">
                    <button type="button" class="btn btn-warning fs-3" data-bs-toggle="modal"
                        data-bs-target="#cancelOrder{{$invoice->codice}}Modal">
                        Annulla
                    </button>
                    <button type="button" class="btn btn-success fs-3" data-bs-toggle="modal"
                        data-bs-target="#shipOrder{{ $invoice->id }}Modal">
                        Spedisci
                    </button>
                </div>
                @endif
                <hr class="my-5">

                <!-- Cancella  -->
                <div class="modal fade" id="cancelOrder{{$invoice->codice}}Modal" tabindex="-1"
                    aria-labelledby="cancelOrder{{$invoice->codice}}ModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="cancelOrder{{$invoice->codice}}ModalLabel">Cancella Ordine</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{route("admin.changeOrderStatus", $invoice->id)}}" method="POST">
                                @csrf
                                @method("PUT")
                                <input type="hidden" name="status" value="annullato">
                                <div class="modal-body">
                                    <p class="card-text">
                                        Sei sicuro di voler cancellare questo ordine?
                                    </p>
                                    <label for="notes" class="form-label">Motivo della cancellazione:</label>
                                    <textarea class="form-control" required name="notes" id="notes"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                    <button type="submit" class="btn btn-danger">Cancella</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Spedisci  -->
            <div class="modal fade" id="shipOrder{{ $invoice->id }}Modal" tabindex="-1"
                aria-labelledby="shipOrder{{ $invoice->id }}ModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="shipOrder{{ $invoice->id }}ModalLabel">Spedisci Ordine</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{route("admin.changeOrderStatus", $invoice->id)}}" method="POST">
                            @csrf
                            @method("PUT")
                            <input type="hidden" name="status" value="spedito">
                            <div class="modal-body">
                                <p>
                                    Conferma spedizione per ordine {{ $invoice->codice }}?
                                </p>
                                <label for="notes" class="form-label">Note Ordine:</label>
                                <textarea class="form-control" name="notes" id="notes"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <button type="submit" class="btn btn-success">Conferma</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        @endforeach
    </div>
@endsection