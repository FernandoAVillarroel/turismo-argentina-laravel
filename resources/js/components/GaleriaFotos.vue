<template>
  <div class="galeria-container">
    <div class="galeria-principal">
      <img :src="getImagenUrl(imagenActual)" :alt="alt" class="imagen-principal">
      
      <button class="btn-nav btn-prev" @click="anterior" v-if="fotos.length > 1">
        ‹
      </button>
      <button class="btn-nav btn-next" @click="siguiente" v-if="fotos.length > 1">
        ›
      </button>
      
      <div class="contador" v-if="fotos.length > 1">
        {{ indiceActual + 1 }} / {{ fotos.length }}
      </div>
    </div>

    <div class="galeria-thumbnails" v-if="fotos.length > 1">
      <div 
        v-for="(foto, index) in fotos" 
        :key="index"
        class="thumbnail"
        :class="{ active: index === indiceActual }"
        @click="irAImagen(index)"
      >
        <img :src="getImagenUrl(foto)" :alt="`Thumbnail ${index + 1}`">
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  fotos: {
    type: Array,
    required: true
  },
  alt: {
    type: String,
    default: 'Galería de fotos'
  }
});

const indiceActual = ref(0);

const imagenActual = computed(() => {
  return props.fotos[indiceActual.value] || '';
});

const siguiente = () => {
  if (indiceActual.value < props.fotos.length - 1) {
    indiceActual.value++;
  } else {
    indiceActual.value = 0;
  }
};

const anterior = () => {
  if (indiceActual.value > 0) {
    indiceActual.value--;
  } else {
    indiceActual.value = props.fotos.length - 1;
  }
};

const irAImagen = (index) => {
  indiceActual.value = index;
};

const getImagenUrl = (url) => {
  if (!url) return 'https://via.placeholder.com/800x600?text=Sin+Imagen';
  if (url.startsWith('http')) return url;
  return `http://localhost:8000${url}`;  // ← Sin /storage/
};
</script>

<style scoped>
.galeria-container {
  margin-bottom: 40px;
}

.galeria-principal {
  position: relative;
  width: 100%;
  height: 500px;
  border-radius: 12px;
  overflow: hidden;
  background: #000;
}

.imagen-principal {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.btn-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(255, 255, 255, 0.9);
  border: none;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  font-size: 2rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #1e293b;
}

.btn-nav:hover {
  background: white;
  transform: translateY(-50%) scale(1.1);
}

.btn-prev {
  left: 20px;
}

.btn-next {
  right: 20px;
}

.contador {
  position: absolute;
  bottom: 20px;
  right: 20px;
  background: rgba(0, 0, 0, 0.7);
  color: white;
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 0.9rem;
  font-weight: 600;
}

.galeria-thumbnails {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
  gap: 15px;
  margin-top: 20px;
}

.thumbnail {
  height: 100px;
  border-radius: 8px;
  overflow: hidden;
  cursor: pointer;
  border: 3px solid transparent;
  transition: all 0.3s ease;
}

.thumbnail:hover {
  border-color: #2563eb;
  transform: scale(1.05);
}

.thumbnail.active {
  border-color: #2563eb;
}

.thumbnail img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

@media (max-width: 768px) {
  .galeria-principal {
    height: 300px;
  }

  .btn-nav {
    width: 40px;
    height: 40px;
    font-size: 1.5rem;
  }

  .galeria-thumbnails {
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
  }

  .thumbnail {
    height: 80px;
  }
}
</style>