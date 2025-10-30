<p align="center">
  <img src="https://github.com/anfeles85/persa-sena/blob/G2/persa/public/img/persa-logo-readme.png" alt="PERSA Logo" width="500px">
</p>

## 🛠️ PERSA

**PERSA** es una aplicación web desarrollada en **Laravel** con **MySQL**, diseñada para la gestión integral de procesos de salidas y permisos de los aprendices del **SENA**.  
El sistema centraliza el manejo de **usuarios, roles, permisos, sedes y reportes**, garantizando **seguridad** y **eficiencia** en el control de la información.

---

### 💻 Tecnologías utilizadas

<p align="center">
  <img src="https://img.shields.io/badge/JavaScript-%23F7DF1E.svg?style=for-the-badge&logo=javascript&logoColor=black" height="25">
  <img src="https://img.shields.io/badge/PHP-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white" height="25">
  <img src="https://img.shields.io/badge/HTML-E34F26?style=for-the-badge&logo=html5&logoColor=white" height="25">
  <img src="https://img.shields.io/badge/CSS-1572B6?style=for-the-badge&logo=css3&logoColor=white" height="25">
</p>⚙️ Frameworks y Librerías

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" height="25">
  <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" height="25">
</p>

---

## 📋 Funcionalidades principales
<picture> <img align="right" src="https://certificadossena.net/wp-content/uploads/2022/10/logo-sena-verde-complementario-svg-2022.svg" width="250px"></picture>

- 📦 **Gestión de entidades**:
  - Usuarios, Aprendices, Instructores
  - Programas, Permisos, Sedes
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

```bash
# 1. Clona el repositorio
git clone https://github.com/anfeles85/persa-sena.git
cd persa-sena/persa

# 2. Instala dependencias
composer install
npm install && npm run build

# 3. Configura el archivo .env
cp .env.example .env

# 4. Importa la base de datos
BD/persa_db.sql

# 5. Genera la clave de aplicación
php artisan key:generate

# 6. Ejecuta el servidor
php artisan serve

```


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

---

## 📚 Créditos

Proyecto desarrollado como actividad del **[SENA - Servicio Nacional de Aprendizaje](https://www.sena.edu.co)**,  
en el programa de **Análisis y Desarrollo de Software (ADSO)**,  
con apoyo del **[CLEM - Centro Latinoamericano de Especies Menores](https://sena-clem.blogspot.com)**.
