// src/services/api.js
import axios from 'axios';

const API_URL = process.env.NEXT_PUBLIC_API_BASE_URL;

export const registerUser = async (userData) => {
    try {
        const response = await axios.post(API_URL + '/user-register', userData, {
            headers: {
                'Content-Type': 'application/json',
            },
        });
        return response.data;
    } catch (error) {
        console.error('Registration failed:', error.response?.data || error.message);
        throw error;
    }
};
