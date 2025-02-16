import LogoutButton from "./LogoutButton";

export default function Navbar() {
    return <>
        <nav className="navbar navbar-expand-lg navbar-dark bg-primary">
            <div className="container">
                <a className="navbar-brand" href="#">
                    SkillMatch
                </a>
                <button
                    className="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span className="navbar-toggler-icon" />
                </button>
                <div className="collapse navbar-collapse" id="navbarNav">
                    <ul className="navbar-nav ms-auto">
                        <li className="nav-item">
                            <a className="nav-link" href="">
                                Profile
                            </a>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link" href="#">
                                Settings
                            </a>
                        </li>
                        <li className="nav-item">
                            <LogoutButton />
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </>;
}