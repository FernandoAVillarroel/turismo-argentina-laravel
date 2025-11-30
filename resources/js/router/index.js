import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Destinos from '../views/Destinos.vue';
import DetalleDestino from '../views/DetalleDestino.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/destinos',
    name: 'Destinos',
    component: Destinos
  },
  {
    path: '/destinos/:id',
    name: 'DetalleDestino',
    component: DetalleDestino
  },
  // 👇 AGREGÁ ESTA RUTA
  {
    path: '/paquetes',
    name: 'Paquetes',
    component: Home  // Temporal: redirecciona a Home
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else {
      return { top: 0 };
    }
  }
});

export default router;