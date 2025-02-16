'use client';
const API_BASE_URL = process.env.NEXT_PUBLIC_API_BASE_URL;
import axios from "axios";
import { useRouter } from "next/navigation";
import Cookies from "js-cookie";
import toast from "react-hot-toast";

export default function LogoutButton() {
    const { push } = useRouter();

    const handleLogout = async () => {
        try {
            await axios.get(`${API_BASE_URL}/user-logout`); // Hit logout API
            Cookies.remove("authToken");
            toast.success("Logout successful!");
            push("/");
        } catch (error) {
            console.error("Logout failed:", error);
        }
    };

    return <button className="nav-link" onClick={handleLogout}>Logout</button>;
}
