export default {
    async login(email, password) {
        try {
            const response = await axios.post('/login', { email, password });
            localStorage.setItem('auth_token', response.data.token);
            return true;
        } catch (error) {
            console.error('Login error:', error.response.data);
            return false;
        }
    },

    async logout() {
        try {
            await axios.post('/logout', {}, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('auth_token')}`
                }
            });
            localStorage.removeItem('auth_token');
            return true;
        } catch (error) {
            console.error('Logout error:', error.response.data);
            return false;
        }
    },

    isAuthenticated() {
        return !!localStorage.getItem('auth_token');
    }
}