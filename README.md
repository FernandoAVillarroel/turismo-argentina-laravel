# 🌄 Turismo Argentina - Plataforma Full-Stack

Aplicación web full-stack para explorar destinos turísticos de Argentina, con sistema de paquetes, filtros avanzados y gestión de contenido.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-5-646CFF?style=for-the-badge&logo=vite&logoColor=white)

---

## ✨ Características Principales

### Backend (Laravel 11)
- ✅ **API REST** completa con endpoints para destinos, paquetes, categorías, comentarios y fotos
- ✅ **6 Controladores CRUD** con validación y manejo de errores
- ✅ **Eloquent ORM** con relaciones (hasMany, belongsTo)
- ✅ **Migraciones** con campos en español y estructura normalizada
- ✅ **Seeders** con datos de ejemplo de Argentina
- ✅ **Imágenes locales** almacenadas en `public/images/destinos/`

### Frontend (Vue.js 3)
- ✅ **SPA (Single Page Application)** con Vue Router
- ✅ **Componentes reutilizables** (DestinoCard, GaleriaFotos, ReviewCard)
- ✅ **Sistema de filtros avanzado** (categoría, búsqueda por texto, ordenamiento)
- ✅ **Páginas dinámicas** con carga de datos desde API
- ✅ **Diseño responsive** con animaciones CSS
- ✅ **Composition API & Options API** para gestión de estado

---

## 🛠️ Tecnologías Utilizadas

### Backend
| Tecnología | Versión | Uso |
|------------|---------|-----|
| PHP | 8.2 | Lenguaje principal |
| Laravel | 11.x | Framework backend |
| MySQL | 8.0 | Base de datos |
| Composer | 2.x | Gestor de dependencias |

### Frontend
| Tecnología | Versión | Uso |
|------------|---------|-----|
| Vue.js | 3.x | Framework frontend |
| Vite | 5.x | Build tool y dev server |
| Vue Router | 4.x | Navegación SPA |
| Axios | 1.x | Cliente HTTP |

---

## 📦 Instalación

### Prerrequisitos
```bash
- PHP >= 8.2
- Composer
- Node.js >= 18.x
- MySQL >= 8.0
- Git
```

### 1. Clonar el repositorio
```bash
git clone https://github.com/FernandoAVillarroel/turismo-argentina-laravel.git
cd turismo-argentina-laravel
```

### 2. Instalar dependencias de Backend
```bash
composer install
```

### 3. Configurar variables de entorno
```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env` con tus credenciales de base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=turismo_argentina
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Crear base de datos y migrar
```bash
# Crear la base de datos manualmente en MySQL
mysql -u root -p
CREATE DATABASE turismo_argentina;
exit;

# Ejecutar migraciones
php artisan migrate
```

### 5. Poblar base de datos (opcional)
```bash
php artisan db:seed
```

### 6. Instalar dependencias de Frontend
```bash
npm install
```

### 7. Iniciar servidores de desarrollo

**Terminal 1 - Backend:**
```bash
php artisan serve
# Servidor en http://localhost:8000
```

**Terminal 2 - Frontend:**
```bash
npm run dev
# Vite dev server en http://localhost:5173
```

### 8. Acceder a la aplicación
Abrí tu navegador en: **http://localhost:8000**

---

## 📂 Estructura del Proyecto
```
turismo-argentina-laravel/
├── app/
│   ├── Http/Controllers/       # Controladores API
│   │   ├── CategoriaController.php
│   │   ├── ComentarioController.php
│   │   ├── DestinoController.php
│   │   ├── FotoController.php
│   │   ├── PaqueteController.php
│   │   └── ReservaController.php
│   └── Models/                 # Modelos Eloquent
│       ├── Categoria.php
│       ├── Comentario.php
│       ├── Destino.php
│       ├── Foto.php
│       ├── Paquete.php
│       └── Reserva.php
├── database/
│   ├── migrations/             # Migraciones de BD
│   └── seeders/                # Seeders con datos
├── public/
│   └── images/
│       └── destinos/           # Imágenes de destinos
│           ├── cataratas-del-iguazu.jpg
│           ├── bariloche.jpg
│           ├── mendoza.jpg
│           ├── buenos-aires.jpg
│           ├── perito-moreno.jpg
│           ├── salta.jpg
│           └── ushuaia.jpg
├── resources/
│   └── js/
│       ├── components/         # Componentes Vue reutilizables
│       │   ├── DestinoCard.vue
│       │   ├── GaleriaFotos.vue
│       │   └── ReviewCard.vue
│       ├── views/              # Páginas Vue
│       │   ├── Home.vue
│       │   ├── Destinos.vue
│       │   └── DetalleDestino.vue
│       └── router/
│           └── index.js        # Configuración de rutas
├── routes/
│   ├── api.php                 # Rutas de API
│   └── web.php                 # Rutas web
└── README.md
```

---

## 🔌 Endpoints de la API

### Destinos
```http
GET    /api/destinos           # Listar todos los destinos
GET    /api/destinos/{id}      # Obtener un destino específico
POST   /api/destinos           # Crear nuevo destino
PUT    /api/destinos/{id}      # Actualizar destino
DELETE /api/destinos/{id}      # Eliminar destino
```

### Paquetes
```http
GET    /api/paquetes           # Listar todos los paquetes
GET    /api/paquetes/{id}      # Obtener un paquete específico
POST   /api/paquetes           # Crear nuevo paquete
PUT    /api/paquetes/{id}      # Actualizar paquete
DELETE /api/paquetes/{id}      # Eliminar paquete
```

### Categorías
```http
GET    /api/categorias         # Listar todas las categorías
GET    /api/categorias/{id}    # Obtener una categoría específica
POST   /api/categorias         # Crear nueva categoría
PUT    /api/categorias/{id}    # Actualizar categoría
DELETE /api/categorias/{id}    # Eliminar categoría
```

### Comentarios
```http
GET    /api/comentarios        # Listar todos los comentarios
GET    /api/comentarios/{id}   # Obtener un comentario específico
POST   /api/comentarios        # Crear nuevo comentario
PUT    /api/comentarios/{id}   # Actualizar comentario
DELETE /api/comentarios/{id}   # Eliminar comentario
```

### Fotos
```http
GET    /api/fotos              # Listar todas las fotos
GET    /api/fotos/{id}         # Obtener una foto específica
POST   /api/fotos              # Crear nueva foto
PUT    /api/fotos/{id}         # Actualizar foto
DELETE /api/fotos/{id}         # Eliminar foto
```

---

## 🗃️ Estructura de Base de Datos

### Tabla: `destinations`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | ID único |
| nombre | varchar(255) | Nombre del destino |
| ubicacion | varchar(255) | Ciudad, provincia |
| descripcion | text | Descripción completa |
| imagen_url | varchar(255) | Ruta de imagen principal |
| categoria_id | bigint | FK a categorías |
| short_description | varchar(255) | Descripción breve |
| best_time_to_visit | varchar(100) | Mejor época para visitar |

### Tabla: `packages`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | ID único |
| destination_id | bigint | FK a destinos |
| category_id | bigint | FK a categorías |
| title | varchar(255) | Nombre del paquete |
| slug | varchar(255) | URL amigable |
| description | text | Descripción |
| duration_days | int | Duración en días |
| price | decimal(10,2) | Precio |
| included_services | json | Servicios incluidos |
| excluded_services | json | Servicios no incluidos |

### Tabla: `categories`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | bigint | ID único |
| nombre | varchar(100) | Nombre de categoría |
| descripcion | text | Descripción |

---

## 💻 Comandos Útiles

### Laravel
```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Ver rutas
php artisan route:list

# Ejecutar Tinker (consola interactiva)
php artisan tinker

# Crear modelo con migración
php artisan make:model NombreModelo -m

# Crear controlador
php artisan make:controller NombreController --resource
```

### Vite/Vue
```bash
# Compilar para producción
npm run build

# Verificar errores de código
npm run lint

# Previsualizar build de producción
npm run preview
```

---

## 🎨 Características de Diseño

### Paleta de Colores
```css
--primary: #2563eb;      /* Azul principal */
--secondary: #667eea;    /* Azul degradado */
--success: #10b981;      /* Verde éxito */
--text-dark: #1e293b;    /* Texto principal */
--text-light: #64748b;   /* Texto secundario */
--background: #f8fafc;   /* Fondo */
```

### Animaciones
- Hover cards con elevación (`translateY(-10px)`)
- Zoom de imágenes en hover (`scale(1.1)`)
- Transiciones suaves en botones (0.3s ease)
- Spinner de carga animado

### Responsive Breakpoints
- Desktop: > 968px
- Tablet: 768px - 968px
- Mobile: < 768px

---

## 🐛 Troubleshooting

### Error: "SQLSTATE[HY000] [1049] Unknown database"
**Solución:** Crear la base de datos manualmente:
```bash
mysql -u root -p
CREATE DATABASE turismo_argentina;
```

### Error: "Vite manifest not found"
**Solución:** Compilar assets:
```bash
npm run build
```

### Imágenes no se cargan
**Solución:** Verificar que las imágenes estén en `public/images/destinos/` y que las rutas en BD sean correctas:
```php
php artisan tinker
$destino = \App\Models\Destino::find(1);
echo $destino->imagen_url; // Debe ser /images/destinos/nombre.jpg
```

---

## 📈 Datos de Ejemplo

El proyecto incluye 7 destinos turísticos argentinos:

1. **Cataratas del Iguazú** - Puerto Iguazú, Misiones
2. **San Carlos de Bariloche** - Río Negro
3. **Mendoza** - Mendoza
4. **Buenos Aires** - CABA
5. **Glaciar Perito Moreno** - El Calafate, Santa Cruz
6. **Salta** - Salta
7. **Ushuaia** - Tierra del Fuego

Y 13 paquetes turísticos distribuidos entre los destinos.

---

## 🚀 Despliegue en Producción

### Backend (Railway/Heroku)
```bash
# Configurar variables de entorno
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=tu-host-remoto
DB_DATABASE=tu-base-datos
DB_USERNAME=tu-usuario
DB_PASSWORD=tu-contraseña
```

### Frontend (Netlify/Vercel)
```bash
# Build command
npm run build

# Publish directory
public
```

---

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

---

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

---

## 👨‍💻 Autor

**Fernando Villarroel**

- GitHub: [@FernandoAVillarroel](https://github.com/FernandoAVillarroel)
- LinkedIn: [Tu LinkedIn]
- Email: tu-email@ejemplo.com

---

## 🙏 Agradecimientos

- Laravel Framework por la excelente documentación
- Vue.js por su simplicidad y potencia
- Unsplash por las imágenes de alta calidad
- Comunidad de Stack Overflow

---

## 📚 Aprendizajes del Proyecto

Este proyecto me permitió:

- ✅ Dominar la integración Laravel + Vue.js
- ✅ Implementar arquitectura API REST
- ✅ Manejar relaciones Eloquent complejas
- ✅ Crear componentes Vue reutilizables
- ✅ Resolver problemas de integración frontend-backend
- ✅ Aplicar principios de diseño responsive
- ✅ Gestionar estado reactivo con Composition API
- ✅ Debuggear sistemáticamente errores complejos

---

## 🔮 Futuras Mejoras

- [ ] Autenticación de usuarios con Laravel Sanctum
- [ ] Sistema de reservas funcional
- [ ] Panel de administración
- [ ] Integración con pasarelas de pago
- [ ] Sistema de calificaciones con estrellas
- [ ] Filtros avanzados por precio y duración
- [ ] Mapa interactivo con ubicaciones
- [ ] Versión en inglés (i18n)
- [ ] PWA con notificaciones push
- [ ] Tests automatizados (PHPUnit + Vitest)

---



