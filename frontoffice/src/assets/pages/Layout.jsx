import { Outlet } from "react-router-dom"
import Header from "../components/Header"
import Footer from "../components/Footer"
import axios from "axios"
import { useEffect, useState } from "react"

const Layout = () => {
    const [cats, setCats] = useState([])

    useEffect(() => {
        axios.get("http://127.0.0.1:8000/api/cats")
            .then((resp) => {
                setCats(resp.data.data)
            })
    }, [])
    return (
        <>
                <Header
                    cats={cats} />
                <main>
                    <Outlet />
                </main>
                <Footer />
        </>
    )
}

export default Layout