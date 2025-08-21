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
  - Carreras
  - Fichas

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
- MySQL Server
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
   DB_DATABASE=persa
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

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/H2kl0">
        <img src="https://github.com/H2kl0.png" width="100px;" alt="H2kl0"/><br />
        <sub><b>Juan Fernando Velásquez Sarmiento</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/Linavs18">
        <img src="https://github.com/Linavs18.png" width="100px;" alt="Linavs18"/><br />
        <sub><b>Lina Vanessa Salcedo Cuellar</b></sub>
      </a>
    </td>
  </tr>
  <tr>
    <td align="center">
      <a href="https://github.com/tiannrg">
        <img src="https://github.com/tiannrg.png" width="100px;" alt="tiannrg"/><br />
        <sub><b>Sebastian Rojas Gonzalez</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/Sebas18Rodriguez18">
        <img src="https://github.com/Sebas18Rodriguez18.png" width="100px;" alt="Sebas18Rodriguez18"/><br />
        <sub><b>Juan Sebastian Rodriguez Cruz</b></sub>
      </a>
    </td>
  </tr>
  <tr>
    <td align="center">
      <a href="https://github.com/brahianqf07">
        <img src="https://github.com/brahianqf07.png" width="100px;" alt="brahianqf07"/><br />
        <sub><b>Brahian Stiven Quintero Florez</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/AlejandroOcampo20">
        <img src="https://github.com/AlejandroOcampo20.png" width="100px;" alt="AlejandroOcampo20"/><br />
        <sub><b>Manuel Alejandro Ocampo Saya</b></sub>
      </a>
    </td>
  </tr>
  <tr>
    <td align="center">
      <a href="https://github.com/tatiana-carvajal">
        <img src="https://github.com/tatiana-carvajal.png" width="100px;" alt="tatiana-carvajal"/><br />
        <sub><b>Tatiana Carvajal Vargas</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/marulandadanna2">
        <img src="https://github.com/marulandadanna2.png" width="100px;" alt="marulandadanna2"/><br />
        <sub><b>Danna Sofia Marulanda Bahena</b></sub>
      </a>
    </td>
  </tr>
</table>
