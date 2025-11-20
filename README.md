🌍 Turismo Argentina – Sistema de Gestión Turística

Aplicación web moderna diseñada para gestionar destinos, paquetes turísticos y reservas dentro de Argentina, combinando un backend robusto con un frontend dinámico.

🚀 Funcionalidades Principales

🌐 API REST completamente desarrollada con Laravel

📌 CRUD de Destinos Turísticos (Cataratas, Perito Moreno, etc.)

🧳 Gestión de Paquetes con precios, detalles y disponibilidad

📆 Sistema de Reservas con validaciones

🖼️ Galería de Imágenes por destino

⭐ Sistema de Comentarios y Reseñas

🗂️ Categorización por tipo de experiencia (Aventura, Cultural, Gastronomía, etc.)

🛠️ Tecnologías Utilizadas
🔧 Backend – API REST con Laravel

Laravel 11 – Framework PHP moderno y escalable

MySQL – Base de datos relacional

Eloquent ORM – Manejo de modelos y relaciones

API RESTful – Arquitectura limpia para consumo desde frontend o apps externas

🎨 Frontend – SPA con Vue.js (en desarrollo)

JavaScript ES6+ / Vue.js 3 – Framework progresivo orientado a componentes

Axios – Cliente HTTP para consumir la API

Vue Router – Navegación entre vistas y rutas dinámicas


📁 Estructura General del Proyecto

turismo-app/
├── app/
│   ├── Http/Controllers/      # Controladores API
│   └── Models/                # Modelos Eloquent
├── database/
│   ├── migrations/            # Migraciones
│   └── seeders/               # Datos de prueba
└── routes/
    └── api.php                # Rutas REST


🗄️ Modelo de Base de Datos

destinations – Destinos turísticos

categories – Categorías de experiencias

packages – Paquetes turísticos

bookings – Reservas

reviews – Reseñas y valoraciones

destinations_images – Galería de imágenes

🔌 Endpoints de la API (Resumen)
🌍 Destinos
GET    /api/destinos
GET    /api/destinos/{id}
POST   /api/destinos
PUT    /api/destinos/{id}
DELETE /api/destinos/{id}

🗂️ Categorías
GET    /api/categorias
POST   /api/categorias
PUT    /api/categorias/{id}
DELETE /api/categorias/{id}


👨‍💻 Autor

Fernando Villarroel
📍 Santiago del Estero, Argentina
🔗 GitHub: @FernandoAVillarroel

📝 Licencia

Proyecto de código abierto, desarrollado con fines educativos y de portfolio.
Año 2024/2025
