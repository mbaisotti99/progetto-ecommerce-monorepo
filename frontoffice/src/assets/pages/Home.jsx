import axios from "axios"
import { useEffect, useState } from "react"
import ProdCard from "../components/ProdCard"

const Home = () => {

    const [prods, setProds] = useState([])
    const [discProds, setDiscProds] = useState([])

    useEffect(() => {
        axios.get(import.meta.env.VITE_API_URL + "api/prods/")
            .then((resp) => {
                let bestProds = resp.data.data.sort((a, b) => b.average_rating - a.average_rating)
                setProds(bestProds.slice(0, 6))


                let discProds = resp.data.data.filter((prod) => {
                    return prod.scontato == 1
                })
                discProds = discProds.sort((a, b) => b.sconto - a.sconto)
                setDiscProds(discProds.slice(0, 6))
            })
    }, [])

    return (
        <div className="container">
            <div className="d-flex justify-content-between align-items-center">
                <h1 className="text-center my-5">Prodotti in Evidenza</h1>
                <a href="/prods" className="btn btn-outline-primary d-flex
align-items-center fs-3" style={{ height: "50px" }}>
                    Sfoglia Catalogo
                </a>
            </div>

            <div className="row">
                {
                    prods.length > 0 ? prods.map((prod, i) => {
                        return (
                            <div className="col-12 col-md-6 col-lg-4" key={prod.id}>
                                <ProdCard
                                    prod={prod}
                                />
                            </div>
                        )
                    })
                        :
                        <div className="cent">
                            <img src="/loading.gif" alt="loading" />
                        </div>
                }
            </div>
            <h1 className="text-center my-5">Occasioni</h1>
            <div className="row">

                {
                    discProds.length > 0 ? discProds.map((prod) => {
                        return (
                            <div className="col-12 col-md-6 col-lg-4" key={prod.id}>
                                <ProdCard
                                    prod={prod}
                                />
                            </div>
                        )
                    })
                        :
                        <div className="cent">
                            <img src="/loading.gif" alt="loading" />
                        </div>
                }
            </div>
        </div>
    )
}

export default Home