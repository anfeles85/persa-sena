<p align="center">
  <img src="https://github.com/anfeles85/persa-sena/blob/G2/persa/public/img/persa-logo-readme.png" alt="PERSA Logo" width="500px">
</p>

# 🛠️ PERSA

**PERSA** es una aplicación web desarrollada en **Laravel** con **MySQL**, diseñada para la gestión integral para procesos de salidas y permisos de los aprendices del SENA. El sistema centraliza el manejo de usuarios, roles, permisos, sedes y reportes, garantizando seguridad y eficiencia en el control de la información.

---

## 📋 Funcionalidades principales
<picture> <img align="right" src="https://certificadossena.net/wp-content/uploads/2022/10/logo-sena-verde-complementario-svg-2022.svg" width="250px"></picture>

- 📦 **Gestión de entidades**:
  - Usuarios
  - Aprendices
  - Instructores
  - Programas
  - Permisos
  - Sedes
  - Grupos

- 📊 **Reportes y exportación**:
  - Generación de reportes en **PDF**
  - Estadísticas visuales

- 🧭 **Interfaz y usabilidad**:
  - Menú de navegación intuitivo
  - Vistas responsivas con **Bootstrap**
  - Formularios validados y adaptados

---

## 🚀 Comenzando

### Requisitos previos

- PHP 8.1 o superior
- Composer
- MySQL 8.x
- Node.js y npm (para compilar assets con Vite)

### Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/anfeles85/persa-sena.git
   cd persa-sena/persa
   ```

2. Instala dependencias de PHP y JavaScript:
   ```bash
   composer install
   npm install && npm run build
   ```

3. Copia y configura el archivo `.env`:
   ```bash
   cp .env.example .env
   ```
   Modifica los valores de conexión a base de datos:
   ```env
   DB_DATABASE=persa_db
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```

4. Importa la base de datos:
   ```
   BD/bdpersa.sql
   ```

5. Genera la clave de aplicación:
   ```bash
   php artisan key:generate
   ```

6. Ejecuta el servidor:
   ```bash
   php artisan serve
   ```

7. Accede en tu navegador:
   ```bash
   http://localhost:8000/
   ```

---

## 🛠️ Buenas prácticas implementadas

- Arquitectura MVC con Laravel
- Migraciones y seeders para la base de datos
- Rutas protegidas con middleware de autenticación
- Vistas limpias y responsivas
- Código modular y reutilizable

---

## 📚 Créditos

Proyecto desarrollado como actividad del **[SENA - Servicio Nacional de Aprendizaje](https://www.sena.edu.co)**,  
en el programa de **Análisis y Desarrollo de Software (ADSO)**,  
con apoyo del **[CLEM - Centro Latinoamericano de Especies Menores](https://sena-clem.blogspot.com)**.

### 👩‍💻 Aprendices desarrolladores

| | |
|---|---|
| [Juan Fernando Velásquez Sarmiento](https://github.com/H2kl0) | [Lina Vanessa Salcedo Cuellar](https://github.com/Linavs18) |
| [Sebastian Rojas Gonzalez](https://github.com/tiannrg) | [Juan Sebastian Rodriguez Cruz](https://github.com/Sebas18Rodriguez18) |
| [Brahian Stiven Quintero Florez](https://github.com/brahianqf07) | [Manuel Alejandro Ocampo Saya](https://github.com/AlejandroOcampo20) |
| [Tatiana Carvajal Vargas](https://github.com/tatiana-carvajal) | [Danna Sofia Marulanda Bahena](https://github.com/marulandadanna2) |