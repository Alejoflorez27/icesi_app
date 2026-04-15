# 📚 ÍNDICE DE DOCUMENTACIÓN
## Sistema de Gestión Curricular - Universidad Icesi

**Versión:** 1.0  
**Fecha:** 15 de abril de 2026  
**Estado:** Producción

---

## 🚀 INICIO RÁPIDO ⭐

### 🔴 PRIMERO: Lee Esto
📄 **[LEER_PRIMERO.md](LEER_PRIMERO.md)** - Acción requerida para ver el menú

### Para Administradores/Instaladores
1. Leer: [LEER_PRIMERO.md](LEER_PRIMERO.md) ⭐
2. Ejecutar: [scripts/001_create_gestion_curricular.sql](scripts/001_create_gestion_curricular.sql)
3. Ejecutar: [scripts/002_insert_menu_gestion_curricular.sql](scripts/002_insert_menu_gestion_curricular.sql)
4. Verificar: [CHECKLIST_VERIFICACION.md](CHECKLIST_VERIFICACION.md)

### Para Usuarios Finales
1. Leer: [MANUAL_USUARIO.md](MANUAL_USUARIO.md)
2. Acceder: `http://icesi.com:9080/`
3. Explorar las 4 pestañas

### Para Desarrolladores
1. Estudiar: [GESTION_CURRICULAR_README.md](GESTION_CURRICULAR_README.md)
2. Revisar: [IMPORTAR_EXPORTAR_DATOS.md](IMPORTAR_EXPORTAR_DATOS.md)
3. Explorar estructura de carpetas

---

## 📄 DOCUMENTACIÓN COMPLETA

### 0. **MENU_INTEGRADO.md** ✅ MENÚ COMPLETADO
   - ✅ Status: El menú está integrado en la BD
   - 6 menús agregados correctamente (1 padre + 5 submenús)
   - IDs: 1519-1524
   - Próximos pasos: Actualizar navegador y acceder
   - ⏱️ ~2 minutos para validar

### 0.5 **INTEGRACION_MENU_COMPLETADA.md** 📋 RESUMEN DE INTEGRACIÓN
   - Qué se implementó en esta sesión
   - Archivos nuevos/modificados
   - Próximos pasos para el usuario
   - Checklist final
   - Estado actual del proyecto

### 1. **RESUMEN_ENTREGA.md** ⭐ COMIENZA AQUÍ
   - Resumen ejecutivo del proyecto
   - Listado completo de entregables
   - InstINSTRUCCIONES_INTEGRAR_MENU.md** 📋 INTEGRATION
   - Cómo agregar el menú automáticamente
   - Script SQL para menú
   - Ajuste de rutas de APIs
   - Verificación paso a paso
   - Troubleshooting de menú

### 3. **rucciones de instalación
   - Estructura final del proyecto
   - Casos de uso cubiertos
   - Métricas del proyecto
   - Estado: LISTO PARA PRODUCCIÓN

### 2. **GESTION_CURRICULAR_README.md** 🔧 TÉCNICO
   - Contexto y conceptos clave
   -4Guía de instalación detallada
   - Descripción del modelo de datos
   - Referencia de APIs REST
   - Listado de funcionalidades
   - Vistas SQL disponibles
   - Troubleshooting técnico

### 3. **MANUAL_USUARIO.md** 👥 PARA USUARIOS
   - Introducción a la aplicación
   - Descripción de interfaz
   -5Cómo crear/editar/eliminar elementos
   - Cómo usar filtros
   - Cómo interpretar análisis
   - Explicación de niveles (I, F, V)
   - Casos de uso comunes
   - Solución de problemas para usuarios

### 4. **IMPORTAR_EXPORTAR_DATOS.md** 📊 DATOS
   - Formato esperado de datos Excel
   - Instrucciones de importación
   - Script Python (opcional)
   - Validación de datos
   - Orden de inserción
   - Consideraciones de integridad

### 6. **CHECKLIST_VERIFICACION.md** ✅ VALIDACIÓN
   - Lista de verificación completa
   - Todos los tests necesarios
   - Comandos de validación
   - Solución de problemas común
   - Resumen final de estado

---

## 📁 ESTRUCTURA DE CARPETAS

```
icesi_app/
│
├── 📖 DOCUMENTACIÓN
│   ├── RESUMEN_ENTREGA.md ........................ Resumen ejecutivo
│   ├── MANUAL_USUARIO.md ........................ Guía de usuario
│   ├── GESTION_CURRICULAR_README.md ............ Guía técnica
│   ├── IMPORTAR_EXPORTAR_DATOS.md ............. Importación
│   ├── CHECKLIST_VERIFICACION.md .............. Verificación
│   └── INDICE_DOCUMENTACION.md ................. Este archivo
│
├── 📦 APPLICATION (Aplicación Principal)
│   ├── src/
│   │   ├── mdl/ ................................. MODELOS
│   │   │   ├── MdlPrograma.php
│   │   │   ├── MdlCurso.php
│   │   │   ├── MdlCompetencia.php
│   │   │   ├── MdlObjetivo.php
│   │   │   └── MdlCursoObjetivo.php
│   │   │
│   │   └── ctr/ ................................. CONTROLADORES
│   │       ├── CtrCurriculo.php
│   │       ├── CtrCrudPrograma.php
│   │       ├── CtrCrudCurso.php
│   │       ├── CtrCrudCompetencia.php
│   │       ├── CtrCrudObjetivo.php
│   │       └── CtrCrudCursoObjetivo.php
│   │
│   ├── api/ ..................................... APIs REST
│   │   ├── api.cursos.php
│   │   ├── api.competencias.php
│   │   ├── api.objetivos.php
│   │   ├── api.programas.php
│   │   ├── api.cursoObjetivo.php
│   │   └── api.curriculoAnalisis.php
│   │
│   ├── app/
│   │   ├── view/
│   │   │   └── curriculoGestion.html .......... Vista principal
│   │   │
│   │   └── js/
│   │       └── curriculoGestion.js ........... Lógica frontend
│   │
│   └── [otros archivos]
│
├── 📊 SCRIPTS
│   └── scripts/
│       └── 001_create_gestion_curricular.sql .. Base de datos
│
└── 🐳 DOCKER
    └── docker-compose.yml ....................... Configuración

```

---

## 🎯 GUÍA RÁPIDA POR ROL

### 👨‍💼 ADMINISTRADOR DEL SISTEMA
**Objetivo:** Instalar y configurar el sistema

**Pasos:**
1. Leer: RESUMEN_ENTREGA.md (Paso 1-3: Instalación)
2. Ejecutar: 
   ```bash
   mysql -h sofditech-icesi-db -P 53306 -u root -proot icesi < scripts/001_create_gestion_curricular.sql
   ```
3. Verificar: CHECKLIST_VERIFICACION.md
4. Documentar: CHECKLIST_VERIFICACION.md > Sección "Estado"

**Documentos:**
- RESUMEN_ENTREGA.md
- CHECKLIST_VERIFICACION.md
- GESTION_CURRICULAR_README.md

---

### 👤 USUARIO FINAL
**Objetivo:** Usar la aplicación

**Primeros Pasos:**
1. Leer: MANUAL_USUARIO.md (Secciones 1-3)
2. Acceder: http://icesi.com:9080/
3. Crear primer programa
4. Crear competencias
5. Crear objetivos
6. Crear cursos
7. Vincular objetivos a cursos
8. Ver análisis

**Documentos:**
- MANUAL_USUARIO.md 📖
- GESTION_CURRICULAR_README.md (opcional)

---

### 👨‍💻 DESARROLLADOR
**Objetivo:** Extender o mantener el código

**Aprendizaje:**
1. Estudiar: GESTION_CURRICULAR_README.md
2. Revisar: Estructura de carpetas
3. Explorar: Modelos (MdlXxx.php)
4. Entender: Controladores (CtrXxx.php)
5. Probar: APIs REST

**Documentos:**
- GESTION_CURRICULAR_README.md
- IMPORTAR_EXPORTAR_DATOS.md
- Código fuente comentado

---

### 📊 DATA ANALYST
**Objetivo:** Trabajar con datos

**Tareas:**
1. Importar datos: IMPORTAR_EXPORTAR_DATOS.md
2. Consultar: Vistas SQL
3. Generar reportes: API `analisisCobertura`
4. Exportar: Usar phpMyAdmin

**Documentos:**
- IMPORTAR_EXPORTAR_DATOS.md
- GESTION_CURRICULAR_README.md (Vistas SQL)

---

## 🔗 REFERENCIAS CRUZADAS

### Por Tema

**INSTALACIÓN**
- RESUMEN_ENTREGA.md → "INSTRUCCIONES DE INSTALACIÓN"
- GESTION_CURRICULAR_README.md → "Guía de Instalación"
- CHECKLIST_VERIFICACION.md → "Verificación de Instalación"

**USO DE LA APLICACIÓN**
- MANUAL_USUARIO.md → Guía completa
- GESTION_CURRICULAR_README.md → Endpoints API

**DATOS**
- IMPORTAR_EXPORTAR_DATOS.md → Importación
- scripts/001_create_gestion_curricular.sql → Base de datos

**DESARROLLO**
- GESTION_CURRICULAR_README.md → Técnico
- RESUMEN_ENTREGA.md → Estructura de código

**VALIDACIÓN**
- CHECKLIST_VERIFICACION.md → Tests

---

## 📞 SOLUCIÓN DE PROBLEMAS

### Problema: No sé por dónde empezar
**Solución:** Lee RESUMEN_ENTREGA.md primero

### Problema: La aplicación no funciona
**Solución:** Revisa CHECKLIST_VERIFICACION.md

### Problema: Quiero añadir una característica
**Solución:** Estudia GESTION_CURRICULAR_README.md

### Problema: Necesito importar datos
**Solución:** Sigue IMPORTAR_EXPORTAR_DATOS.md

### Problema: No entiendo cómo usar la app
**Solución:** Lee MANUAL_USUARIO.md

---

## 📈 ROADMAP

### Versión 1.0 (ACTUAL) ✅
- [x] CRUD de cursos
- [x] CRUD de competencias
- [x] CRUD de objetivos
- [x] Relación curso-objetivo
- [x] Filtros
- [x] Análisis básico
- [x] Documentación

### Versión 1.1 (Planeada)
- [ ] Sistema de autenticación
- [ ] Exportación a PDF
- [ ] Importación masiva de Excel
- [ ] Búsqueda avanzada
- [ ] Reportes personalizables

### Versión 2.0 (Propuesta)
- [ ] API GraphQL
- [ ] Dashboard analítico avanzado
- [ ] Integración con SIS
- [ ] Mobile app
- [ ] Machine learning para recomendaciones

---

## 📊 ESTADÍSTICAS DEL PROYECTO

| Métrica | Valor |
|---------|-------|
| Tablas de BD | 5 |
| Vistas SQL | 4 |
| Modelos PHP | 5 |
| Controladores | 6 |
| APIs | 6 |
| Funciones JS | 25+ |
| Líneas de código | 2000+ |
| Documentación | 6 archivos |
| Tiempo desarrollo | ~6 horas |
| Status | ✅ Producción |

---

## 👥 CONTRIBUIDORES

- **Equipo de Desarrollo:** Implementación completa
- **Universidad Icesi:** Requerimientos y feedback

---

## 📄 LICENCIA

Uso exclusivo para la Universidad Icesi.

---

## 🎓 APÉNDICES

### A. Glosario de Términos
- **Competencia:** Capacidad general del estudiante
- **Objetivo:** Resultado específico de aprendizaje
- **Curso:** Asignatura académica
- **Nivel:** Grado de contribución (I, F, V)

### B. Contactos
- Soporte Técnico: [email]
- Administración: [email]
- Desarrollo: [email]

### C. URLs Útiles
- Aplicación: http://icesi.com:9080/
- phpMyAdmin: http://icesi.com:8080/
- Documentación: Este archivo

---

**Última actualización:** 15 de abril de 2026  
**Versión:** 1.0  
**Status:** PRODUCCIÓN
