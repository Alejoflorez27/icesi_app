# ✅ CHECKLIST DE VERIFICACIÓN - Sistema de Gestión Curricular

## 📋 Verificación de Instalación y Configuración

### ✅ Base de Datos

- [ ] Conectar a MySQL:
  ```bash
  mysql -h sofditech-icesi-db -P 53306 -u root -proot
  ```

- [ ] Ejecutar script SQL:
  ```bash
  mysql -h sofditech-icesi-db -P 53306 -u root -proot icesi < scripts/001_create_gestion_curricular.sql
  ```

- [ ] Verificar tablas creadas:
  ```sql
  USE icesi;
  SHOW TABLES;
  ```
  
  Debe mostrar:
  ```
  programas
  cursos
  competencias
  objetivos
  curso_objetivo
  ```

- [ ] Verificar vistas creadas:
  ```sql
  SHOW FULL TABLES IN icesi WHERE TABLE_TYPE LIKE 'VIEW';
  ```
  
  Debe mostrar 4 vistas

- [ ] Verificar datos de ejemplo:
  ```sql
  SELECT COUNT(*) FROM programas;      -- 3 registros
  SELECT COUNT(*) FROM competencias;   -- 4 registros
  SELECT COUNT(*) FROM objetivos;      -- 6 registros
  SELECT COUNT(*) FROM cursos;         -- 6 registros
  SELECT COUNT(*) FROM curso_objetivo; -- 12 registros
  ```

### ✅ Archivos del Sistema

**Modelos (src/mdl/)**
- [ ] MdlPrograma.php
- [ ] MdlCurso.php
- [ ] MdlCompetencia.php
- [ ] MdlObjetivo.php
- [ ] MdlCursoObjetivo.php

**Controladores (src/ctr/)**
- [ ] CtrCurriculo.php
- [ ] CtrCrudPrograma.php
- [ ] CtrCrudCurso.php
- [ ] CtrCrudCompetencia.php
- [ ] CtrCrudObjetivo.php
- [ ] CtrCrudCursoObjetivo.php

**APIs (api/)**
- [ ] api.cursos.php
- [ ] api.competencias.php
- [ ] api.objetivos.php
- [ ] api.programas.php
- [ ] api.cursoObjetivo.php
- [ ] api.curriculoAnalisis.php

**Frontend (app/)**
- [ ] app/view/curriculoGestion.html
- [ ] app/js/curriculoGestion.js

**Scripts**
- [ ] scripts/001_create_gestion_curricular.sql

### ✅ Configuración de Aplicación

- [ ] Verificar .env:
  ```env
  DB_DRIVER=mysql
  DB_HOST=sofditech-icesi-db
  DB_PORT=53306
  DB_NAME=icesi
  DB_USER=root
  DB_PASSWORD=root
  DB_CHARSET=utf8mb4
  ```

- [ ] Verificar que los modelos se cargan automáticamente
  - En index.php se cargan automáticamente

- [ ] Verificar que los controladores se cargan automáticamente
  - En index.php se cargan automáticamente

### ✅ Funcionalidad de la Aplicación

**Dashboard**
- [ ] Acceder a la aplicación en `http://icesi.com:9080/`
- [ ] Ver 4 tarjetas con estadísticas
- [ ] Total de cursos: 6
- [ ] Total de competencias: 4
- [ ] Total de objetivos: 6
- [ ] Total de programas: 3

**Pestaña Cursos**
- [ ] Aparece tabla con 6 cursos
- [ ] Mostrar columnas: Código, Nombre, Programa, Créditos, Competencias, Objetivos, Acciones
- [ ] Botón "Nuevo Curso" funciona
- [ ] Modal se abre para crear/editar
- [ ] Campos: Programa, Nombre, Código, Descripción, Créditos

**Pestaña Competencias**
- [ ] Aparece tabla con 4 competencias
- [ ] Mostrar columnas: Nombre, Descripción, Objetivos, Acciones
- [ ] Botón "Nueva Competencia" funciona
- [ ] Se puede crear, editar y eliminar

**Pestaña Objetivos**
- [ ] Aparece tabla con 6 objetivos
- [ ] Mostrar columnas: Nombre, Competencia, Descripción, Cursos Asignados, Acciones
- [ ] Botón "Nuevo Objetivo" funciona
- [ ] Se vincula a competencia

**Pestaña Análisis**
- [ ] Se muestran 2 gráficos
- [ ] Gráfico "Objetivos sin Asignar" - Doughnut chart
- [ ] Gráfico "Competencias sin Objetivos" - Doughnut chart
- [ ] Los datos se cargan correctamente

### ✅ Filtrado

- [ ] En pestaña Cursos, filtro por programa funciona
- [ ] En pestaña Cursos, filtro por competencia funciona
- [ ] Botón "Limpiar Filtros" restaura vista completa
- [ ] Filtros se aplican sin recargar página

### ✅ CRUD

**Crear**
- [ ] Crear nuevo curso sin errores
- [ ] Crear nueva competencia sin errores
- [ ] Crear nuevo objetivo sin errores
- [ ] Mensajes de éxito aparecen

**Editar**
- [ ] Click en botón Editar abre modal con datos precargados
- [ ] Modificar datos y guardar funciona
- [ ] Mensajes de éxito aparecen

**Eliminar**
- [ ] Click en botón Eliminar pide confirmación
- [ ] Confirmar elimina el registro
- [ ] Tabla se actualiza sin recargar

### ✅ API Endpoints

**Cursos**
- [ ] GET `?route=api&file=cursos&action=listar` - Retorna JSON
- [ ] GET `?route=api&file=cursos&action=obtener&id=1` - Retorna curso
- [ ] POST `?route=api&file=cursos&action=crear` - Crea curso
- [ ] POST `?route=api&file=cursos&action=actualizar&id=1` - Actualiza
- [ ] DELETE `?route=api&file=cursos&action=eliminar&id=1` - Elimina

**Competencias**
- [ ] GET `?route=api&file=competencias&action=listar` - Retorna JSON
- [ ] POST `?route=api&file=competencias&action=crear` - Crea

**Objetivos**
- [ ] GET `?route=api&file=objetivos&action=listar` - Retorna JSON
- [ ] POST `?route=api&file=objetivos&action=crear` - Crea

**Programas**
- [ ] GET `?route=api&file=programas&action=listar` - Retorna JSON

**Análisis**
- [ ] GET `?route=api&file=curriculoAnalisis&action=dashboard` - Dashboard
- [ ] GET `?route=api&file=curriculoAnalisis&action=analisisCobertura` - Estadísticas

### ✅ Validación de Datos

- [ ] Nombre requerido en formularios
- [ ] Código único en cursos y programas
- [ ] Nivel debe ser I, F o V
- [ ] Relaciones se respetan (FK)

### ✅ Seguridad

- [ ] No hay errores de SQL injection
- [ ] Validación en servidor
- [ ] Mensajes de error sin detallar estructura DB

### ✅ Rendimiento

- [ ] Página carga rápidamente (< 3s)
- [ ] Gráficos se renderizan sin problemas
- [ ] Filtros aplican rápido
- [ ] Tabla con 6 cursos se carga sin lag

### ✅ Navegador

- [ ] Funciona en Chrome
- [ ] Funciona en Firefox
- [ ] Funciona en Edge
- [ ] Responsive en móvil (si aplica)

---

## 🐛 Solución de Problemas

Si algún test falla:

### Problema: Tablas no existen
**Solución:**
```bash
mysql -h sofditech-icesi-db -P 53306 -u root -proot icesi < scripts/001_create_gestion_curricular.sql
```

### Problema: Modelos no se cargan
**Solución:**
- Verificar que `src/mdl/` contiene archivos .php
- Revisar index.php carga automáticamente

### Problema: API retorna error 404
**Solución:**
- Verificar archivo existe en `api/` con nombre correcto
- Verificar nombre de archivo sin acentos ni espacios

### Problema: Gráficos no aparecen
**Solución:**
- Verificar Chart.js está cargado
- Revisar consola (F12) para errores JS
- Verificar datos vienen del API

### Problema: Base de datos no conecta
**Solución:**
```bash
# Verificar conexión
mysql -h sofditech-icesi-db -P 53306 -u root -proot -e "SELECT 1"

# Verificar .env tiene credenciales correctas
cat .env | grep DB_
```

---

## 📊 Resumen Final

**Total de Pruebas:** `__ / 60`

**Estado:**
- [ ] ✅ LISTO PARA PRODUCCIÓN (Todas las pruebas pasaron)
- [ ] ⚠️ PARCIAL (Algunas pruebas fallaron)
- [ ] ❌ NO LISTO (Múltiples pruebas fallaron)

**Fecha de Verificación:** _______________

**Responsable:** _______________

---

## 📝 Notas Adicionales

```
[Espacio para notas personalizadas]
```

---

**Documento de verificación completado en:** 15 de abril de 2026
