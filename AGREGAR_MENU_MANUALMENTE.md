# 📝 AGREGAR MENÚ MANUALMENTE (Si el script no funciona)

Si ejecutar el script desde terminal no funcionó, aquí hay dos formas de agregarlo manualmente:

---

## Opción 1: phpMyAdmin (Más Fácil)

### 1. Abrir phpMyAdmin
```
http://icesi.com:8080/
```

### 2. Seleccionar base de datos: `icesi`

### 3. Ir a pestaña "SQL"

### 4. Copiar y pegar estos comandos:

```sql
INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES (
    'Gestión Curricular',
    'Gestión de cursos, competencias y objetivos',
    '<i class="nav-icon fas fa-graduation-cap"></i>',
    '#',
    0,
    'item'
);

INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES (
    'Dashboard',
    'Visualizar estadísticas',
    '<i class="nav-icon fas fa-chart-pie"></i>',
    '?page=curriculoGestion',
    (SELECT id FROM usr_menu WHERE etiqueta = 'Gestión Curricular' LIMIT 1),
    'submenu'
);

INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES (
    'Cursos',
    'Gestionar cursos académicos',
    '<i class="nav-icon fas fa-book"></i>',
    '?page=curriculoGestion',
    (SELECT id FROM usr_menu WHERE etiqueta = 'Gestión Curricular' LIMIT 1),
    'submenu'
);

INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES (
    'Competencias',
    'Gestionar competencias',
    '<i class="nav-icon fas fa-star"></i>',
    '?page=curriculoGestion',
    (SELECT id FROM usr_menu WHERE etiqueta = 'Gestión Curricular' LIMIT 1),
    'submenu'
);

INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES (
    'Objetivos',
    'Gestionar objetivos de aprendizaje',
    '<i class="nav-icon fas fa-target"></i>',
    '?page=curriculoGestion',
    (SELECT id FROM usr_menu WHERE etiqueta = 'Gestión Curricular' LIMIT 1),
    'submenu'
);
```

### 5. Click: "Ejecutar" (Botón Rojo)

### 6. ¡Listo! Deberías ver "5 filas insertadas"

### 7. Actualizará la página y verás el nuevo menú

---

## Opción 2: Usar HeidiSQL (Si tienes instalado)

### 1. Conectar a MySQL:
- Host: `sofditech-icesi-db`
- Puerto: `53306`
- Usuario: `root`
- Password: `root`
- Base de datos: `icesi`

### 2. Click derecho en base de datos → "New Query"

### 3. Copiar y pegar los comandos SQL de arriba

### 4. Presionar `F9` o click "Execute"

---

## Opción 3: MySQL Workbench (Si tienes instalado)

### 1. Conectar a MySQL

### 2. Nueva query

### 3. Pegar comandos SQL

### 4. Execute

---

## ✅ Verificación

Después de agregar, ejecuta esta query para verificar:

```sql
SELECT id, etiqueta, padre 
FROM usr_menu 
WHERE etiqueta IN ('Gestión Curricular', 'Dashboard', 'Cursos', 'Competencias', 'Objetivos')
ORDER BY padre, id;
```

Deberías ver:
```
id  |  etiqueta            |  padre
--- | -------------------- | ------
X   |  Gestión Curricular  |  0
X+1 |  Dashboard           |  X
X+2 |  Cursos              |  X
X+3 |  Competencias        |  X
X+4 |  Objetivos           |  X
```

---

## 🎯 Después de agregar el menú

1. Cierra sesión en la aplicación
2. Vuelve a iniciar sesión
3. Recarga la página (Ctrl+F5)
4. Deberías ver **"Gestión Curricular"** en el menú lateral

---

## 🐛 Si algo falla

**Error: "Duplicate entry" o "Duplicate key"**
- Significa que ya existe un menú con ese nombre
- Ejecutar primero:
  ```sql
  DELETE FROM usr_menu 
  WHERE etiqueta IN ('Gestión Curricular', 'Dashboard', 'Cursos', 'Competencias', 'Objetivos');
  ```
- Luego ejecutar los INSERT de nuevo

**Error: "Syntax error"**
- Verifica que copiaste todo el SQL correctamente
- Asegúrate de no cortar ninguna línea
- Si es necesario, hazlo de uno en uno

**El menú no aparece**
- Verifica que aparece en la tabla `usr_menu`
- Cierra sesión completamente
- Limpia caché del navegador (Ctrl+Shift+Delete)
- Vuelve a iniciar sesión

---

## 📱 Parámetros importantes del menú

- **etiqueta**: Lo que ves en el menú (Texto)
- **descripcion**: Tooltip al pasar el mouse
- **html**: Ícono (Font Awesome)
- **href**: URL o enlace a la página
- **padre**: ID del menú padre (0 para raíz)
- **tipo**: 'item' (padre) o 'submenu' (hijo)

Si necesitas cambiar:
- URLs: Modifica el valor de `href`
- Íconos: Busca en https://fontawesome.com/
- Etiquetas: Modifica el valor de `etiqueta`

---

**¡Eso es todo!** 🎉

Una vez hayas agregado el menú, el sistema está listo para usarse.
