# Manual de Usuario - Gestión Curricular

## 🎯 Introducción

El sistema de Gestión Curricular permite administrar de manera integral:
- **Programas académicos** - Carreras o programas de estudio
- **Cursos** - Asignaturas dentro de los programas
- **Competencias** - Habilidades generales que los estudiantes deben desarrollar
- **Objetivos de Aprendizaje** - Resultados específicos medibles
- **Relaciones** - Vincular cursos con objetivos de aprendizaje

## 📱 Interfaz Principal

La interfaz principal está dividida en 4 pestañas:

### 1. **Cursos**
Gestiona todos los cursos académicos.

**Funciones:**
- Ver listado de cursos con programa, créditos, competencias y objetivos
- Crear nuevo curso
- Editar información del curso
- Eliminar cursos
- Filtrar por programa o competencia

**Campos de un Curso:**
- Programa (requerido)
- Nombre (requerido)
- Código (requerido, único)
- Descripción (opcional)
- Créditos (opcional)

### 2. **Competencias**
Administra las competencias que deben desarrollar los estudiantes.

**Funciones:**
- Listar todas las competencias
- Crear nueva competencia
- Editar competencia existente
- Eliminar competencia
- Ver cantidad de objetivos por competencia

**Campos de una Competencia:**
- Nombre (requerido)
- Descripción (opcional)

### 3. **Objetivos**
Gestiona los objetivos de aprendizaje específicos.

**Funciones:**
- Ver listado de objetivos con competencia asociada
- Crear nuevo objetivo
- Editar objetivo existente
- Eliminar objetivo
- Ver cantidad de cursos que tienen este objetivo

**Campos de un Objetivo:**
- Competencia (requerido)
- Nombre (requerido)
- Descripción (opcional)

### 4. **Análisis**
Visualiza gráficos y estadísticas sobre la cobertura curricular.

**Visualizaciones:**
- **Objetivos sin Asignar**: Muestra qué objetivos no están vinculados con ningún curso
- **Competencias sin Objetivos**: Identifica competencias que no tienen objetivos definidos

## 🔍 Filtrado de Cursos

Para filtrar cursos:

1. Ir a la pestaña **Cursos**
2. Usar los selectores disponibles:
   - **Programa**: Mostrar solo cursos de un programa específico
   - **Competencia**: Mostrar solo cursos relacionados con una competencia
   - **Objetivo**: Mostrar solo cursos que trabajan un objetivo
   - **Nivel**: Filtrar por nivel (I=Introduce, F=Fortalece, V=Valora)
3. Click en **Limpiar Filtros** para restablecer

## ➕ Crear Nuevo Elemento

### Crear Curso
1. Click en botón **Nuevo Curso**
2. Rellenar campos requeridos
3. Click en **Guardar**

### Crear Competencia
1. Click en botón **Nueva Competencia**
2. Ingresar nombre (requerido)
3. Agregar descripción (opcional)
4. Click en **Guardar**

### Crear Objetivo
1. Click en botón **Nuevo Objetivo**
2. Seleccionar competencia (requerido)
3. Ingresar nombre (requerido)
4. Agregar descripción (opcional)
5. Click en **Guardar**

## ✏️ Editar Elemento

1. Click en botón **Editar** (icono de lápiz) en la fila del elemento
2. Modificar los campos deseados
3. Click en **Guardar**

## 🗑️ Eliminar Elemento

1. Click en botón **Eliminar** (icono de papelera) en la fila
2. Confirmar la eliminación en el diálogo
3. El elemento se eliminará junto con sus relaciones

⚠️ **Advertencia**: Las eliminaciones son permanentes.

## 📊 Análisis y Reportes

### Indicadores Principales

**Total de Cursos**: Número total de asignaturas en el sistema

**Total de Competencias**: Cantidad de competencias definidas

**Total de Objetivos**: Cantidad de objetivos de aprendizaje

**Total de Programas**: Número de programas académicos

### Gráficos

**Objetivos sin Asignar**
- Muestra el porcentaje de objetivos que no tienen cursos asignados
- Indica huecos en la cobertura curricular
- Ayuda a identificar qué objetivos necesitan ser cubiertos

**Competencias sin Objetivos**
- Muestra el porcentaje de competencias sin objetivos definidos
- Identifica competencias incompletas
- Señala áreas que necesitan objetivos específicos

## 💡 Casos de Uso

### Caso 1: Diseñar un nuevo programa
1. Crear el Programa
2. Definir las Competencias generales
3. Para cada competencia, crear Objetivos específicos
4. Crear los Cursos
5. Asignar Objetivos a Cursos indicando nivel (I, F, V)
6. Usar Análisis para validar cobertura

### Caso 2: Verificar cobertura de competencias
1. Ir a Análisis
2. Revisar gráfico "Competencias sin Objetivos"
3. Crear objetivos faltantes
4. Reasignar cursos según sea necesario

### Caso 3: Auditoría curricular
1. Filtrar por programa
2. Revisar cada curso y sus objetivos
3. Validar niveles (I, F, V) son progresivos
4. Usar Análisis para identificar vacíos
5. Generar reporte de cobertura

## 🎓 Niveles de Contribución Explicados

Cuando se asigna un objetivo a un curso, se especifica el nivel de contribución:

| Nivel | Sigla | Significado | Ejemplo |
|---|---|---|---|
| Introduce | I | El curso introduce por primera vez el objetivo | Matemáticas I introduce "Cálculo" |
| Fortalece | F | El curso refuerza y profundiza el objetivo | Matemáticas II fortalece "Cálculo" |
| Valora | V | El curso evalúa el dominio completo del objetivo | Análisis Matemático valora "Cálculo" |

**Patrón Recomendado**: I → F → V (Progresivo)

## ⌨️ Atajos y Tips

- **Limpiar formularios**: Click en "Editar" de nuevo
- **Búsqueda rápida**: Usar filtros en lugar de buscar manualmente
- **Exportar datos**: Usar funciones del navegador: Clic derecho → Guardar tabla como
- **Imprimir**: Clic derecho en tabla → Imprimir

## 🆘 Solución de Problemas

### No aparecen datos en las tablas
- Verificar conexión a base de datos
- Comprobar que los datos fueron importados correctamente
- Recargar la página (F5)

### Modal no se abre
- Asegurar que JavaScript esté habilitado
- Verificar consola del navegador (F12)
- Limpiar caché del navegador

### Error al guardar
- Completar todos los campos requeridos
- Verificar que los códigos sean únicos
- Revisar consola para mensajes de error

## 📞 Contacto y Soporte

Para reportar problemas o sugerencias, contactar al equipo de desarrollo.
