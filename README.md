# 📋 CRUD de Informes Escolares

Este es un sistema web desarrollado en PHP y MySQL que permite gestionar informes de actividades realizadas por estudiantes en proyectos, bajo la supervisión de docentes. Hace parte de un sistema de gestión escolar.

## 🛠️ Funcionalidades principales

- ✅ Registrar estudiantes, docentes y proyectos.
- 📝 Crear, editar y eliminar informes de actividades.
- 🔍 Visualización de listas con filtros y búsqueda.
- ⚠️ Alertas visuales con SweetAlert para confirmar acciones.
- 📅 Gestión de fechas, horas y descripciones de trabajo realizado.

## 📂 Estructura del proyecto

```
/crud-informes
│
├── conexion/                # Archivos de conexión a la base de datos
├── sql/                    # Script de la base de datos
├── style/                  # Archivos CSS personalizados
├── assets/                 # Imágenes y logotipo
├── index.html              # Página principal
├── informes.php            # CRUD principal de informes
├── registrar_informe.php   # Formulario para registrar informes
├── estudiantes.php         # Gestión de estudiantes
├── docentes.php            # Gestión de docentes
└── proyectos.php           # Gestión de proyectos
```

## 🧱 Base de datos

El sistema utiliza una base de datos llamada `Crud_BD` con relaciones entre las tablas:
- `Informe` (clave primaria compuesta)
- `Estudiante`
- `Docente`
- `Proyecto`

Puedes encontrar el script en: `sql/codigo_crudbd.sql`

## 🚀 Tecnologías utilizadas

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- SweetAlert2

## ✅ Cómo ejecutar

1. Clona el repositorio:
   ```bash
   git clone https://github.com/tuusuario/crud-informes.git
   ```
2. Importa el archivo SQL desde `/sql/codigo_crudbd.sql` a tu servidor local.
3. Asegúrate de configurar correctamente tu archivo de conexión `conex.php`.
4. Abre el proyecto desde tu servidor (por ejemplo: `http://localhost/crud-informes/`).

## 🙋 Autor

Johan Esneider Lucumí Palacios & Esteban Marta Rojas

_Tecnólogo en Desarrollo de Sistemas de Información y Software_  
📧 Contacto: johanesneiderlucumip@gmail.com

---

### 💬 Licencia
Este proyecto se distribuye bajo licencia libre para fines educativos y personales.
