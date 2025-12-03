<template>
  <div class="destinos-page">
    <!-- Hero Section -->
    <section class="destinos-hero">
      <div class="hero-overlay">
        <h1>Descubrí Argentina</h1>
        <p>Explorá los destinos más increíbles del país</p>
      </div>
    </section>

    <!-- Filtros -->
    <section class="filtros-section">
      <div class="container">
        <div class="filtros">
          <div class="filtro-grupo">
            <label>🗂️ Categoría</label>
            <select v-model="filtros.categoria_id" @change="filtrarDestinos">
              <option value="">Todas las categorías</option>
              <option v-for="cat in categorias" :key="cat.id" :value="cat.id">
                {{ cat.nombre }}
              </option>
            </select>
          </div>

          <div class="filtro-grupo">
            <label>🔍 Buscar</label>
            <input 
              type="text" 
              v-model="filtros.busqueda" 
              @input="filtrarDestinos"
              placeholder="Nombre o ubicación..."
            >
          </div>

          <div class="filtro-grupo">
            <label>📊 Ordenar por</label>
            <select v-model="filtros.orden" @change="filtrarDestinos">
              <option value="nombre">Nombre</option>
              <option value="precio_asc">Precio: Menor a Mayor</option>
              <option value="precio_desc">Precio: Mayor a Menor</option>
            </select>
          </div>

          <button class="btn-limpiar" @click="limpiarFiltros">
            🔄 Limpiar
          </button>
        </div>
      </div>
    </section>

    <!-- Resultados -->
    <section class="destinos-grid-section">
      <div class="container">
        <div class="resultados-header">
          <h2>{{ destinosFiltrados.length }} destinos encontrados</h2>
        </div>

        <div v-if="loading" class="loading">
          <p>Cargando destinos...</p>
        </div>

        <div v-else-if="destinosFiltrados.length === 0" class="no-resultados">
          <p>😔 No se encontraron destinos con estos filtros</p>
          <button @click="limpiarFiltros" class="btn-primary">Ver todos los destinos</button>
        </div>

        <div v-else class="destinos-grid">
          <DestinoCard 
            v-for="destino in destinosFiltrados" 
            :key="destino.id" 
            :destino="destino"
          />
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import DestinoCard from '../components/DestinoCard.vue';

const destinos = ref([]);
const categorias = ref([]);
const loading = ref(true);

const filtros = ref({
  categoria_id: '',
  busqueda: '',
  orden: 'nombre'
});

onMounted(async () => {
  await cargarDatos();
});

const cargarDatos = async () => {
  try {
    loading.value = true;
    
    const [destinosRes, categoriasRes] = await Promise.all([
      axios.get('http://localhost:8000/api/destinos'),
      axios.get('http://localhost:8000/api/categorias')
    ]);
    
    console.log('🔍 RESPUESTA API:', destinosRes.data);
    console.log('🔍 DESTINOS:', destinosRes.data.data);
    
    destinos.value = Array.isArray(destinosRes.data.data) ? destinosRes.data.data : [];
    categorias.value = Array.isArray(categoriasRes.data) ? categoriasRes.data : [];
    
  } catch (error) {
    console.error('Error cargando datos:', error);
  } finally {
    loading.value = false;
  }
};

const destinosFiltrados = computed(() => {
  let resultado = [...destinos.value];

  // Filtro por categoría
  if (filtros.value.categoria_id) {
    resultado = resultado.filter(d => d.categoria_id == filtros.value.categoria_id);
  }

  // Filtro por búsqueda
  if (filtros.value.busqueda) {
    const busqueda = filtros.value.busqueda.toLowerCase();
    resultado = resultado.filter(d => 
      d.nombre.toLowerCase().includes(busqueda) || 
      d.ubicacion.toLowerCase().includes(busqueda)
    );
  }

  // Ordenamiento
  if (filtros.value.orden === 'nombre') {
    resultado.sort((a, b) => a.nombre.localeCompare(b.nombre));
  } else if (filtros.value.orden === 'precio_asc') {
    resultado.sort((a, b) => (a.precio_minimo || 0) - (b.precio_minimo || 0));
  } else if (filtros.value.orden === 'precio_desc') {
    resultado.sort((a, b) => (b.precio_minimo || 0) - (a.precio_minimo || 0));
  }

  return resultado;
});

const filtrarDestinos = () => {
  // La reactividad de Vue se encarga automáticamente
};

const limpiarFiltros = () => {
  filtros.value = {
    categoria_id: '',
    busqueda: '',
    orden: 'nombre'
  };
};
</script>

<style scoped>
.destinos-page {
  min-height: 100vh;
}

.destinos-hero {
  height: 350px;
  background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
              url('https://images.unsplash.com/photo-1589909202802-8f4aadce1849?w=1200') center/cover;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-align: center;
}

.hero-overlay h1 {
  font-size: 3.5rem;
  margin-bottom: 15px;
  text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
}

.hero-overlay p {
  font-size: 1.3rem;
  opacity: 0.95;
}

.filtros-section {
  background: #f8fafc;
  padding: 40px 0;
  border-bottom: 1px solid #e2e8f0;
}

.filtros {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  align-items: end;
}

.filtro-grupo {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.filtro-grupo label {
  font-weight: 600;
  color: #475569;
  font-size: 0.95rem;
}

.filtro-grupo select,
.filtro-grupo input {
  padding: 12px 15px;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.filtro-grupo select:focus,
.filtro-grupo input:focus {
  outline: none;
  border-color: #2563eb;
}

.btn-limpiar {
  padding: 12px 25px;
  background: #64748b;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: background 0.3s ease;
}

.btn-limpiar:hover {
  background: #475569;
}

.destinos-grid-section {
  padding: 60px 0;
}

.resultados-header {
  margin-bottom: 40px;
}

.resultados-header h2 {
  color: #1e293b;
  font-size: 1.8rem;
}

.loading, .no-resultados {
  text-align: center;
  padding: 60px 20px;
  color: #64748b;
}

.no-resultados p {
  font-size: 1.3rem;
  margin-bottom: 20px;
}

.destinos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 30px;
}

.btn-primary {
  padding: 12px 30px;
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  font-size: 1rem;
}

@media (max-width: 768px) {
  .hero-overlay h1 {
    font-size: 2.5rem;
  }
  
  .destinos-grid {
    grid-template-columns: 1fr;
  }
}
</style>