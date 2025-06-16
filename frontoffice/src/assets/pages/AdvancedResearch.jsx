import axios from "axios"
import React, { useEffect, useState } from "react"
import Slider from 'rc-slider'
import 'rc-slider/assets/index.css'
import { capitalize } from "../../App"
import ProdCard from "../components/ProdCard"


const AdvancedResearch = () => {


    const [priceRange, setRange] = useState([0, 500])

    const [results, setResults] = useState([])

    const [errMsg, setErrMsg] = useState("")

    const [err, setErr] = useState(false)

    const initialValues = {
        "nome": "",
        "categoria": [],
        "prezzoMin": 0,
        "prezzoMax": 500,
        "isTagliaFiltered": false,
        "taglie": [],
        "discounted": false
    }

    const taglieArr = ["XS", "S", "M", "L", "XL", "XXL"]

    const [searchVals, setSearchVals] = useState({
        ...initialValues
    })

    const [cats, setCats] = useState([])

    const [isTagliaFiltered, setTagliaFiltered] = useState(false)


    useEffect(() => {
        axios.get(import.meta.env.VITE_API_URL + "api/cats")
            .then((resp) => {
                setCats(resp.data.data)
                setSearchVals((prev) => ({
                    ...prev,
                    "categoria": resp.data.data,
                }));
            })
    }, [])

    const onSubmit = (e) => {
        e.preventDefault()

        setErr(false)

        setErrMsg("Caricamento...")

        if (searchVals.taglie = []) {
            setSearchVals((prev) => ({
                ...prev,
                "isTagliaFiltered": false,
            }));
        }

        axios.post(import.meta.env.VITE_API_URL + "api/advancedSearch", searchVals)
            .then((resp) => {
                
                const result = resp.data
                if (result.success) {
                    setResults(result.data)
                    setErrMsg(`${result.data.length == 1 ? "Trovato " : "Trovati "} ${result.data.length} ${result.data.length == 1 ? " risultato" : " risultati"}`)
                } else {
                    setErrMsg(result.message)
                    setErr(true)
                    setResults([])
                }

            })

    }

    const setTagliaFilter = (e) => {
        const { checked } = e.target

        if (checked) {
            setTagliaFiltered(true)
            setSearchVals((prev) => ({
                ...prev,
                "isTagliaFiltered": true,
            }));
        } else {
            setTagliaFiltered(false)
            setSearchVals((prev) => ({
                ...prev,
                "isTagliaFiltered": false,
            }));
        }


    }


    const onChange = (e) => {

        const { name, value, checked } = e.target;


        if (name == "taglie") {
            setSearchVals((prev) => {
                const updatedTaglie =
                    checked ? [...prev.taglie, value]
                        : prev.taglie.filter((taglia) => taglia !== value)

                return {
                    ...prev,
                    taglie: updatedTaglie
                }
            })
        } else if (name == "categoria") {
            setSearchVals((prev) => ({
                ...prev,
                "categoria": value == cats ? cats : [value],
            }));
        }else if (name == "discounted"){

            setSearchVals((prev) =>{
                return{
                    ...prev,
                    "discounted" : checked ? true : false,
                }
            })

        } else {
            setSearchVals((prev) => ({
                ...prev,
                [name]: value,
            }));
        }
         
    }

    const changePrice = (range) => {
        setRange(range)

        setSearchVals((prev) => ({
            ...prev,
            "prezzoMin": range[0],
            "prezzoMax": range[1],
        }));

    }

    return (
        <div className="container">
            <h1 className="text-center my-5">
                Ricerca Avanzata:
            </h1>
            <form className="advRes row mb-5" onSubmit={onSubmit}>

                {/* Nome */}
                <div className="col-6">
                    <label htmlFor="nome" className="form-label">Nome:</label>
                    <input onChange={onChange} type="text" name="nome" className="form-control" value={searchVals.nome} />
                </div>

                {/* Categoria */}
                <div className="col-6">
                    <label htmlFor="categoria" className="form-label">Categoria:</label>
                    <select onChange={onChange} name="categoria" id="categoria" className="form-control">
                        <option value={cats} selected>Qualunque</option>
                        {
                            cats.map((cat, i) => {
                                return (
                                    <option value={cat} key={i}>{capitalize(cat)}</option>
                                )
                            })
                        }
                    </select>
                </div>


                {/* Prezzo Min-Max */}
                <div className="col-6">
                    <div className="slideDiv">
                        <div className="d-flex justify-content-around mb-3">
                            <div className="d-flex align-items-center justify-content-center">
                                    Range Prezzo
                            </div>
                            <div className="disc">
                                <label htmlFor="discounted">Scontato</label>
                                <input onChange={onChange} type="checkbox" name="discounted" id="discounted" />
                            </div>
                        </div>
                        <div className="w-100 d-flex justify-content-between">
                            <p>Minimo {priceRange[0]}€</p>
                            <p>Massimo {priceRange[1]}€</p>
                        </div>
                        <div className="w-100 d-flex justify-content-center">
                            <Slider
                                range
                                min={0}
                                max={500}
                                step={1}
                                value={priceRange}
                                onChange={changePrice}
                                allowCross={false}
                                trackStyle={[{ backgroundColor: "#0d6efd" }]}
                                handleStyle={[
                                    { borderColor: "#0d6efd" },
                                    { borderColor: "#0d6efd" }
                                ]}
                            />
                        </div>
                    </div>
                </div>


                {/* Taglia */}
                <div className="col-6">
                    <div className="my-3 text-center">
                        <label htmlFor="tagliaFilter">Filtra per taglie</label>
                        <input id="tagliaFilter" className="ms-3" type="checkbox" onChange={setTagliaFilter} />
                    </div>
                    <div className="row">
                        {
                            isTagliaFiltered ?
                                taglieArr.map((taglia, i) => {
                                    return (
                                        <div className="col-4 mb-3" key={i}>
                                            <input onChange={onChange} type="checkbox" name="taglie" value={taglia} id={taglia + "box"} />
                                            <label htmlFor={taglia + "box"}>{taglia}</label>
                                        </div>
                                    )
                                })
                                :
                                ""
                        }
                    </div>
                </div>


                <div className="d-flex justify-content-center align-items-center">
                    <button className="btn btn-primary fs-3 d-flex align-items-center" style={{ height: "50px", width: "100px" }}>
                        Cerca
                    </button>
                </div>


            </form>

            <div className="resultContAdv row">
                {
                    errMsg ?
                        <div className={`alert text-center ${err ? "alert-danger" : "alert-info"}`}>
                            {errMsg}
                        </div>
                        :
                        ""
                }
                {
                    results.length > 0 && results.map((prod) => {
                        return (
                            <div className="col-12 col-md-6 col-lg-4">
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

export default AdvancedResearch