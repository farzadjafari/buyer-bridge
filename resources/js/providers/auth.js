import { reactive } from 'vue';
import axios from "../axios.js";

export const authState = reactive({
   isLoggedIn: localStorage.getItem('token') !== null
});

export function login(token) {
    localStorage.setItem('token', token);
    authState.isLoggedIn = true;
}

export function logout() {
    axios.post('/api/logout', {})
        .then(() => {
            localStorage.removeItem('token');
            authState.isLoggedIn = false;
        })
        .catch(error => {
            console.error('Failed to logout.', error)
        })
}
