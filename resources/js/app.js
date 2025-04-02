import { createApp } from 'vue';
import App from '@/App.vue';
import router from '@/router';
import axios from 'axios';
import 'bootstrap';
import Login from '@/auth/Login.vue'; // Asegúrate de tener esta ruta correcta
import AuthService from '@/auth/AuthService'; // Importa el servicio de autenticación

// Configuración de Axios
window.axios = axios;
window.axios.defaults.baseURL = 'http://localhost:8000/api';
window.axios.defaults.headers.common['Accept'] = 'application/json';

// Crea la aplicación Vue
const app = createApp(App); // Usa tu componente App.vue como raíz

// Configuración global
app.use(router);

// Componentes globales
app.component('login-component', Login);

// Monta la aplicación
app.mount('#app');

// Verificación de autenticación (opcional, mejor hacerlo en el router)
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !AuthService.isAuthenticated()) {
    next('/login');
  } else {
    next();
  }
});