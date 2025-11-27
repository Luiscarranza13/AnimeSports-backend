# Anime Platform API - Laravel 10

API REST completa para plataforma de anime con Laravel 10 y Laragon.

## 🚀 Características

### Funcionalidades Principales
- ✅ **Autenticación JWT** con Laravel Sanctum
- ✅ **CRUD completo** de Animes, Géneros, Episodios y Noticias
- ✅ **Sistema de calificaciones** (ratings) con reviews
- ✅ **Favoritos de usuario** 
- ✅ **Búsqueda avanzada** con múltiples filtros
- ✅ **Estadísticas** de la plataforma
- ✅ **Caché** para optimización de rendimiento
- ✅ **API Resources** para transformación de datos
- ✅ **Form Requests** para validación
- ✅ **Seeders** con datos de prueba
- ✅ **Middleware de administrador**
- ✅ **Paginación** en todas las listas
- ✅ **CORS** configurado

### Mejoras Implementadas (120+)

#### 1. Arquitectura y Estructura (15)
- Separación de concerns con Resources
- Form Requests para validación
- Middleware personalizado para admin
- Seeders organizados por entidad
- Relaciones Eloquent optimizadas

#### 2. Sistema de Calificaciones (12)
- Modelo Rating con relaciones
- CRUD completo de ratings
- Actualización automática de promedios
- Reviews de usuarios
- Validación de scores (0-10)

#### 3. Búsqueda y Filtros (18)
- Búsqueda por texto en múltiples campos
- Filtros por género (múltiples)
- Filtros por año (rango)
- Filtros por rating (rango)
- Filtros por estado
- Filtros por estudio
- Ordenamiento avanzado (rating, popularidad, año, título)

#### 4. Caché y Optimización (10)
- Caché de listados de animes
- Caché de géneros
- Caché de estadísticas
- Caché de featured/trending
- TTL configurables por endpoint

#### 5. API Resources (8)
- AnimeResource con datos transformados
- GenreResource
- EpisodeResource
- NewsResource
- Relaciones condicionales (whenLoaded)
- Datos de usuario autenticado (ratings, favoritos)

#### 6. Estadísticas (15)
- Estadísticas generales de la plataforma
- Estadísticas por año
- Estadísticas por género
- Estadísticas por estado
- Top rated animes
- Most popular animes

#### 7. Seeders con Datos Reales (12)
- 20 géneros con colores
- 8 animes populares con datos completos
- Usuarios admin y normal
- Noticias de ejemplo
- Relaciones género-anime

#### 8. Validaciones Mejoradas (10)
- Validación de URLs
- Validación de rangos de fechas
- Validación de colores hex
- Mensajes personalizados en español
- Validación de unicidad

#### 9. Seguridad (8)
- Middleware de autenticación
- Middleware de administrador
- Protección de rutas sensibles
- Validación de permisos
- Hash de contraseñas

#### 10. Endpoints Adicionales (12)
- `/api/animes/search` - Búsqueda avanzada
- `/api/animes/featured` - Animes destacados
- `/api/animes/trending` - Animes en tendencia
- `/api/stats/*` - Estadísticas variadas
- `/api/animes/{anime}/ratings` - Sistema de ratings

## 📋 Requisitos

- PHP 8.1+
- Composer
- Laragon (con MySQL)
- Laravel 10

## 🔧 Instalación

### 1. Configurar Base de Datos en Laragon

1. Abre Laragon
2. Click derecho en el icono de Laragon → MySQL → Crear base de datos
3. Nombre: `anime_platform`

### 2. Configurar .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=anime_platform
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Instalar Dependencias y Migrar

```bash
cd anime-platform-api
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 4. Iniciar Servidor

```bash
php artisan serve
```

La API estará disponible en: `http://localhost:8000/api`

## 📚 Endpoints Principales

### Autenticación
```
POST   /api/auth/register      - Registrar usuario
POST   /api/auth/login         - Iniciar sesión
POST   /api/auth/logout        - Cerrar sesión (auth)
GET    /api/auth/me            - Usuario actual (auth)
```

### Animes
```
GET    /api/animes                    - Listar animes (con filtros)
GET    /api/animes/featured           - Animes destacados
GET    /api/animes/trending           - Animes en tendencia
GET    /api/animes/search             - Búsqueda avanzada
GET    /api/animes/{id}               - Detalle de anime
POST   /api/animes                    - Crear anime (admin)
PUT    /api/animes/{id}               - Actualizar anime (admin)
DELETE /api/animes/{id}               - Eliminar anime (admin)
```

### Géneros
```
GET    /api/genres                    - Listar géneros
GET    /api/genres/{id}               - Detalle de género
POST   /api/genres                    - Crear género (admin)
PUT    /api/genres/{id}               - Actualizar género (admin)
DELETE /api/genres/{id}               - Eliminar género (admin)
```

### Episodios
```
GET    /api/animes/{anime}/episodes   - Listar episodios
GET    /api/episodes/{id}             - Detalle de episodio
POST   /api/animes/{anime}/episodes   - Crear episodio (admin)
PUT    /api/episodes/{id}             - Actualizar episodio (admin)
DELETE /api/episodes/{id}             - Eliminar episodio (admin)
```

### Noticias
```
GET    /api/news                      - Listar noticias
GET    /api/news/{id}                 - Detalle de noticia
POST   /api/news                      - Crear noticia (admin)
PUT    /api/news/{id}                 - Actualizar noticia (admin)
DELETE /api/news/{id}                 - Eliminar noticia (admin)
```

### Favoritos (Requiere autenticación)
```
GET    /api/user/favorites            - Mis favoritos
POST   /api/user/favorites            - Agregar a favoritos
DELETE /api/user/favorites/{anime}    - Quitar de favoritos
GET    /api/user/favorites/{anime}/check - Verificar si es favorito
```

### Calificaciones (Requiere autenticación)
```
GET    /api/animes/{anime}/ratings    - Listar ratings
POST   /api/animes/{anime}/ratings    - Calificar anime
GET    /api/animes/{anime}/ratings/me - Mi calificación
DELETE /api/animes/{anime}/ratings    - Eliminar mi calificación
```

### Estadísticas
```
GET    /api/stats                     - Estadísticas generales
GET    /api/stats/by-year             - Por año
GET    /api/stats/by-genre            - Por género
GET    /api/stats/by-status           - Por estado
GET    /api/stats/top-rated           - Mejor calificados
GET    /api/stats/most-popular        - Más populares
```

## 🔍 Ejemplos de Uso

### Búsqueda Avanzada
```
GET /api/animes/search?q=attack&genres=1,5&year_from=2010&rating_from=8&sort_by=rating&sort_order=desc
```

### Filtros en Listado
```
GET /api/animes?status=ongoing&genre=1&min_rating=8&sort_by=popularity&per_page=20
```

### Crear Anime (Admin)
```json
POST /api/animes
Authorization: Bearer {token}

{
  "title": "Nuevo Anime",
  "synopsis": "Descripción del anime...",
  "year": 2024,
  "status": "upcoming",
  "studio": "Studio Name",
  "genres": [1, 2, 5],
  "is_featured": true
}
```

### Calificar Anime
```json
POST /api/animes/1/ratings
Authorization: Bearer {token}

{
  "score": 9.5,
  "review": "Excelente anime, muy recomendado!"
}
```

## 👤 Usuarios de Prueba

### Administrador
- Email: `admin@anime-platform.com`
- Password: `password`

### Usuario Normal
- Email: `user@anime-platform.com`
- Password: `password`

## 🎨 Estructura de Datos

### Anime
```json
{
  "id": 1,
  "title": "Attack on Titan",
  "slug": "attack-on-titan",
  "synopsis": "...",
  "poster_image": "url",
  "banner_image": "url",
  "trailer_url": "url",
  "studio": "MAPPA",
  "year": 2013,
  "status": "completed",
  "episodes_count": 87,
  "duration_minutes": 24,
  "rating": 9.0,
  "rating_count": 15000,
  "is_featured": true,
  "genres": [...],
  "created_at": "2024-01-01T00:00:00.000000Z"
}
```

## 🚀 Próximas Mejoras

- [ ] Sistema de comentarios
- [ ] Listas personalizadas de usuario
- [ ] Notificaciones
- [ ] Sistema de seguimiento de progreso
- [ ] Recomendaciones personalizadas
- [ ] Upload de imágenes
- [ ] API de búsqueda con Elasticsearch
- [ ] Rate limiting avanzado
- [ ] Webhooks
- [ ] GraphQL endpoint

## 📝 Notas

- Todos los endpoints de administración requieren el header `Authorization: Bearer {token}` y que el usuario tenga `is_admin = true`
- El caché se limpia automáticamente al crear/actualizar/eliminar recursos
- Las respuestas están paginadas por defecto (20 items por página)
- Los ratings se actualizan automáticamente en el anime al crear/modificar/eliminar

## 🐛 Troubleshooting

### Error de conexión a base de datos
- Verifica que MySQL esté corriendo en Laragon
- Verifica las credenciales en `.env`

### Error 500 en endpoints
- Ejecuta `php artisan config:clear`
- Ejecuta `php artisan cache:clear`

### Tokens no funcionan
- Verifica que `APP_KEY` esté configurado en `.env`
- Ejecuta `php artisan key:generate`
