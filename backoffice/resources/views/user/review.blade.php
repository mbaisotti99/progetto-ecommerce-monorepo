@extends("layouts.master")
@section("titolo", "Scrivi una recensione")
@section("contenuto")
    <script>
        const starChange = (e) => {

            const value = parseInt(e.target.value)            

            for (let i = 0; i < 5; i++) {
                const star = document.getElementById("star" + i)
                if (i < value) {
                    star.style.color = "gold"
                } else {
                    star.style.color = "black"
                }
            }
        }

    </script>
    <div class="container">
        <h1 class="text-center my-5">
            Scrivi una Recensione per {{ $prod->nome }}
        </h1>
        <div class="row writeRevCont">
            <div class="col-6 p-0">
                <img src="{{ asset("storage/prods/$prod->img") }}" alt="{{ $prod->nome }}" width="100%" class="revCardImg">

            </div>
            <div class="col-6">
                <form action="{{ route("user.storeReview", $prod->id) }}" class="cent row revForm py-3" method="POST">
                    @csrf
                    <div class="col-12 d-flex gap-2">
                        @for ($i = 0; $i < 5; $i++)
                            <label for="input{{ $i }}">
                                <i class="bi-star-fill star" id="star{{$i}}" style="color: black;">
                                </i>
                            </label>
                            <input style="display: none;" onchange="starChange(event)" type="radio" name="stars" id="input{{$i}}" value={{$i + 1}}>
                        @endfor
                    </div>
                    <div class="col-12 pt-4 flex-column">
                        <label for="text" class="form-label text-center fs-4">Descrivi la tua esperienza con il prodotto:</label>
                        <textarea required name="text" id="text" class="form-control" cols="10" rows="5"></textarea>
                    </div>
                    <div class="col-12 justify-content-center mt-5">
                        <button type="submit" class="btn btn-primary fs-4">Invia Recensione</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection