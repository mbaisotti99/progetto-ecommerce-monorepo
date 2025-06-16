import axios from "axios"
import { useEffect, useState } from "react"
import { useParams } from "react-router-dom"
import DetailCard from "../components/DetailCard"

const Details = () => {

    const { id } = useParams()

    const [prod, setProd] = useState({})


    useEffect(() => {
        axios.get(import.meta.env.VITE_API_URL + "api/prods/" + id)
            .then((resp) => {
                setProd(resp.data.data)
            })
    }, [])



    const printStars = (n) => {
        let count = ""
        for (let i = 0; i < n; i++) {
            count += "⭐"
        }
        return count
    }

    return (
        <div className="container detCont">
            {prod.id ?
                <>
                    <div className="prodCont">
                        <DetailCard
                            prod={prod}
                        />
                    </div>
                    <div className="revCont">
                        {prod.reviews && prod.reviews.map((rev, i) => {
                            return (
                                <>
                                    <div className="revBox" key={i}>
                                        <div className="d-flex justify-content-between mb-3">
                                            <h2>
                                                <b>
                                                    {rev.utente}
                                                </b>
                                            </h2>
                                            <p className="card-text">
                                                {rev.data}
                                            </p>
                                        </div>
                                        <p className="text-center w-100">
                                            {printStars(rev.voto)}
                                        </p>
                                        <p className="card-text">
                                            {rev.testo}
                                        </p>
                                    </div>
                                    <hr />
                                </>
                            )
                        })}
                    </div>
                </>
                :
                <div className="cent">
                    <img src="/loading.gif" alt="loading" />
                </div>
            }
        </div>
    )
}

export default Details