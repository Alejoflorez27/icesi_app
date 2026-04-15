# 📋 INSTRUCCIONES: INTEGRAR MENÚ DE GESTIÓN CURRICULAR

## Paso 1: Ejecutar Script SQL de Menú

Para que aparezcan las opciones de **Gestión Curricular** en el menú lateral, ejecuta:

```bash
mysql -h sofditech-icesi-db -P 53306 -u root -proot icesi < scripts/002_insert_menu_gestion_curricular.sql
```

### ¿Qué hace este script?
Agrega 5 elementos al menú:
1. **Gestión Curricular** (Menú principal)
   - Dashboard
   - Cursos
   - Competencias
   - Objetivos
   - Análisis

---

## Paso 2: Ajustar URLs de APIs

El JavaScript hace llamadas a las APIs. Dependiendo de tu estructura de rutas, puede necesitarse ajustar. 

**Ubicación del archivo a revisar:**
`application/app/js/curriculoGestion.js`

**Busca las líneas que dicen:**
```javascript
fetch('?route=api&file=cursos&action=listar')
```

**Si tu aplicación usa rutas diferentes, cambiar a:**
```javascript
fetch('?page=api&file=cursos&action=listar')
// O
fetch('/api/cursos/listar')
// O lo que corresponda según tu enrutador
```

---

## Paso 3: Ajustar URLs de JS en HTML

Si el JavaScript está en una carpeta interna, asegúrate de que la referencia sea correcta:

**En `application/app/view/curriculoGestion.php` cambiar:**
```html
<script src="<?=constant('APP_URL')?>/app/js/curriculoGestion.js"></script>
```

**Por la ruta correcta según tu estructura:**
```html
<script src="<?=constant('APP_URL')?>app/js/curriculoGestion.js"></script>
```

---

## Paso 4: Acceder a la Aplicación

1. Abre el navegador: `http://icesi.com:9080/`
2. Inicia sesión si es necesario
3. En el menú lateral, debería aparecer **Gestión Curricular** con sus subopción
4. Haz clic en cualquiera de las opciones

---

## ✅ Verificación

Para verificar que todo está correcto, ejecuta esta consulta SQL:

```sql
SELECT * FROM usr_menu WHERE etiqueta LIKE '%Gestión%' OR etiqueta LIKE '%Curricular%' OR etiqueta IN ('Dashboard', 'Cursos', 'Competencias', 'Objetivos', 'Análisis');
```

Deberías ver **5 registros nuevos** (1 padre + 4 hijos).

---

## 🔧 Troubleshooting

### El menú no aparece
- Verifica que ejecutaste el script SQL correctamente
- Cierra sesión y vuelve a iniciar sesión
- Limpia el caché del navegador (Ctrl+F5)

### Las APIs no responden
- Verifica que los archivos API están en `application/api/`
- Revisa la consola del navegador (F12 > Console)
- Comprueba los nombres de archivos sin espacios ni acentos

### El menú aparece pero los datos no cargan
- Verifica que la base de datos está poblada con datos
- Ejecuta: `scripts/001_create_gestion_curricular.sql`
- Revisa los logs de PHP

### Las rutas de las APIs son incorrectas
- Busca cómo se llaman otros APIs en tu aplicación
- Copiar el patrón de las rutas existentes
- Ajustar `curriculoGestion.js` según sea necesario

---

## 📱 URLs de Menú (Parámetro href)

Si tu aplicación usa parámetros diferentes, ajusta los valores `href` en el menú:

**Actual:**
```
?page=curriculoGestion&section=cursos
```

**Alternativas posibles:**
```
?page=curriculoGestion
?view=curriculoGestion
?module=curriculoGestion
?content=curriculoGestion
```

---

## 📄 Archivos Involucrados

| Archivo | Función |
|---------|---------|
| `scripts/001_create_gestion_curricular.sql` | Crea tablas de BD |
| `scripts/002_insert_menu_gestion_curricular.sql` | **Crea menú** ⭐ |
| `application/app/view/curriculoGestion.php` | Vista principal |
| `application/app/js/curriculoGestion.js` | Lógica JS |
| `application/api/api.cursos.php` | API cursos |
| `application/api/api.competencias.php` | API competencias |
| `application/api/api.objetivos.php` | API objetivos |
| `application/api/api.programas.php` | API programas |

---

## ✨ Resumen

**Si todo funciona:**
1. ✅ Ejecutaste el script SQL de menú
2. ✅ Las URLs de APIs coinciden con tu estructura
3. ✅ Los archivos PHP están en los directorios correctos
4. ✅ La base de datos está poblada
5. ✅ El navegador está actualizado (Ctrl+F5)

**Entonces deberías ver:**
- Menú "Gestión Curricular" en el panel lateral
- 4 submenús: Dashboard, Cursos, Competencias, Objetivos, Análisis
- Tablas con datos al hacer clic

---

**¡Listo para usar!** 🚀
