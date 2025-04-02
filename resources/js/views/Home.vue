<template>
  <div class="container">
    <h1>Bienvenido al Sistema de Pacientes</h1>
    <button @click="handleLogout" class="logout-btn">Cerrar Sesión</button>
    
    <!-- Botón para agregar nuevo paciente -->
    <button @click="showAddModal = true" class="add-btn">Agregar Paciente</button>
    
    <!-- Mensaje de carga/error -->
    <div v-if="loading" class="loading">Cargando pacientes...</div>
    <div v-if="error" class="error">{{ error }}</div>
    
    <!-- Tabla de pacientes -->
    <div class="table-container" v-if="!loading && !error">
      <table>
        <thead>
          <tr>
            <th>Documento</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Género</th>
            <th>Ubicación</th>
            <th>Correo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="paciente in pacientes" :key="paciente.id">
            <td>{{ paciente.numero_documento }}</td>
            <td>{{ paciente.nombre1 }} {{ paciente.nombre2 || '' }}</td>
            <td>{{ paciente.apellido1 }} {{ paciente.apellido2 || '' }}</td>
            <td>{{ getGeneroNombre(paciente) }}</td>
            <td>{{ getUbicacion(paciente) }}</td>
            <td>{{ paciente.correo }}</td>
            <td>
              <button @click="editPaciente(paciente)" class="edit-btn">Editar</button>
              <button @click="confirmDelete(paciente.id)" class="delete-btn">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal para agregar/editar paciente -->
    <div v-if="showAddModal || currentPaciente" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <h2>{{ currentPaciente ? 'Editar Paciente' : 'Agregar Nuevo Paciente' }}</h2>
        
        <form @submit.prevent="submitForm">
          <div class="form-group">
            <label>Tipo Documento:</label>
            <select v-model="formData.tipo_documento_id" required>
              <option v-for="tipo in tiposDocumento" :value="tipo.id" :key="tipo.id">
                {{ tipo.nombre }}
              </option>
            </select>
          </div>
          
          <div class="form-group">
            <label>Número Documento:</label>
            <input type="text" v-model="formData.numero_documento" required>
          </div>
          
          <div class="form-group">
            <label>Primer Nombre:</label>
            <input type="text" v-model="formData.nombre1" required>
          </div>
          
          <div class="form-group">
            <label>Segundo Nombre:</label>
            <input type="text" v-model="formData.nombre2">
          </div>
          
          <div class="form-group">
            <label>Primer Apellido:</label>
            <input type="text" v-model="formData.apellido1" required>
          </div>
          
          <div class="form-group">
            <label>Segundo Apellido:</label>
            <input type="text" v-model="formData.apellido2">
          </div>
          
          <div class="form-group">
            <label>Género:</label>
            <select v-model="formData.genero_id" required>
              <option v-for="genero in generos" :value="genero.id" :key="genero.id">
                {{ genero.nombre }}
              </option>
            </select>
          </div>
          
          <div class="form-group">
            <label>Departamento:</label>
            <select v-model="formData.departamento_id" @change="loadMunicipios" required>
              <option v-for="departamento in departamentos" :value="departamento.id" :key="departamento.id">
                {{ departamento.nombre }}
              </option>
            </select>
          </div>
          
          <div class="form-group">
            <label>Municipio:</label>
            <select v-model="formData.municipio_id" required>
              <option v-for="municipio in municipios" :value="municipio.id" :key="municipio.id">
                {{ municipio.nombre }}
              </option>
            </select>
          </div>
          
          <div class="form-group">
            <label>Correo Electrónico:</label>
            <input type="email" v-model="formData.correo" required>
          </div>
          
          <button type="submit" class="submit-btn">{{ currentPaciente ? 'Actualizar' : 'Guardar' }}</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import AuthService from '../auth/AuthService';
import axios from 'axios';

export default {
  data() {
    return {
      pacientes: [],
      currentPaciente: null,
      showAddModal: false,
      tiposDocumento: [],
      generos: [],
      departamentos: [],
      municipios: [],
      loading: false,
      error: null,
      formData: {
        tipo_documento_id: '',
        numero_documento: '',
        nombre1: '',
        nombre2: '',
        apellido1: '',
        apellido2: '',
        genero_id: '',
        departamento_id: '',
        municipio_id: '',
        correo: ''
      }
    };
  },
  async created() {
    await this.fetchData();
  },
  methods: {
    async fetchData() {
      this.loading = true;
      this.error = null;
      
      try {
        await Promise.all([
          this.fetchPacientes(),
          this.fetchCatalogos()
        ]);
      } catch (error) {
        console.error('Error fetching data:', error);
        this.error = 'Error al cargar los datos. Por favor recarga la página.';
      } finally {
        this.loading = false;
      }
    },
    
    async handleLogout() {
      await AuthService.logout();
      this.$router.push('/login');
    },
    
    async fetchPacientes() {
      try {
        const response = await axios.get('/api/pacientes');
        console.log('Datos de pacientes:', response.data); // Para depuración
        this.pacientes = response.data;
      } catch (error) {
        console.error('Error fetching pacientes:', error);
        throw error;
      }
    },
    
    async fetchCatalogos() {
      try {
        const [tiposDoc, generos, deptos] = await Promise.all([
          axios.get('/api/tipos-documento'),
          axios.get('/api/generos'),
          axios.get('/api/departamentos')
        ]);
        
        this.tiposDocumento = tiposDoc.data;
        this.generos = generos.data;
        this.departamentos = deptos.data;
        
        if (this.formData.departamento_id) {
          await this.loadMunicipios();
        }
      } catch (error) {
        console.error('Error fetching catalogos:', error);
        throw error;
      }
    },
    
    getGeneroNombre(paciente) {
      if (!paciente.genero) return 'N/A';
      return paciente.genero.nombre || paciente.genero_id || 'N/A';
    },
    
    getUbicacion(paciente) {
      const municipio = paciente.municipio?.nombre || paciente.municipio_id || 'N/A';
      const departamento = paciente.departamento?.nombre || paciente.departamento_id || 'N/A';
      return `${municipio}, ${departamento}`;
    },
    
    async loadMunicipios() {
      try {
        const response = await axios.get(`/api/municipios?departamento_id=${this.formData.departamento_id}`);
        this.municipios = response.data;
      } catch (error) {
        console.error('Error loading municipios:', error);
      }
    },
    
    editPaciente(paciente) {
      this.currentPaciente = paciente;
      this.formData = { ...paciente };
      this.loadMunicipios();
    },
    
    async submitForm() {
      try {
        if (this.currentPaciente) {
          await axios.put(`/api/pacientes/${this.currentPaciente.id}`, this.formData);
        } else {
          await axios.post('/api/pacientes', this.formData);
        }
        
        await this.fetchPacientes();
        this.closeModal();
      } catch (error) {
        console.error('Error saving paciente:', error);
        alert('Error al guardar el paciente. Verifica los datos e intenta nuevamente.');
      }
    },
    
    async confirmDelete(id) {
      if (confirm('¿Estás seguro de que deseas eliminar este paciente?')) {
        try {
          await axios.delete(`/api/pacientes/${id}`);
          await this.fetchPacientes();
        } catch (error) {
          console.error('Error deleting paciente:', error);
        }
      }
    },
    
    closeModal() {
      this.showAddModal = false;
      this.currentPaciente = null;
      this.resetForm();
    },
    
    resetForm() {
      this.formData = {
        tipo_documento_id: '',
        numero_documento: '',
        nombre1: '',
        nombre2: '',
        apellido1: '',
        apellido2: '',
        genero_id: '',
        departamento_id: '',
        municipio_id: '',
        correo: ''
      };
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.logout-btn {
  background-color: #f44336;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

.add-btn {
  background-color: #4CAF50;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-bottom: 20px;
}

.loading, .error {
  padding: 15px;
  margin: 20px 0;
  border-radius: 4px;
}

.loading {
  background-color: #e3f2fd;
  color: #0d47a1;
}

.error {
  background-color: #ffebee;
  color: #c62828;
}

.table-container {
  margin-top: 20px;
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}

.edit-btn {
  background-color: #2196F3;
  color: white;
  border: none;
  padding: 5px 10px;
  border-radius: 3px;
  cursor: pointer;
  margin-right: 5px;
}

.delete-btn {
  background-color: #f44336;
  color: white;
  border: none;
  padding: 5px 10px;
  border-radius: 3px;
  cursor: pointer;
}

.modal {
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 10% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 600px;
  border-radius: 5px;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover {
  color: black;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.submit-btn {
  background-color: #4CAF50;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 10px;
}
</style>