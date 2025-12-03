<template>
  <router-link :to="`/destinos/${destino.id}`" class="destino-card">
    <div class="imagen-container">
      <img :src="getImagenUrl(destino.imagen_url)" :alt="destino.nombre">
      <div class="overlay">
        <span class="ubicacion">📍 {{ destino.ubicacion }}</span>
      </div>
    </div>
    
    <div class="card-content">
      <h3>{{ destino.nombre }}</h3>
      <p class="descripcion">{{ destino.short_description || destino.descripcion?.substring(0, 100) + '...' }}</p>
      
      <div class="card-footer">
        <span class="categoria" v-if="destino.categoria">
          {{ destino.categoria.nombre }}
        </span>
        <span class="ver-mas">Ver más →</span>
      </div>
    </div>
  </router-link>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  destino: {
    type: Object,
    required: true
  }
});

const getImagenUrl = (url) => {
  console.log('🖼️ DestinoCard - URL recibida:', url, 'Destino:', props.destino?.nombre);
  if (!url) return 'https://via.placeholder.com/400x300?text=Sin+Imagen';
  if (url.startsWith('http')) return url;
  return `http://localhost:8000${url}`;
};
</script>

<style scoped>
.destino-card {
  display: block;
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  text-decoration: none;
  color: inherit;
}

.destino-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
}

.imagen-container {
  position: relative;
  width: 100%;
  height: 250px;
  overflow: hidden;
}

.imagen-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.destino-card:hover .imagen-container img {
  transform: scale(1.1);
}

.overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: linear-gradient(transparent, rgba(0,0,0,0.7));
  padding: 40px 20px 15px;
}

.ubicacion {
  color: white;
  font-weight: 600;
  font-size: 0.95rem;
}

.card-content {
  padding: 20px;
}

.card-content h3 {
  margin: 0 0 10px 0;
  color: #1e293b;
  font-size: 1.4rem;
}

.descripcion {
  color: #64748b;
  font-size: 0.95rem;
  line-height: 1.5;
  margin-bottom: 15px;
}

.card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.categoria {
  background: #eff6ff;
  color: #2563eb;
  padding: 5px 12px;
  border-radius: 15px;
  font-size: 0.85rem;
  font-weight: 600;
}

.ver-mas {
  color: #2563eb;
  font-weight: 600;
  font-size: 0.9rem;
}
</style>