import axios from "axios"
import { useEffect, useRef, useState } from "react"
import ProdCard from "../components/ProdCard"

const Products = () => {

    const [prods, setProds] = useState([])

    const [totalPages, setTotalPages] = useState(null)
    const [curPage, setCurPage] = useState(1)

    // Paginazione

    const navigatePage = (page) => {

        setCurPage(page)
    }

    const printPagesBtns = (n) => {
        let btns = []
        for (let i = 1; i <= n; i++) {
            btns.push(
                <div className="pageBtn" key={i}>
                    <button className="btn" onClick={() => navigatePage(i)}>{i}</button>
                </div>
            )
        }

        return btns
    }

    const [prodPages, setProdPages] = useState([])

    const [err, setErr] = useState("")

    useEffect(() => {
        axios.get(import.meta.env.VITE_API_URL + "api/prods")
            .then((resp) => {

                const products = resp.data.data

                const sorted = products.sort((a, b) =>
                    b.average_rating - a.average_rating);

                setProds(sorted)

            }
            )
            .catch((err) => {
                console.log(err);

                setErr("Errore nel caricamento dei prodotti (" + err.response.status + ")")
            })
    }, [])

    useEffect(() => {
        let pages = []

        for (let i = 0; i < prods.length; i += 9) {
            pages.push(prods.slice(i, i + 9))
        }

        setProdPages(pages)
        setTotalPages(pages.length)
    }, [prods])

    useEffect(() => {
        console.log(prodPages);
    }, [prodPages])


    // Ordina

    const [order, setOrder] = useState("average_rating")
    const [ascOrDesc, setAscOrDesc] = useState(true)
    // Asc = false || Desc = true

    // const isFirstRender = useRef(true)

    useEffect(() => {
        // if (isFirstRender.current) {
        //     isFirstRender.current = false;
        //     return; // Salta l'effetto al mount
        // }
        if (order && prods.length > 0) {

            let sorted = [...prods]

            if (order == "nome") {

                sorted.sort((a, b) => ascOrDesc ? a[order].localeCompare(b[order]) : b[order].localeCompare(a[order]))

            } else if (order == "prezzo") {

                sorted.sort((a, b) => {
                    if (ascOrDesc) {
                        return (
                            (b.scontato == 1 ? b.prezzo - (b.prezzo / 100 * b.sconto) : b.prezzo)
                            -
                            (a.scontato == 1 ? a.prezzo - (a.prezzo / 100 * a.sconto) : a.prezzo)
                        );
                    } else {
                        return (
                            (a.scontato == 1 ? a.prezzo - (a.prezzo / 100 * a.sconto) : a.prezzo)
                            -
                            (b.scontato == 1 ? b.prezzo - (b.prezzo / 100 * b.sconto) : b.prezzo)
                        );
                    }
                });
            } else {

                sorted.sort((a, b) => ascOrDesc ? b.average_rating - a.average_rating : a.average_rating - b.average_rating)

            }

            setProds(sorted)
        }
    }, [order, ascOrDesc])

    const orderBy = (order) => {
        setOrder(order.target.value)
        setCurPage(1)
    }

    const changeAscDesc = (e) => {
        const { value, checked } = e.target

        if (value == "asc" && checked) {
            setAscOrDesc(false)
        } else if (value == "desc" && checked) {
            setAscOrDesc(true)
        }
    }

    return (
        <div className="container">

            <form className="orderBy mt-5">
                <div className="order">
                    <label htmlFor="orderBy" className="form-label">Ordina per </label>
                    <select onChange={orderBy} name="orderBy" id="orderBy" className="form-control" defaultValue="average_rating">
                        <option value="average_rating">Media Recensioni</option>
                        <option value="nome">Nome</option>
                        <option value="prezzo">Prezzo</option>
                    </select>
                </div>
                <div className="ascDesc">
                    <p>Ordine:</p>
                    <label htmlFor="asc">Decrescente {order == "nome" ? "(A-Z)" : "(9-1)"}</label>
                    <input onChange={changeAscDesc
                    } type="radio" name="ascDesc" id="asc" value="asc" />
                    <label htmlFor="desc">Crescente {order == "nome" ? "(Z-A)" : "(1-9)"}</label>
                    <input onChange={changeAscDesc} type="radio" name="ascDesc" id="desc" defaultChecked value="desc" />
                </div>
            </form>

            <h1 className="text-center my-5">
                Catalogo prodotti
            </h1>

            <div className="row">
                {
                    (prodPages.length > 0 && curPage) ? prodPages[curPage - 1]?.map((prod) => {
                        return (
                            <div className="col-4" key={prod.id}>
                                <ProdCard
                                    prod={prod}
                                />
                            </div>
                        )
                    })
                        :

                        err == "" ?

                            <div className="cent">
                                <img src="/loading.gif" alt="loading" />
                            </div>

                            :

                            <div className="alert alert-danger text-center">
                                {err}
                            </div>

                }
            </div>
            {prods.length > 0 &&
                <div className="pagination">
                    <div className="firstPage">
                        <button className="btn pageBtn" onClick={() => navigatePage(1)}> {"<<"} </button>
                    </div>
                    {
                        totalPages && printPagesBtns(totalPages)
                    }
                    <div className="lastPage">
                        <button className="btn pageBtn" onClick={() => navigatePage(totalPages)}> {">>"} </button>
                    </div>
                </div>
            }
        </div>
    )
}

export default Products