# Guía de Importación/Exportación de Datos desde Excel

## 📊 Formato de Datos Excel Esperado

### Estructura de Hojas Excel

El archivo Excel debe contener las siguientes hojas:

#### 1. **Programas**
| id_programa | nombre | codigo | descripcion |
|---|---|---|---|
| 1 | Ingeniería en Sistemas | IS | Programa de pregrado |
| 2 | Administración de Empresas | AE | Administración |

#### 2. **Competencias**
| id_competencia | nombre | descripcion |
|---|---|---|
| 1 | Pensamiento Crítico | Capacidad para analizar... |
| 2 | Trabajo en Equipo | Colaboración efectiva... |

#### 3. **Objetivos**
| id_objetivo | id_competencia | nombre | descripcion |
|---|---|---|---|
| 1 | 1 | Analizar problemas | El estudiante debe... |
| 2 | 1 | Evaluar argumentos | El estudiante puede... |

#### 4. **Cursos**
| id_curso | id_programa | nombre | codigo | descripcion | creditos |
|---|---|---|---|---|---|
| 1 | 1 | Fundamentos de Programación | IS-101 | Introducción a Python | 4 |
| 2 | 1 | Estructura de Datos | IS-201 | Estudio de estructuras | 4 |

#### 5. **Curso_Objetivo**
| id_curso | id_objetivo | nivel |
|---|---|---|
| 1 | 1 | I |
| 1 | 2 | I |
| 2 | 1 | F |

## 🔄 Importación Manual

### Opción 1: phpMyAdmin

1. Abrir phpMyAdmin
2. Seleccionar base de datos `icesi`
3. Ir a Importar
4. Cargar el archivo SQL `scripts/001_create_gestion_curricular.sql`

### Opción 2: MySQL Command Line

```bash
mysql -h sofditech-icesi-db -P 53306 -u root -p icesi < scripts/001_create_gestion_curricular.sql
```

## 📤 Exportación de Datos Actuales

### Crear Excel con datos actuales

```sql
-- Exportar desde MySQL con SELECT INTO OUTFILE
SELECT * FROM programas 
INTO OUTFILE '/var/lib/mysql/programas.csv' 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"' 
LINES TERMINATED BY '\n';
```

O usar phpmyadmin.

## 🐍 Script Python para Importar Excel (Opcional)

```python
import pandas as pd
import pymysql

# Configuración de conexión
conn = pymysql.connect(
    host='sofditech-icesi-db',
    port=53306,
    user='root',
    password='root',
    database='icesi'
)

# Leer Excel
excel_file = 'datos_curriculares.xlsx'
xls = pd.ExcelFile(excel_file)

# Importar cada hoja
for sheet in xls.sheet_names:
    df = pd.read_excel(excel_file, sheet_name=sheet)
    
    # Limpiar nombres de columnas
    df.columns = df.columns.str.lower().str.strip()
    
    # Insertar en tabla (nombre de tabla = nombre de hoja)
    table_name = sheet.lower()
    
    cursor = conn.cursor()
    for index, row in df.iterrows():
        columns = ', '.join(df.columns)
        placeholders = ', '.join(['%s'] * len(df.columns))
        sql = f"INSERT INTO {table_name} ({columns}) VALUES ({placeholders})"
        cursor.execute(sql, tuple(row))
    
    conn.commit()

conn.close()
print("Importación completada")
```

## 📋 Checklist de Importación

- [ ] Base de datos creada
- [ ] Tablas creadas correctamente
- [ ] Datos de ejemplo insertados
- [ ] Vistas creadas
- [ ] Conectar desde aplicación

## ⚠️ Consideraciones Importantes

### Validación de Datos
- Los códigos de programa y curso deben ser únicos
- Un objetivo debe tener una competencia válida
- Un curso debe tener un programa válido
- Los niveles deben ser I, F o V

### Truncar datos antes de reimportar
```sql
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE curso_objetivo;
TRUNCATE TABLE cursos;
TRUNCATE TABLE objetivos;
TRUNCATE TABLE competencias;
TRUNCATE TABLE programas;
SET FOREIGN_KEY_CHECKS=1;
```

### Respetar orden de inserción
1. Programas
2. Competencias
3. Cursos
4. Objetivos
5. Curso_Objetivo

## 🔗 Relaciones Clave

```
Programas (1) ──────→ (N) Cursos
Competencias (1) ──→ (N) Objetivos
Cursos (N) ←──────→ (N) Objetivos (Relación M:M a través de curso_objetivo)
```

## 📌 Notas

- Mantener integridad referencial
- Hacer respaldos antes de grandes cambios
- Validar datos antes de importar
