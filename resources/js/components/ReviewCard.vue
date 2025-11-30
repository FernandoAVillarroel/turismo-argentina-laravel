<template>
  <div class="review-card">
    <div class="review-header">
      <div class="usuario-info">
        <div class="avatar">
          {{ iniciales }}
        </div>
        <div>
          <h4>{{ review.nombre_usuario }}</h4>
          <p class="fecha">{{ formatearFecha(review.fecha) }}</p>
        </div>
      </div>
      <div class="rating">
        <span v-for="n in 5" :key="n" class="estrella" :class="{ filled: n <= review.calificacion }">
          ★
        </span>
      </div>
    </div>
    <p class="comentario">{{ review.comentario }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  review: {
    type: Object,
    required: true
  }
});

const iniciales = computed(() => {
  const nombre = props.review.nombre_usuario || 'Usuario';
  const palabras = nombre.split(' ');
  if (palabras.length >= 2) {
    return (palabras[0][0] + palabras[1][0]).toUpperCase();
  }
  return nombre.substring(0, 2).toUpperCase();
});

const formatearFecha = (fecha) => {
  if (!fecha) return '';
  const date = new Date(fecha);
  return date.toLocaleDateString('es-AR', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  });
};
</script>

<style scoped>
.review-card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  margin-bottom: 20px;
}

.review-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 15px;
}

.usuario-info {
  display: flex;
  gap: 12px;
  align-items: center;
}

.avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1.1rem;
}

.usuario-info h4 {
  margin: 0;
  color: #1e293b;
  font-size: 1.1rem;
}

.fecha {
  color: #64748b;
  font-size: 0.85rem;
  margin: 3px 0 0 0;
}

.rating {
  display: flex;
  gap: 2px;
}

.estrella {
  color: #cbd5e1;
  font-size: 1.3rem;
}

.estrella.filled {
  color: #fbbf24;
}

.comentario {
  color: #475569;
  line-height: 1.6;
  margin: 0;
}
</style>