import axios from "axios";
const API_BASE_URL = process.env.NEXT_PUBLIC_API_BASE_URL;
/**
 * Function to handle user login
 * @param {string} email - User email
 * @param {string} password - User password
 * @returns {Promise} - API response
 */
export const loginUser = async (email, password) => {
    try {
        const response = await axios.post(`${API_BASE_URL}/user-login`, { email, password });
        return response.data;
    } catch (error) {
        throw error.response?.data?.message || "An unexpected error occurred.";
    }
};