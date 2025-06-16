import { useState } from "react"
import { capitalize } from "../../App"
import { useNavigate } from "react-router-dom"


const Header = ({cats}) => {

    const navigate = useNavigate()

    const [search, setSearch] = useState("")

    const handleChange = (event) =>{
        const {value} = event.target

        setSearch(value)
        console.log(search);
        
    }

    const handleSubmit = () =>{

        navigate("/prods/search/" + search)
    }

    return (
        <header>
            <nav>
                <ul className="navBar cleanList">
                    <li>
                        <a href="/" className="navLink">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="/prods" className="navLink">Catalogo</a>
                    </li>
                        <li className="nav-item dropdown">
                            <a className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Categorie
                            </a>
                            <ul className="dropdown-menu">
                                {cats.map((cat, i) => {
                                    return (
                                        <li key={i}><a className="dropdown-item" href={"/prods/cat/" + cat}>{capitalize(cat)}</a></li>
                                    )
                                })}
                            </ul>
                        </li>
                    <li>
                        <a href="/advanced-research" className="navLink">Ricerca avanzata</a>
                    </li>
                </ul>
            </nav >
            <div className="headTools">
                <a href="http://127.0.0.1:8000/login" className="btn btn-primary align-items-center d-flex fs-4" style={{height:"40px"}}>Accedi</a>
                <form action={handleSubmit} className="d-flex gap-3">
                    
                    <input onChange={handleChange} value={search} type="text" name="search" id="search" className="form-control" style={{height:"40px"}}/>
                    <button className="btn" type="submit">
                        <i className="bi-search" style={{fontSize:"30px", color:"white"}}></i>
                    </button>
                </form>
            </div>
        </header >
    )
}

export default Header