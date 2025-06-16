import { useState } from "react"
import { capitalize } from "../../App"

const ProdCard = ({ prod }) => {

    const [loadedImg, setLoadedImg] = useState(false)

    return (
        <div className="card mb-5 text-center" >
            {prod.hot &&
                <div className="hot">
                    <p>HOT</p>
                </div>
            }
            {
                !loadedImg &&
                <img src="/loading.gif" alt="loading" className="card-img-top" />
            }
            <img
                src={import.meta.env.VITE_API_URL + "storage/prods/" + prod.img}
                alt={prod.nome} className="card-img-top"
                onLoad={() => setLoadedImg(true)}
            />
            <p className="card-title mb-3">
                <b>
                    {capitalize(prod.nome)}
                </b>
            </p>
            <p className="card-text">
                {capitalize(prod.categoria)}
            </p>
            <div className="price">
                <p className={`card-text ${prod.scontato ? "oldPrice" : ""}`}>
                    {prod.prezzo}€
                </p>
                {
                    prod.scontato == 1 &&
                    <p className="card-text discountedPrice">{
                        new Intl.NumberFormat("it-IT", { style: "currency", currency: "EUR" }).format(
                            prod.prezzo - prod.prezzo / 100 * prod.sconto,
                        )
                        } </p>
                }
            </div>
            <p className="card-text">
                {prod.average_rating.toFixed(2)}
                <i className="bi-star-fill ms-1" style={{ color: "gold" }}></i>
            </p>
            <a href={"/prods/" + prod.id} className="btn btn-primary mt-2 fs-3">Dettagli</a>
        </div>
    )
}

export default ProdCard