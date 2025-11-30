<template>
  <div class="detalle-destino">
    <div v-if="loading" class="loading-container">
      <p>Cargando destino...</p>
    </div>

    <div v-else-if="!destino" class="error-container">
      <h2>😔 Destino no encontrado</h2>
      <router-link to="/destinos" class="btn-primary">Volver a Destinos</router-link>
    </div>

    <div v-else>
      <!-- Breadcrumb -->
      <div class="breadcrumb">
        <div class="container">
          <router-link to="/">Inicio</router-link>
          <span> / </span>
          <router-link to="/destinos">Destinos</router-link>
          <span> / </span>
          <span class="actual">{{ destino.nombre }}</span>
        </div>
      </div>

      <!-- Contenido Principal -->
      <div class="container">
        <!-- Título y ubicación -->
        <div class="header-section">
          <div>
            <h1>{{ destino.nombre }}</h1>
            <p class="ubicacion">📍 {{ destino.ubicacion }}</p>
          </div>
          <div class="categoria-badge" v-if="destino.categoria">
            {{ destino.categoria.nombre }}
          </div>
        </div>

        <!-- Galería de Fotos -->
        <GaleriaFotos 
          v-if="fotosDestino.length > 0"
          :fotos="fotosDestino" 
          :alt="destino.nombre"
        />

        <!-- Grid de Contenido -->
        <div class="content-grid">
          <!-- Columna Principal -->
          <div class="main-content">
            <!-- Descripción -->
            <section class="section">
              <h2>Sobre este destino</h2>
              <p class="descripcion">{{ destino.descripcion }}</p>
            </section>

            <!-- Reviews -->
            <section class="section">
              <h2>Opiniones de viajeros ({{ reviews.length }})</h2>
              
              <div v-if="reviews.length === 0" class="no-reviews">
                <p>Aún no hay opiniones sobre este destino. ¡Sé el primero en compartir tu experiencia!</p>
              </div>

              <div v-else class="reviews-list">
                <ReviewCard 
                  v-for="review in reviews" 
                  :key="review.id" 
                  :review="review"
                />
              </div>
            </section>
          </div>

          <!-- Sidebar -->
          <aside class="sidebar">
            <!-- Paquetes Disponibles -->
            <div class="sidebar-card">
              <h3>Paquetes Disponibles</h3>
              
              <div v-if="paquetes.length === 0" class="no-paquetes">
                <p>No hay paquetes disponibles para este destino.</p>
              </div>

              <div v-else class="paquetes-list">
                <div 
                  v-for="paquete in paquetes" 
                  :key="paquete.id" 
                  class="paquete-item"
                >
                  <h4>{{ paquete.nombre }}</h4>
                  <p class="duracion">🕒 {{ paquete.duracion_dias }} días</p>
                  <p class="precio">${{ formatPrice(paquete.precio) }}</p>
                  <button class="btn-reservar">Reservar</button>
                </div>
              </div>
            </div>

            <!-- Información adicional -->
            <div class="sidebar-card">
              <h3>Información</h3>
              <ul class="info-list">
                <li>
                  <strong>Ubicación:</strong><br>
                  {{ destino.ubicacion }}
                </li>
                <li v-if="destino.categoria">
                  <strong>Categoría:</strong><br>
                  {{ destino.categoria.nombre }}
                </li>
                <li v-if="paquetes.length > 0">
                  <strong>Precio desde:</strong><br>
                  ${{ formatPrice(precioMinimo) }}
                </li>
              </ul>
            </div>
          </aside>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import GaleriaFotos from '../components/GaleriaFotos.vue';
import ReviewCard from '../components/ReviewCard.vue';

const route = useRoute();
const destino = ref(null);
const fotos = ref([]);
const reviews = ref([]);
const paquetes = ref([]);
const loading = ref(true);

onMounted(async () => {
  await cargarDestino();
});

const cargarDestino = async () => {
  try {
    loading.value = true;
    const destinoId = route.params.id;

   // Cargar destino
   const destinoRes = await axios.get(`http://localhost:8000/api/destinos/${destinoId}`);
destino.value = destinoRes.data.data; // ← Agregá .data extra

    console.log('✅ Destino cargado:', destino.value);
console.log('📸 Imagen URL:', destino.value?.imagen_url);
console.log('📍 Ubicación:', destino.value?.ubicacion);

    // Cargar fotos del destino
try {
  const fotosRes = await axios.get('http://localhost:8000/api/fotos');
  if (Array.isArray(fotosRes.data)) {
    fotos.value = fotosRes.data.filter(f => f.destino_id == destinoId);
  } else {
    fotos.value = [];
  }
} catch (error) {
  console.log('No hay fotos disponibles');
  fotos.value = [];
}


    // Cargar reviews del destino
    try {
      const reviewsRes = await axios.get('http://localhost:8000/api/comentarios');
      // Verificar que sea un array antes de filtrar
      if (Array.isArray(reviewsRes.data)) {
        reviews.value = reviewsRes.data.filter(r => r.destino_id == destinoId);
      } else {
        reviews.value = [];
      }
    } catch (error) {
      console.log('No hay comentarios disponibles');
      reviews.value = [];
    }

    // Cargar paquetes del destino
    try {
      const paquetesRes = await axios.get('http://localhost:8000/api/paquetes');
      // Verificar que sea un array antes de filtrar
      if (Array.isArray(paquetesRes.data)) {
        paquetes.value = paquetesRes.data.filter(p => p.destino_id == destinoId);
      } else {
        paquetes.value = [];
      }
    } catch (error) {
      console.log('No hay paquetes disponibles');
      paquetes.value = [];
    }

  } catch (error) {
    console.error('Error cargando destino:', error);
  } finally {
    loading.value = false;
  }
};

const fotosDestino = computed(() => {
  const urls = [];
  
  if (destino.value?.imagen_url) {
    urls.push(destino.value.imagen_url);
  }

  return urls.length > 0 ? urls : [];
});

const precioMinimo = computed(() => {
  if (paquetes.value.length === 0) return 0;
  return Math.min(...paquetes.value.map(p => p.precio));
});

const formatPrice = (price) => {
  return new Intl.NumberFormat('es-AR').format(price);
};
</script>

<style scoped>
.detalle-destino {
  min-height: 100vh;
  background: #f8fafc;
  padding-bottom: 60px;
}

.loading-container, .error-container {
  text-align: center;
  padding: 100px 20px;
}

.breadcrumb {
  background: white;
  padding: 15px 0;
  border-bottom: 1px solid #e2e8f0;
  margin-bottom: 30px;
}

.breadcrumb a {
  color: #2563eb;
  text-decoration: none;
}

.breadcrumb a:hover {
  text-decoration: underline;
}

.breadcrumb .actual {
  color: #64748b;
}

.header-section {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 30px;
}

.header-section h1 {
  font-size: 2.5rem;
  color: #1e293b;
  margin: 0 0 10px 0;
}

.ubicacion {
  font-size: 1.1rem;
  color: #64748b;
  margin: 0;
}

.categoria-badge {
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
  color: white;
  padding: 10px 20px;
  border-radius: 25px;
  font-weight: 600;
}

.content-grid {
  display: grid;
  grid-template-columns: 1fr 380px;
  gap: 40px;
  margin-top: 40px;
}

.main-content .section {
  background: white;
  padding: 30px;
  border-radius: 12px;
  margin-bottom: 30px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.main-content h2 {
  color: #1e293b;
  font-size: 1.8rem;
  margin: 0 0 20px 0;
}

.descripcion {
  color: #475569;
  line-height: 1.8;
  font-size: 1.05rem;
}

.no-reviews, .no-paquetes {
  text-align: center;
  padding: 40px 20px;
  color: #64748b;
}

.sidebar-card {
  background: white;
  padding: 25px;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.sidebar-card h3 {
  color: #1e293b;
  font-size: 1.3rem;
  margin: 0 0 20px 0;
}

.paquete-item {
  padding: 20px 0;
  border-bottom: 1px solid #e2e8f0;
}

.paquete-item:last-child {
  border-bottom: none;
}

.paquete-item h4 {
  color: #1e293b;
  margin: 0 0 10px 0;
}

.duracion {
  color: #64748b;
  font-size: 0.9rem;
  margin: 5px 0;
}

.precio {
  color: #10b981;
  font-size: 1.5rem;
  font-weight: 700;
  margin: 10px 0;
}

.btn-reservar {
  width: 100%;
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
  color: white;
  border: none;
  padding: 12px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-reservar:hover {
  background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
}

.info-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.info-list li {
  padding: 15px 0;
  border-bottom: 1px solid #e2e8f0;
  color: #475569;
}

.info-list li:last-child {
  border-bottom: none;
}

.info-list strong {
  color: #1e293b;
}

.btn-primary {
  display: inline-block;
  padding: 12px 30px;
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
  color: white;
  text-decoration: none;
  border-radius: 8px;
  font-weight: 600;
  margin-top: 20px;
}

@media (max-width: 968px) {
  .content-grid {
    grid-template-columns: 1fr;
  }

  .header-section {
    flex-direction: column;
    gap: 15px;
  }
}
</style>