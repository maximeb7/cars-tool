import axios from 'axios';

class ApiService {
    constructor() {
        this.apiClient = axios.create({
            baseURL: '/api',
            headers: {
                'Content-Type': 'application/json',
            }
        });

        this.apiClient.interceptors.request.use((config) => {
            const token = localStorage.getItem('authToken');
            if (token) {
                config.headers['Authorization'] = `Bearer ${token}`;
            }
            return config;
        }, (error) => {
            return Promise.reject(error);
        });
    }

    get(url, params = {}) {
        return this.apiClient.get(url, { params });
    }

    post(url, data) {
        return this.apiClient.post(url, data);
    }

}

export default new ApiService();