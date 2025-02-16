import ApiService from '../services/api.service';

class AuthController {
    async login(email, password) {
        return await ApiService.request('AUTH.LOGIN', { email, password });
    }

    async logout() {
        return await ApiService.request('AUTH.LOGOUT');
    }

    async refreshToken() {
        return await ApiService.request('AUTH.REFRESH');
    }
}

export default new AuthController(); 