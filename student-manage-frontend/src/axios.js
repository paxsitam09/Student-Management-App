import axios from 'axios';
import { useAuthStore } from '@/stores/authStore'
import { useRouter } from 'vue-router'

const instance = axios.create({
    baseURL: 'http://localhost:8000/api',
    withCredentials: true,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
    }
});

instance.interceptors.request.use(config => {
    const token = sessionStorage.getItem('access_token');
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

instance.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            const authStore = useAuthStore()
            // Clear auth state
            authStore.logout()
            sessionStorage.removeItem('access_token')
            
            // Get current route
            const currentRoute = useRouter().currentRoute.value
            
            // Redirect to login with return path
            useRouter().push({
                name: 'Login',
                query: { redirect: currentRoute.fullPath }
            })
        }
        return Promise.reject(error)
    }
)

export default instance;