<template>
  <div class="home">
    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <h1 class="hero-title">Descubrí la Magia de Argentina</h1>
        <p class="hero-subtitle">
          Desde las majestuosas Cataratas del Iguazú hasta los glaciares patagónicos.
          Tu próxima aventura comienza aquí.
        </p>
        <button @click="scrollToDestinos" class="hero-button">
          Explorar Destinos
        </button>
      </div>
    </section>

    <!-- Destinos Destacados -->
    <section class="destinos-section" ref="destinosSection">
      <h2 class="section-title">✨ Destinos Destacados</h2>
      <p class="section-subtitle">Los lugares más increíbles de Argentina te esperan</p>
      
      <div v-if="loading" class="loading">
        <div class="spinner"></div>
        <p>Cargando destinos...</p>
      </div>

      <div v-else-if="destinos.length > 0" class="destinos-grid">
        <div 
          v-for="destino in destinos" 
          :key="destino.id" 
          class="destino-card"
          @click="verDestino(destino.id)"
        >
          <div class="card-image">
            <img 
              :src="destino.featured_image || 'https://via.placeholder.com/400x300?text=' + destino.name" 
              :alt="destino.name"
            />
            <div class="card-overlay">
              <span class="card-location">📍 {{ destino.city }}</span>
            </div>
          </div>
          <div class="card-content">
            <h3 class="card-title">{{ destino.name }}</h3>
            <p class="card-description">{{ destino.short_description }}</p>
            <div class="card-footer">
              <span class="card-country">🇦🇷 {{ destino.country }}</span>
              <span class="card-link">Ver más →</span>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="empty-state">
        <p>😔 No hay destinos disponibles en este momento</p>
      </div>
    </section>

    <!-- Paquetes Populares -->
    <section class="paquetes-section">
      <h2 class="section-title">🎒 Paquetes Turísticos</h2>
      <p class="section-subtitle">Experiencias completas listas para reservar</p>
      
      <div v-if="paquetes.length > 0" class="paquetes-grid">
        <div 
          v-for="paquete in paquetes" 
          :key="paquete.id" 
          class="paquete-card"
        >
          <div class="paquete-header">
            <span class="paquete-duration">⏱️ {{ paquete.duration_days }} días</span>
            <span v-if="paquete.is_featured" class="paquete-badge">⭐ Destacado</span>
          </div>
          <h3 class="paquete-title">{{ paquete.title }}</h3>
          <p class="paquete-description">{{ paquete.description }}</p>
          <div class="paquete-footer">
            <div class="paquete-price">
              <span class="price-label">Desde</span>
              <span class="price-amount">${{ formatPrice(paquete.price) }}</span>
            </div>
            <button class="paquete-button">Reservar</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
      <div class="cta-content">
        <h2>¿Listo para tu próxima aventura?</h2>
        <p>Contactanos y armamos el viaje perfecto para vos</p>
        <button class="cta-button">Contactar Ahora</button>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: 'Home',
  data() {
    return {
      destinos: [],
      paquetes: [],
      loading: true,
      apiUrl: 'http://localhost:8000/api'
    }
  },
  mounted() {
    this.cargarDatos();
  },
  methods: {
    async cargarDatos() {
      try {
        // Cargar destinos
        const destinosResponse = await fetch(`${this.apiUrl}/destinos`);
        const destinosData = await destinosResponse.json();
        if (destinosData.success) {
          this.destinos = destinosData.data;
        }

        // Cargar paquetes
        const paquetesResponse = await fetch(`${this.apiUrl}/paquetes`);
        const paquetesData = await paquetesResponse.json();
        if (paquetesData.success) {
          this.paquetes = paquetesData.data.slice(0, 3); // Solo los primeros 3
        }
      } catch (error) {
        console.error('Error cargando datos:', error);
      } finally {
        this.loading = false;
      }
    },
    verDestino(id) {
      this.$router.push(`/destinos/${id}`);
    },
    formatPrice(price) {
      return new Intl.NumberFormat('es-AR').format(price);
    },
    scrollToDestinos() {
      this.$refs.destinosSection.scrollIntoView({ behavior: 'smooth' });
    }
  }
}
</script>

<style scoped>
.home {
  margin: -20px;
}

/* Hero Section */
.hero {
  background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9)),
              url('https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=1600') center/cover;
  color: white;
  padding: 120px 20px;
  text-align: center;
}

.hero-content {
  max-width: 800px;
  margin: 0 auto;
}

.hero-title {
  font-size: 3.5em;
  margin-bottom: 20px;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-subtitle {
  font-size: 1.3em;
  margin-bottom: 40px;
  line-height: 1.6;
  opacity: 0.95;
}

.hero-button {
  background: white;
  color: #667eea;
  border: none;
  padding: 18px 40px;
  font-size: 1.1em;
  font-weight: bold;
  border-radius: 50px;
  cursor: pointer;
  transition: all 0.3s;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.hero-button:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

/* Sections */
.destinos-section,
.paquetes-section {
  padding: 60px 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.section-title {
  font-size: 2.5em;
  text-align: center;
  color: #2c3e50;
  margin-bottom: 10px;
}

.section-subtitle {
  text-align: center;
  color: #7f8c8d;
  font-size: 1.2em;
  margin-bottom: 50px;
}

/* Loading */
.loading {
  text-align: center;
  padding: 60px 20px;
}

.spinner {
  width: 50px;
  height: 50px;
  border: 5px solid #f3f3f3;
  border-top: 5px solid #667eea;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 20px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Destinos Grid */
.destinos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 30px;
  margin-bottom: 40px;
}

.destino-card {
  background: white;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s;
  cursor: pointer;
}

.destino-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.card-image {
  position: relative;
  height: 250px;
  overflow: hidden;
}

.card-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s;
}

.destino-card:hover .card-image img {
  transform: scale(1.1);
}

.card-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.7));
  display: flex;
  align-items: flex-end;
  padding: 20px;
}

.card-location {
  color: white;
  font-weight: bold;
  font-size: 1.1em;
}

.card-content {
  padding: 25px;
}

.card-title {
  font-size: 1.5em;
  color: #2c3e50;
  margin-bottom: 10px;
}

.card-description {
  color: #7f8c8d;
  line-height: 1.6;
  margin-bottom: 20px;
}

.card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-country {
  color: #95a5a6;
  font-size: 0.9em;
}

.card-link {
  color: #667eea;
  font-weight: bold;
}

/* Paquetes Grid */
.paquetes-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 25px;
}

.paquete-card {
  background: white;
  border-radius: 15px;
  padding: 30px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s;
}

.paquete-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.paquete-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
}

.paquete-duration {
  background: #e8f4f8;
  color: #3498db;
  padding: 8px 15px;
  border-radius: 20px;
  font-size: 0.9em;
  font-weight: bold;
}

.paquete-badge {
  background: #fff3cd;
  color: #f39c12;
  padding: 8px 15px;
  border-radius: 20px;
  font-size: 0.9em;
  font-weight: bold;
}

.paquete-title {
  font-size: 1.4em;
  color: #2c3e50;
  margin-bottom: 15px;
}

.paquete-description {
  color: #7f8c8d;
  line-height: 1.6;
  margin-bottom: 20px;
}

.paquete-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 20px;
  border-top: 2px solid #ecf0f1;
}

.paquete-price {
  display: flex;
  flex-direction: column;
}

.price-label {
  color: #95a5a6;
  font-size: 0.85em;
}

.price-amount {
  color: #27ae60;
  font-size: 1.8em;
  font-weight: bold;
}

.paquete-button {
  background: #667eea;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 25px;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s;
}

.paquete-button:hover {
  background: #5568d3;
  transform: scale(1.05);
}

/* CTA Section */
.cta-section {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 80px 20px;
  text-align: center;
  margin: 60px 0 0 0;
}

.cta-content h2 {
  font-size: 2.5em;
  margin-bottom: 15px;
}

.cta-content p {
  font-size: 1.2em;
  margin-bottom: 30px;
  opacity: 0.9;
}

.cta-button {
  background: white;
  color: #667eea;
  border: none;
  padding: 18px 45px;
  font-size: 1.1em;
  font-weight: bold;
  border-radius: 50px;
  cursor: pointer;
  transition: all 0.3s;
}

.cta-button:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #95a5a6;
  font-size: 1.2em;
}
</style>