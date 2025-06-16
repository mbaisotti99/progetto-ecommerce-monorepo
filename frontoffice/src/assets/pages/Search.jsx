import axios from "axios"
import { useEffect, useState } from "react"
import { useParams } from "react-router-dom"
import ProdCard from "../components/ProdCard"

const Search = () =>{
    
    
    const {search} = useParams()

    const [prods, setProds] = useState([])

    const [errMsg, setMsg] = useState("Loading...")
    
    useEffect(() =>{
        axios.get(import.meta.env.VITE_API_URL + "api/prods/search/" + search)
        .then((resp) =>{
            setProds([])
            if (resp.data.success == true){
                setProds(resp.data.data)
            } else{
                setMsg(resp.data.message)
            }
        })
    },[search])

    useEffect(() => {
        setMsg("Loading...")
        setProds([])
    }, [search])

    return(

        <div className="container">
            <h1 className="text-center my-5">
                Risultati per {search}
            </h1>

            {
                (prods.length == 0) ?
                    <div className={`alert ${errMsg == "Loading..." ? "alert-warning" : "alert-danger"} text-center`}>
                        {errMsg}
                    </div>
                    :
                    <div className="row">

                        {prods.map((prod, i) =>{
                            return(
                                <div className="col-4" key={i}>
                                    <ProdCard 
                                    prod = {prod}
                                    />
                                </div>
                            )
                        })}
                    </div>
                
            }

        </div>

    )
}

export default Search