<template>
  <div class="login-wrapper">
    <div class="modern-login-card">
      <div class="login-header">
        <h2 class="login-title">Iniciar Sesión</h2>
        <p class="login-subtitle">Ingresa tus credenciales para continuar</p>
      </div>

      <form @submit.prevent="handleLogin" class="login-form">
        <div class="input-group" :class="{ 'input-error': errors.email }">
          <label>Correo Electrónico</label>
          <div class="input-container">
            <input
              v-model="form.email"
              type="email"
              placeholder="tu@email.com"
              @input="clearError('email')"
            >
            <span class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
              </svg>
            </span>
          </div>
          <span class="error-message">{{ errors.email }}</span>
        </div>

        <div class="input-group" :class="{ 'input-error': errors.password }">
          <label>Contraseña</label>
          <div class="input-container">
            <input
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="••••••••"
              @input="clearError('password')"
            >
            <span class="icon clickable" @click="showPassword = !showPassword">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
              </svg>
            </span>
          </div>
          <span class="error-message">{{ errors.password }}</span>
        </div>

        <button type="submit" class="login-button" :disabled="loading">
          <span v-if="!loading">Ingresar</span>
          <span v-else class="spinner"></span>
        </button>

        <div v-if="authError" class="error-banner">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
          </svg>
          {{ authError }}
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import AuthService from './AuthService';

export default {
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      errors: {
        email: '',
        password: ''
      },
      authError: '',
      loading: false,
      showPassword: false
    }
  },
  methods: {
    clearError(field) {
      this.errors[field] = '';
      this.authError = '';
    },
    validateForm() {
      let isValid = true;
      this.errors = { email: '', password: '' };

      if (!this.form.email) {
        this.errors.email = 'Email requerido';
        isValid = false;
      } else if (!/^\S+@\S+\.\S+$/.test(this.form.email)) {
        this.errors.email = 'Email inválido';
        isValid = false;
      }

      if (!this.form.password) {
        this.errors.password = 'Contraseña requerida';
        isValid = false;
      } else if (this.form.password.length < 6) {
        this.errors.password = 'Mínimo 6 caracteres';
        isValid = false;
      }

      return isValid;
    },
    async handleLogin() {
      if (!this.validateForm()) return;

      try {
        this.loading = true;
        this.authError = '';
        
        await AuthService.login(this.form.email, this.form.password);
        this.$router.push('/home');
      } catch (error) {
        this.authError = error.response?.data?.message || 'Credenciales incorrectas';
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>

<style scoped>
.login-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f8fafc;
  padding: 20px;
}

.modern-login-card {
  width: 100%;
  max-width: 400px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
  padding: 40px;
  border: 1px solid #e2e8f0;
}

.login-header {
  text-align: center;
  margin-bottom: 32px;
}

.login-title {
  font-size: 24px;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 8px;
}

.login-subtitle {
  font-size: 14px;
  color: #64748b;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.input-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.input-group label {
  font-size: 14px;
  font-weight: 500;
  color: #475569;
}

.input-container {
  position: relative;
}

.input-container input {
  width: 100%;
  padding: 12px 16px 12px 40px;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 14px;
  transition: all 0.2s;
  background-color: #f8fafc;
}

.input-container input:focus {
  outline: none;
  border-color: #6366f1;
  box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
}

.input-error .input-container input {
  border-color: #ef4444;
}

.input-error .input-container input:focus {
  box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
}

.icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
}

.clickable {
  cursor: pointer;
}

.error-message {
  font-size: 12px;
  color: #ef4444;
  height: 16px;
}

.login-button {
  background-color: #6366f1;
  color: white;
  border: none;
  padding: 12px;
  border-radius: 8px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  margin-top: 8px;
}

.login-button:hover {
  background-color: #4f46e5;
}

.login-button:disabled {
  background-color: #c7d2fe;
  cursor: not-allowed;
}

.spinner {
  display: inline-block;
  width: 16px;
  height: 16px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top-color: white;
  animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.error-banner {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px;
  background-color: #fee2e2;
  color: #b91c1c;
  border-radius: 6px;
  font-size: 14px;
  margin-top: 12px;
}
</style>