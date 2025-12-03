<template>
  <div id="turismo-app">
    <header class="header">
      <div class="header-content">
        <!-- Logo + Nombre -->
        <router-link to="/" class="logo-container">
          <img src="/images/logo.png" alt="Turismo Argentina" class="logo-image">
          <h1 class="logo">Turismo Argentina</h1>
        </router-link>
        
        <!-- Navegación -->
        <nav class="nav">
          <router-link to="/" class="nav-link">Inicio</router-link>
          <router-link to="/destinos" class="nav-link">Destinos</router-link>
          <router-link to="/paquetes" class="nav-link">Paquetes</router-link>
        </nav>
      </div>
    </header>
    
    <main class="main-content">
      <router-view />
    </main>
    
    <footer class="footer">
      <p>&copy; 2025 Turismo Argentina - Descubrí la belleza de nuestro país</p>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: #f5f5f5;
}

#turismo-app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  z-index: 100;
}

.header-content {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Logo Container */
.logo-container {
  display: flex;
  align-items: center;
  gap: 15px;
  text-decoration: none;
  transition: transform 0.3s ease;
}

.logo-container:hover {
  transform: scale(1.05);
}

/* Logo Image */
.logo-image {
  width: 50px;
  height: 50px;
  object-fit: contain;
  filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
}

/* Logo Text */
.logo {
  color: white;
  font-size: 1.8em;
  font-weight: bold;
  margin: 0;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.nav {
  display: flex;
  gap: 10px;
}

.nav-link {
  color: white;
  text-decoration: none;
  padding: 12px 24px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 8px;
  transition: all 0.3s;
  font-weight: 500;
}

.nav-link:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: translateY(-2px);
}

.nav-link.router-link-active {
  background: rgba(255, 255, 255, 0.4);
}

.main-content {
  flex: 1;
  max-width: 1200px;
  width: 100%;
  margin: 0 auto;
  padding: 20px;
}

.footer {
  background: #2c3e50;
  color: white;
  text-align: center;
  padding: 30px 20px;
  margin-top: 40px;
}

.footer p {
  margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
  .header-content {
    flex-direction: column;
    gap: 20px;
  }

  .logo-image {
    width: 40px;
    height: 40px;
  }

  .logo {
    font-size: 1.4em;
  }

  .nav {
    width: 100%;
    justify-content: center;
  }

  .nav-link {
    padding: 10px 16px;
    font-size: 0.9em;
  }
}
</style>