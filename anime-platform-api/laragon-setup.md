# Configuración con Laragon - Anime Platform API

## 📦 Paso 1: Preparar Laragon

### 1.1 Iniciar Laragon
1. Abre Laragon
2. Click en **"Start All"** para iniciar Apache y MySQL

### 1.2 Crear Base de Datos
1. Click derecho en el icono de Laragon en la bandeja del sistema
2. Selecciona **MySQL → Create Database**
3. Nombre de la base de datos: `anime_platform`
4. Click en **OK**

## 🔧 Paso 2: Configurar el Proyecto

### 2.1 Ubicar el Proyecto
El proyecto debe estar en: `C:\laragon\www\anime-platform-api`

Si no está ahí, muévelo a esa ubicación.

### 2.2 Configurar .env
1. Abre el archivo `.env` en el proyecto
2. Verifica que tenga esta configuración:

```env
APP_NAME="Anime Platform API"
APP_ENV=local
APP_KEY=base64:... (se genera automáticamente)
APP_DEBUG=true
APP_URL=http://anime-platform-api.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=anime_platform
DB_USERNAME=root
DB_PASSWORD=
```

**Nota:** Laragon usa `root` sin contraseña por defecto.

## 🚀 Paso 3: Instalar

### Opción A: Instalación Automática (Recomendado)
1. Abre el terminal de Laragon:
   - Click derecho en Laragon → Terminal
2. Navega al proyecto:
   ```bash
   cd anime-platform-api
   ```
3. Ejecuta el instalador:
   ```bash
   install.bat
   ```

### Opción B: Instalación Manual
1. Abre el terminal de Laragon
2. Navega al proyecto:
   ```bash
   cd anime-platform-api
   ```
3. Ejecuta los siguientes comandos:
   ```bash
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```

## ✅ Paso 4: Verificar Instalación

### 4.1 Iniciar el Servidor
```bash
php artisan serve
```

### 4.2 Probar la API
Abre tu navegador y visita:
- http://localhost:8000/api/animes
- http://localhost:8000/api/genres

Deberías ver datos JSON.

## 🌐 Paso 5: Configurar Virtual Host (Opcional)

Para usar `anime-platform-api.test` en lugar de `localhost:8000`:

### 5.1 En Laragon
1. Click derecho en Laragon → Apache → sites-enabled
2. Crea un archivo: `anime-platform-api.conf`
3. Pega este contenido:

```apache
<VirtualHost *:80>
    DocumentRoot "C:/laragon/www/anime-platform-api/public"
    ServerName anime-platform-api.test
    ServerAlias *.anime-platform-api.test
    <Directory "C:/laragon/www/anime-platform-api/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 5.2 Actualizar hosts
1. Click derecho en Laragon → Tools → Edit hosts file
2. Agrega esta línea:
```
127.0.0.1 anime-platform-api.test
```

### 5.3 Reiniciar Apache
1. Click en **"Stop All"** en Laragon
2. Click en **"Start All"**

Ahora puedes acceder en: http://anime-platform-api.test/api

## 🔍 Verificar Base de Datos

### Usando HeidiSQL (incluido en Laragon)
1. Click derecho en Laragon → MySQL → HeidiSQL
2. Conéctate (usuario: root, sin contraseña)
3. Selecciona la base de datos `anime_platform`
4. Deberías ver las tablas:
   - users
   - animes
   - genres
   - episodes
   - news
   - ratings
   - user_favorites
   - anime_genre

## 📊 Datos de Prueba

Después de ejecutar los seeders, tendrás:

### Usuarios
- **Admin:** admin@anime-platform.com / password
- **Usuario:** user@anime-platform.com / password

### Animes
- 8 animes populares con datos completos
- Attack on Titan, Demon Slayer, My Hero Academia, etc.

### Géneros
- 20 géneros con colores personalizados
- Acción, Aventura, Comedia, Drama, etc.

## 🧪 Probar la API

### Con Postman o Thunder Client
1. Importa el archivo `api-examples.http`
2. Prueba los endpoints

### Con cURL
```bash
# Listar animes
curl http://localhost:8000/api/animes

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d "{\"email\":\"admin@anime-platform.com\",\"password\":\"password\"}"
```

## 🐛 Solución de Problemas

### Error: "SQLSTATE[HY000] [1045] Access denied"
**Solución:**
1. Verifica que MySQL esté corriendo en Laragon
2. Verifica las credenciales en `.env`
3. En Laragon, el usuario es `root` sin contraseña

### Error: "Base de datos no encontrada"
**Solución:**
1. Crea la base de datos en Laragon:
   - Click derecho → MySQL → Create Database
   - Nombre: `anime_platform`

### Error: "Class 'App\Models\...' not found"
**Solución:**
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Error: "No application encryption key"
**Solución:**
```bash
php artisan key:generate
```

### Puerto 8000 ocupado
**Solución:**
```bash
# Usa otro puerto
php artisan serve --port=8001
```

## 📝 Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Ver rutas
php artisan route:list

# Refrescar base de datos (CUIDADO: borra todo)
php artisan migrate:fresh --seed

# Crear nuevo admin
php artisan tinker
>>> $user = new App\Models\User();
>>> $user->name = 'Nuevo Admin';
>>> $user->email = 'nuevo@admin.com';
>>> $user->password = bcrypt('password');
>>> $user->is_admin = true;
>>> $user->save();
```

## 🎯 Próximos Pasos

1. ✅ Instalar y configurar
2. ✅ Probar endpoints básicos
3. ✅ Crear un usuario y hacer login
4. ✅ Probar CRUD de animes
5. ✅ Integrar con el frontend Vue

## 📚 Recursos

- [Documentación de Laravel](https://laravel.com/docs/10.x)
- [Documentación de Laragon](https://laragon.org/docs/)
- [API Examples](./api-examples.http)
- [README Principal](./README_API.md)

## 💡 Tips

1. **Usa el terminal de Laragon** para ejecutar comandos PHP
2. **HeidiSQL** es excelente para ver la base de datos
3. **Thunder Client** (extensión de VS Code) para probar la API
4. **Mantén Laragon corriendo** mientras desarrollas
5. **Revisa los logs** en `storage/logs/laravel.log` si hay errores

---

¿Problemas? Revisa el archivo `README_API.md` para más información.
