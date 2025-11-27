@echo off
echo ========================================
echo Anime Platform API - Instalacion
echo ========================================
echo.

echo [1/5] Instalando dependencias de Composer...
call composer install
if %errorlevel% neq 0 (
    echo Error al instalar dependencias
    pause
    exit /b %errorlevel%
)
echo.

echo [2/5] Copiando archivo de configuracion...
if not exist .env (
    copy .env.example .env
    echo Archivo .env creado
) else (
    echo Archivo .env ya existe
)
echo.

echo [3/5] Generando clave de aplicacion...
call php artisan key:generate
echo.

echo [4/5] Ejecutando migraciones...
call php artisan migrate
if %errorlevel% neq 0 (
    echo.
    echo IMPORTANTE: Asegurate de que:
    echo 1. MySQL este corriendo en Laragon
    echo 2. La base de datos 'anime_platform' este creada
    echo 3. Las credenciales en .env sean correctas
    echo.
    pause
    exit /b %errorlevel%
)
echo.

echo [5/5] Ejecutando seeders...
call php artisan db:seed
echo.

echo ========================================
echo Instalacion completada exitosamente!
echo ========================================
echo.
echo Usuarios de prueba creados:
echo - Admin: admin@anime-platform.com / password
echo - Usuario: user@anime-platform.com / password
echo.
echo Para iniciar el servidor ejecuta:
echo php artisan serve
echo.
echo La API estara disponible en:
echo http://localhost:8000/api
echo.
pause
