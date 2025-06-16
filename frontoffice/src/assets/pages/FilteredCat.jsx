import axios from "axios"
import { useEffect, useState } from "react"
import { useParams } from "react-router-dom"
import ProdCard from "../components/ProdCard"

const FilteredCat = () => {
    const { cat } = useParams()

    const [prods, setProds] = useState([])

    useEffect(() => {
        axios.get(import.meta.env.VITE_API_URL + "api/prods/cat/" + cat)
            .then((resp) => {
                setProds(Object.values(resp.data.data))
            })
    }, [])
    return (
        <div className="container">
            <h1 className="text-center my-5">
                Trova un/a {cat} che fa per te!
            </h1>
            <div className="row">
                {
                    prods.length == 0 ? 
                    <div className="cent">
                        <img src="/loading.gif" alt="loading" />
                    </div>
                        :
                        prods.map((prod, i) => {
                            return (
                                <div className="col-4" key={i}>
                                    <ProdCard
                                        prod={prod}
                                    />
                                </div>
                            )
                        })
                }
            </div>
        </div>
    )
}

export default FilteredCat