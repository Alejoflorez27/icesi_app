# 🏗️ ARQUITECTURA DEL SISTEMA

## Diagrama General

```
┌─────────────────────────────────────────────────────────────────┐
│                        NAVEGADOR WEB                             │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │  HTML (curriculoGestion.html)                              │ │
│  │  - 4 Pestañas (Cursos, Competencias, Objetivos, Análisis) │ │
│  │  - 3 Modales de edición                                    │ │
│  │  - Filtros interactivos                                    │ │
│  └────────────────────────────────────────────────────────────┘ │
│  ┌────────────────────────────────────────────────────────────┐ │
│  │  JavaScript (curriculoGestion.js)                          │ │
│  │  - Funciones CRUD                                          │ │
│  │  - Llamadas AJAX al Backend                                │ │
│  │  - Renderizado de gráficos (Chart.js)                      │ │
│  └────────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────────┘
                            ↕️ AJAX/JSON
┌─────────────────────────────────────────────────────────────────┐
│                    SERVIDOR PHP/APACHE                           │
│ ┌──────────────────────────────────────────────────────────┐    │
│ │  Enrutador (index.php)                                   │    │
│ │  - Carga modelos automáticamente                         │    │
│ │  - Carga controladores automáticamente                   │    │
│ │  - Enruta requests a APIs                                │    │
│ └──────────────────────────────────────────────────────────┘    │
│                                                                  │
│ ┌─ API Layer ─────────────────────────────────────────────┐    │
│ │ api.cursos.php                                           │    │
│ │ api.competencias.php                                     │    │
│ │ api.objetivos.php                                        │    │
│ │ api.programas.php                                        │    │
│ │ api.cursoObjetivo.php                                    │    │
│ │ api.curriculoAnalisis.php                                │    │
│ │ (Responden con JSON)                                     │    │
│ └──────────────┬──────────────────────────────────────────┘    │
│                ↓                                                 │
│ ┌─ Controller Layer ───────────────────────────────────────┐    │
│ │ CtrCurriculo (filtrado, análisis)                        │    │
│ │ CtrCrudPrograma (CRUD)                                   │    │
│ │ CtrCrudCurso (CRUD)                                      │    │
│ │ CtrCrudCompetencia (CRUD)                                │    │
│ │ CtrCrudObjetivo (CRUD)                                   │    │
│ │ CtrCrudCursoObjetivo (CRUD)                              │    │
│ │ (Orquesta lógica de negocio)                             │    │
│ └──────────────┬──────────────────────────────────────────┘    │
│                ↓                                                 │
│ ┌─ Model Layer ────────────────────────────────────────────┐    │
│ │ MdlPrograma                                              │    │
│ │ MdlCurso                                                 │    │
│ │ MdlCompetencia                                           │    │
│ │ MdlObjetivo                                              │    │
│ │ MdlCursoObjetivo                                         │    │
│ │ (Acceso a datos, queries SQL)                            │    │
│ └──────────────┬──────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────────┘
                            ↕️ SQL
┌─────────────────────────────────────────────────────────────────┐
│                      MYSQL DATABASE                              │
│ ┌──────────────────────────────────────────────────────────┐    │
│ │  Tablas:                                                 │    │
│ │  - programas                                             │    │
│ │  - cursos                                                │    │
│ │  - competencias                                          │    │
│ │  - objetivos                                             │    │
│ │  - curso_objetivo                                        │    │
│ │                                                          │    │
│ │  Vistas:                                                 │    │
│ │  - v_cursos_competencias_objetivos                       │    │
│ │  - v_objetivos_sin_asignar                               │    │
│ │  - v_competencias_sin_objetivos                          │    │
│ │  - v_cobertura_cursos                                    │    │
│ └──────────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────────┘
```

---

## Flujo de Datos

### Caso 1: Cargar Cursos

```
Usuario abre tab Cursos
           ↓
curriculoGestion.js: cargarCursos()
           ↓
Fetch: ?route=api&file=cursos&action=listar
           ↓
api.cursos.php: action=listar
           ↓
CtrCrudCurso: listar()
           ↓
MdlCurso: obtenerTodos()
           ↓
SELECT * FROM cursos
           ↓
Retorna JSON
           ↓
renderizarCursos(data)
           ↓
Renderiza tabla en HTML
```

### Caso 2: Crear Nuevo Curso

```
Usuario click: "Nuevo Curso"
           ↓
mostrarModalCurso()
           ↓
Modal se abre
           ↓
Usuario llena formulario
           ↓
Click "Guardar"
           ↓
guardarCurso()
           ↓
Fetch POST: ?route=api&file=cursos&action=crear
           ↓
api.cursos.php: action=crear
           ↓
CtrCrudCurso: crear()
           ↓
MdlCurso: crear()
           ↓
INSERT INTO cursos
           ↓
Retorna JSON (success/error)
           ↓
Cierra modal
           ↓
cargarCursos() (recarga tabla)
           ↓
Muestra mensaje de éxito
```

### Caso 3: Filtrar Cursos

```
Usuario cambiar filtro Programa
           ↓
filtrarCursos()
           ↓
Fetch: ?route=api&file=curriculoAnalisis&action=listarCursos&programa=X
           ↓
api.curriculoAnalisis.php
           ↓
CtrCurriculo: listarCursos(filtros)
           ↓
MdlCurso: métodos filtrados
           ↓
Retorna cursos filtrados
           ↓
renderizarCursos(datosFiltrrados)
           ↓
Tabla actualiza sin recargar página
```

### Caso 4: Ver Análisis

```
Usuario click tab "Análisis"
           ↓
cargarAnalisis()
           ↓
Fetch: ?route=api&file=curriculoAnalisis&action=analisisCobertura
           ↓
api.curriculoAnalisis.php
           ↓
CtrCurriculo: obtenerAnalisisCobertura()
           ↓
MdlObjetivo: obtenerSinAsignar()
           ↓
Retorna JSON con estadísticas
           ↓
renderizarGraficos(datos)
           ↓
Chart.js crea 2 gráficos
           ↓
Se muestran gráficos de cobertura
```

---

## Patrones de Diseño

### MVC
```
Model (Mdl*)
    ↓
Controller (Ctr*)
    ↓
View (HTML/JS)
```

### REST API
```
HTTP Request
    ↓
Enrutador
    ↓
API Handler
    ↓
Controlador
    ↓
Modelo
    ↓
Base de Datos
    ↓
JSON Response
```

### AJAX
```
Evento en Frontend
    ↓
Fetch/XMLHttpRequest
    ↓
POST/GET a API
    ↓
JSON Response
    ↓
Actualizar DOM
    ↓
Sin recargar página
```

---

## Stack Teknológico

### Frontend
```
┌─────────────────┐
│ HTML5           │ Estructura
├─────────────────┤
│ CSS3 (AdminLTE) │ Estilos
├─────────────────┤
│ JavaScript ES6+ │ Interactividad
├─────────────────┤
│ Chart.js        │ Gráficos
├─────────────────┤
│ Bootstrap 4     │ Framework
└─────────────────┘
```

### Backend
```
┌─────────────────┐
│ PHP 7.4+        │ Lenguaje
├─────────────────┤
│ PDO             │ ORM
├─────────────────┤
│ MVC Pattern     │ Arquitectura
└─────────────────┘
```

### Base de Datos
```
┌─────────────────┐
│ MySQL 5.7+      │ Motor relacional
├─────────────────┤
│ 5 Tablas        │ Almacenamiento
├─────────────────┤
│ 4 Vistas        │ Consultas complejas
├─────────────────┤
│ Foreign Keys    │ Integridad
└─────────────────┘
```

### DevOps
```
┌─────────────────┐
│ Docker          │ Contenedores
├─────────────────┤
│ Apache/Nginx    │ Servidor web
├─────────────────┤
│ Git             │ Control de versiones
└─────────────────┘
```

---

## Secuencia de Inicialización

```
1. Usuario accede a http://icesi.com:9080/

2. Apache / Nginx sirve HTML

3. Navegador descarga:
   - HTML (curriculoGestion.html)
   - CSS (AdminLTE, Bootstrap)
   - JS (curriculoGestion.js, Chart.js)

4. DOMContentLoaded dispara:
   - cargarDashboard()
   - cargarCursos()
   - cargarCompetencias()
   - cargarObjetivos()
   - cargarAnalisis()

5. Cada función hace AJAX a API correspondiente

6. APIs cargan modelos y controladores automáticamente

7. Se devuelven datos JSON

8. JavaScript renderiza UI con datos

9. Usuario ve página funcional

10. Listo para interactuar (CRUD, filtros, análisis)
```

---

## Escalabilidad

### Actual (Producción)
- ✅ CRUD completo
- ✅ Filtros básicos
- ✅ Gráficos simples
- ✅ APIs REST

### Corto Plazo (v1.1)
- 🔄 Autenticación
- 🔄 Exportación PDF
- 🔄 Importación masiva
- 🔄 Búsqueda avanzada

### Mediano Plazo (v2.0)
- 📋 API GraphQL
- 📋 Dashboard analytics avanzado
- 📋 Integración SIS
- 📋 Mobile app

### Largo Plazo (v3.0)
- 🚀 Machine Learning
- 🚀 Recomendaciones automáticas
- 🚀 Análisis predictivo
- 🚀 Integraciones externas

---

## Rendimiento

- Tiempo inicial de carga: ~2-3 segundos
- Tiempo de respuesta API: ~200-500ms
- Gráficos Chart.js: ~1 segundo
- Operaciones CRUD: ~300-400ms

---

## Seguridad

✅ Validación en servidor  
✅ Prepared statements (PDO)  
✅ Protección contra SQL injection  
✅ Validación de tipos  
✅ Manejo de errores seguro  

---

**Diagrama compilado:** 15 de abril de 2026
