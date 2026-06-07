# 🛒 Práctica 5 - Proyecto Integrador Multimedia

Sistema de Comercio Electrónico desarrollado con **Laravel (API Backend)** y **Vue 3 (Vite Frontend)**, implementando almacenamiento de archivos binarios y autenticación asíncrona mediante tokens de **Laravel Sanctum**.

## 🚀 Requisitos de Instalación y Despliegue Local

### 🖥️ 1. Configuración del Backend (Laravel)
* Entrar a la carpeta: `cd backend`
* Instalar dependencias de PHP: `composer install`
* Crear el enlace simbólico para imágenes multimedia: `php artisan storage:link`
* Ejecutar las migraciones de la base de datos: `php artisan migrate:fresh`
* Iniciar el servidor de la API: `php artisan serve`

> **Nota del .env:** Asegurarse de tener configurada la URL del servidor local con `APP_URL=http://127.0.0.1:8000` y el disco en `FILESYSTEM_DISK=public`.

### 🎨 2. Configuración del Frontend (Vue 3 + Vite)
* Entrar a la carpeta: `cd frontend`
* Instalar los paquetes de Node: `npm install`
* Iniciar el entorno de desarrollo: `npm run dev`

## 🛡️ Credenciales de Acceso Administrativo
Para ingresar al panel protegido (`/admin/crear`), utilizar los siguientes datos de prueba (creados previamente mediante Tinker):
* **Correo:** `admin@tienda.com`
* **Contraseña:** `admin1234`