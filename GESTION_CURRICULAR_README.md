# Sistema de Gestión Curricular - Universidad Icesi

Sistema web para centralizar y gestionar el mapeo entre cursos, competencias y objetivos de aprendizaje.

## 📋 Contenido

1. **Modelo de Datos** - Diagrama ER
2. **Base de Datos** - Script SQL
3. **Backend** - APIs PHP
4. **Frontend** - Interfaz web responsiva
5. **Funcionalidades** - Visualización, filtros, análisis

## 🚀 Guía de Instalación

### Requisitos Previos

- PHP 7.4+
- MySQL 5.7+ o MariaDB 10.3+
- Servidor web (Apache/Nginx)
- Navegador moderno con soporte ES6+

### Paso 1: Base de Datos

1. Conectar a MySQL:
```bash
mysql -h sofditech-icesi-db -P 53306 -u root -p
```

2. Ejecutar el script SQL:
```bash
source scripts/001_create_gestion_curricular.sql
```

O cargar directamente desde el cliente MySQL:
```bash
mysql -h sofditech-icesi-db -P 53306 -u root -p icesi < scripts/001_create_gestion_curricular.sql
```

### Paso 2: Verificar Configuración

Validar el archivo `.env`:
```
DB_DRIVER=mysql
DB_HOST=sofditech-icesi-db
DB_PORT=53306
DB_NAME=icesi
DB_USER=root
DB_PASSWORD=root
DB_CHARSET=utf8mb4
```

### Paso 3: Acceder a la Aplicación

- Abrir navegador: `http://icesi.com:9080/`
- La aplicación cargará automáticamente los modelos y controladores

## 📁 Estructura del Proyecto

```
application/
├── src/
│   ├── mdl/                    (Modelos de datos)
│   │   ├── MdlPrograma.php
│   │   ├── MdlCurso.php
│   │   ├── MdlCompetencia.php
│   │   ├── MdlObjetivo.php
│   │   └── MdlCursoObjetivo.php
│   └── ctr/                    (Controladores)
│       ├── CtrCurriculo.php
│       ├── CtrCrudPrograma.php
│       ├── CtrCrudCurso.php
│       ├── CtrCrudCompetencia.php
│       ├── CtrCrudObjetivo.php
│       └── CtrCrudCursoObjetivo.php
├── api/                        (Endpoints API)
│   ├── api.cursos.php
│   ├── api.competencias.php
│   ├── api.objetivos.php
│   ├── api.programas.php
│   └── api.curriculoAnalisis.php
├── app/
│   ├── view/
│   │   └── curriculoGestion.html
│   └── js/
│       └── curriculoGestion.js
└── scripts/
    └── 001_create_gestion_curricular.sql
```

## 🎯 Conceptos Clave

### Competencia
Capacidad general que un estudiante debe desarrollar (ej. "Pensamiento crítico")

### Objetivo de Aprendizaje
Resultado específico y medible que contribuye al desarrollo de una competencia.
- Un objetivo pertenece a una sola competencia

### Curso
Asignatura dentro de un programa académico.

### Nivel de Contribución
- **I** (Introduce): El curso introduce el objetivo
- **F** (Fortalece): El curso refuerza el objetivo
- **V** (Valora): El curso evalúa el dominio del objetivo

## 🔌 API Endpoints

### Cursos
- `GET ?route=api&file=cursos&action=listar` - Listar todos
- `GET ?route=api&file=cursos&action=obtener&id=X` - Obtener uno
- `POST ?route=api&file=cursos&action=crear` - Crear nuevo
- `POST ?route=api&file=cursos&action=actualizar&id=X` - Actualizar
- `DELETE ?route=api&file=cursos&action=eliminar&id=X` - Eliminar

### Competencias
- `GET ?route=api&file=objetivos&action=listar` - Listar todos
- `POST ?route=api&file=objetivos&action=crear` - Crear nuevo
- `POST ?route=api&file=objetivos&action=actualizar&id=X` - Actualizar
- `DELETE ?route=api&file=objetivos&action=eliminar&id=X` - Eliminar

### Objetivos
- `GET ?route=api&file=objetivos&action=listar` - Listar todos
- `POST ?route=api&file=objetivos&action=crear` - Crear nuevo
- `POST ?route=api&file=objetivos&action=actualizar&id=X` - Actualizar
- `DELETE ?route=api&file=objetivos&action=eliminar&id=X` - Eliminar

### Programas
- `GET ?route=api&file=programas&action=listar` - Listar todos
- `POST ?route=api&file=programas&action=crear` - Crear nuevo

### Análisis y Reportes
- `GET ?route=api&file=curriculoAnalisis&action=dashboard` - Dashboard principal
- `GET ?route=api&file=curriculoAnalisis&action=listarCursos` - Listar con filtros
- `GET ?route=api&file=curriculoAnalisis&action=analisisCobertura` - Estadísticas

## 📊 Funcionalidades Implementadas

### ✅ Visualización
- Dashboard con estadísticas generales
- Listado de cursos con detalles
- Listado de competencias y objetivos
- Información de relaciones curso-objetivo

### ✅ Filtros
- Filtrar cursos por programa
- Filtrar cursos por competencia
- Filtrar cursos por objetivo
- Filtrar cursos por nivel (I, F, V)

### ✅ Análisis
- Porcentaje de objetivos sin asignar a cursos
- Porcentaje de competencias sin objetivos
- Gráficos dinámicos (Chart.js)
- Vista detallada de cobertura

### ✅ CRUD Completo
- Crear/editar/eliminar cursos
- Crear/editar/eliminar competencias
- Crear/editar/eliminar objetivos
- Crear/editar/eliminar relaciones curso-objetivo

### ✅ Vistas Útiles
- `v_cursos_competencias_objetivos` - Relacion completa
- `v_objetivos_sin_asignar` - Identificar huecos
- `v_competencias_sin_objetivos` - Completitud de competencias
- `v_cobertura_cursos` - Resumen de cobertura por curso

## 🔍 Datos de Ejemplo

El script SQL incluye datos de ejemplo:
- 3 Programas académicos
- 4 Competencias
- 6 Objetivos de aprendizaje
- 6 Cursos con asignaciones

## 📝 Uso de la Aplicación

1. **Dashboard**: Visualizar estadísticas generales
2. **Cursos**: Gestionar cursos y ver sus competencias/objetivos
3. **Competencias**: Administrar competencias
4. **Objetivos**: Crear objetivos de aprendizaje
5. **Análisis**: Ver gráficos de cobertura y vacíos

## 🐛 Troubleshooting

### No se cargan los datos
- Verificar conexión a la base de datos en `.env`
- Confirmar que el script SQL se ejecutó correctamente
- Revisar permisos de usuario MySQL

### Errores 404 en APIs
- Verificar rutas en la URL
- Asegurar que los archivos están en `application/api/`
- Validar nombres de archivos sin espacios

### Gráficos no aparecen
- Incluir Chart.js en la página
- Verificar que los datos llegan desde el API

## 📞 Soporte

Para consultas o problemas, revisar:
1. Logs de error PHP
2. Consola del navegador (F12)
3. Logs de MySQL

## 📄 Licencia

Uso exclusivo Universidad Icesi
