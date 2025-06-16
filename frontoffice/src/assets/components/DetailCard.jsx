import { useState } from "react"
import { capitalize } from "../../App"

const DetailCard = ({ prod }) => {

    const [loadedImg, setLoadedImg] = useState(false)
    return (
        <div className="card text-center p-1">
            <div className="w-100 text-center">
                {
                    !loadedImg &&
                    <img src="/loading.gif" alt="loading" className="card-img-top" />
                }
                <img src={import.meta.env.VITE_API_URL + "storage/prods/" + prod.img} alt={prod.nome} style={{ maxHeight: "600px", maxWidth: "600px" }} 
                onLoad={() => setLoadedImg(true)}/>
            </div>
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
                        } (-{prod.sconto}%)</p>
                }
            </div>
            <p className="card-text">
                {prod.descrizione}
            </p>
            <p className="card-text">
                Taglie disponibili: <br />
                <b>
                    {prod.taglie.join(" - ")}
                </b>
            </p>
            <p className="card-text">
                {prod.average_rating.toFixed(2)}
                <i className="bi-star-fill ms-1" style={{ color: "gold" }}></i>
            </p>
            <div className="buy">
                <a href={`http://127.0.0.1:8000/products/${prod.id}`} className="btn btn-primary">Accedi per acquistare</a>
            </div>
        </div>
    )
}


export default DetailCard