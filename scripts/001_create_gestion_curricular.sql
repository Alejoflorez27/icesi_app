-- ============================================================================
-- SCRIPT DE CREACIÓN - SISTEMA DE GESTIÓN CURRICULAR
-- Universidad Icesi
-- ============================================================================

-- Crear base de datos si no existe
-- CREATE DATABASE IF NOT EXISTS icesi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE icesi;

-- ============================================================================
-- TABLA: PROGRAMAS ACADÉMICOS
-- ============================================================================
CREATE TABLE IF NOT EXISTS programas (
    id_programa INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_codigo (codigo)
);

-- ============================================================================
-- TABLA: CURSOS
-- ============================================================================
CREATE TABLE IF NOT EXISTS cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    id_programa INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    creditos INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_programa) REFERENCES programas(id_programa) ON DELETE CASCADE,
    INDEX idx_programa (id_programa),
    INDEX idx_codigo (codigo)
);

-- ============================================================================
-- TABLA: COMPETENCIAS
-- ============================================================================
CREATE TABLE IF NOT EXISTS competencias (
    id_competencia INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nombre (nombre)
);

-- ============================================================================
-- TABLA: OBJETIVOS DE APRENDIZAJE
-- ============================================================================
CREATE TABLE IF NOT EXISTS objetivos (
    id_objetivo INT AUTO_INCREMENT PRIMARY KEY,
    id_competencia INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_competencia) REFERENCES competencias(id_competencia) ON DELETE CASCADE,
    INDEX idx_competencia (id_competencia),
    INDEX idx_nombre (nombre)
);

-- ============================================================================
-- TABLA: RELACIÓN CURSO-OBJETIVO
-- Vincula cursos con objetivos y especifica el nivel de contribución
-- Niveles: I (Introduce), F (Fortalece), V (Valora)
-- ============================================================================
CREATE TABLE IF NOT EXISTS curso_objetivo (
    id_curso_objetivo INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT NOT NULL,
    id_objetivo INT NOT NULL,
    nivel ENUM('I', 'F', 'V') NOT NULL COMMENT 'I=Introduce, F=Fortalece, V=Valora',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso) ON DELETE CASCADE,
    FOREIGN KEY (id_objetivo) REFERENCES objetivos(id_objetivo) ON DELETE CASCADE,
    UNIQUE KEY unique_curso_objetivo (id_curso, id_objetivo),
    INDEX idx_curso (id_curso),
    INDEX idx_objetivo (id_objetivo),
    INDEX idx_nivel (nivel)
);

-- ============================================================================
-- VISTAS ÚTILES PARA ANÁLISIS
-- ============================================================================

-- Vista: Cursos con sus competencias y objetivos asociados
CREATE OR REPLACE VIEW v_cursos_competencias_objetivos AS
SELECT 
    c.id_curso,
    c.codigo AS codigo_curso,
    c.nombre AS nombre_curso,
    p.nombre AS programa,
    comp.id_competencia,
    comp.nombre AS nombre_competencia,
    obj.id_objetivo,
    obj.nombre AS nombre_objetivo,
    co.nivel,
    c.creditos
FROM cursos c
INNER JOIN programas p ON c.id_programa = p.id_programa
LEFT JOIN curso_objetivo co ON c.id_curso = co.id_curso
LEFT JOIN objetivos obj ON co.id_objetivo = obj.id_objetivo
LEFT JOIN competencias comp ON obj.id_competencia = comp.id_competencia
ORDER BY c.id_curso, comp.id_competencia, obj.id_objetivo;

-- Vista: Objetivos sin asignar a cursos
CREATE OR REPLACE VIEW v_objetivos_sin_asignar AS
SELECT 
    obj.id_objetivo,
    obj.nombre AS objetivo,
    comp.nombre AS competencia,
    COUNT(co.id_curso_objetivo) AS cursos_asignados
FROM objetivos obj
INNER JOIN competencias comp ON obj.id_competencia = comp.id_competencia
LEFT JOIN curso_objetivo co ON obj.id_objetivo = co.id_objetivo
GROUP BY obj.id_objetivo, obj.nombre, comp.nombre
HAVING COUNT(co.id_curso_objetivo) = 0;

-- Vista: Competencias sin objetivos
CREATE OR REPLACE VIEW v_competencias_sin_objetivos AS
SELECT 
    comp.id_competencia,
    comp.nombre AS competencia,
    COUNT(obj.id_objetivo) AS objetivos_asociados
FROM competencias comp
LEFT JOIN objetivos obj ON comp.id_competencia = obj.id_competencia
GROUP BY comp.id_competencia, comp.nombre
HAVING COUNT(obj.id_objetivo) = 0;

-- Vista: Resumen de cobertura por curso
CREATE OR REPLACE VIEW v_cobertura_cursos AS
SELECT 
    c.id_curso,
    c.codigo,
    c.nombre,
    p.nombre AS programa,
    COUNT(DISTINCT co.id_objetivo) AS total_objetivos,
    COUNT(DISTINCT comp.id_competencia) AS total_competencias
FROM cursos c
INNER JOIN programas p ON c.id_programa = p.id_programa
LEFT JOIN curso_objetivo co ON c.id_curso = co.id_curso
LEFT JOIN objetivos obj ON co.id_objetivo = obj.id_objetivo
LEFT JOIN competencias comp ON obj.id_competencia = comp.id_competencia
GROUP BY c.id_curso, c.codigo, c.nombre, p.nombre;

-- ============================================================================
-- DATOS DE EJEMPLO (Comentar o eliminar según sea necesario)
-- ============================================================================

-- Insertar programas de ejemplo
INSERT INTO programas (nombre, codigo, descripcion) VALUES
('Ingeniería en Sistemas', 'IS', 'Programa de pregrado en Ingeniería de Sistemas'),
('Administración de Empresas', 'AE', 'Programa de pregrado en Administración de Empresas'),
('Contabilidad', 'CO', 'Programa de pregrado en Contabilidad')
ON DUPLICATE KEY UPDATE id_programa = id_programa;

-- Insertar competencias de ejemplo
INSERT INTO competencias (nombre, descripcion) VALUES
('Pensamiento Crítico', 'Capacidad para analizar información y tomar decisiones fundamentadas'),
('Trabajo en Equipo', 'Capacidad para colaborar efectivamente con otros'),
('Comunicación Efectiva', 'Capacidad para expresar ideas de forma clara'),
('Resolución de Problemas', 'Capacidad para identificar y resolver problemas complejos')
ON DUPLICATE KEY UPDATE id_competencia = id_competencia;

-- Insertar objetivos de aprendizaje de ejemplo
INSERT INTO objetivos (id_competencia, nombre, descripcion) VALUES
(1, 'Analizar problemas desde múltiples perspectivas', 'El estudiante debe ser capaz de examinar un problema desde diferentes ángulos'),
(1, 'Evaluar la validez de argumentos', 'El estudiante debe poder criticar constructivamente ideas y propuestas'),
(2, 'Colaborar en proyectos interdisciplinarios', 'El estudiante debe trabajar efectivamente en equipos diversos'),
(2, 'Delegar responsabilidades', 'El estudiante debe saber asignar tareas apropiadamente'),
(3, 'Presentar resultados oralmente', 'El estudiante debe comunicar hallazgos de forma clara'),
(3, 'Redactar documentos técnicos', 'El estudiante debe escribir informes claros y precisos')
ON DUPLICATE KEY UPDATE id_objetivo = id_objetivo;

-- Insertar cursos de ejemplo
INSERT INTO cursos (id_programa, nombre, codigo, descripcion, creditos) VALUES
(1, 'Fundamentos de Programación', 'IS-101', 'Introducción a la programación con Python', 4),
(1, 'Estructura de Datos', 'IS-201', 'Estudio de estructuras de datos y algoritmos', 4),
(1, 'Base de Datos', 'IS-301', 'Diseño e implementación de bases de datos', 4),
(2, 'Contabilidad Financiera', 'AE-101', 'Principios de contabilidad financiera', 3),
(2, 'Gestión de Proyectos', 'AE-201', 'Metodologías de gestión de proyectos', 3),
(3, 'Contabilidad General', 'CO-101', 'Fundamentos de contabilidad', 3)
ON DUPLICATE KEY UPDATE id_curso = id_curso;

-- Insertar relaciones curso-objetivo de ejemplo
INSERT INTO curso_objetivo (id_curso, id_objetivo, nivel) VALUES
-- Curso IS-101
(1, 1, 'I'), (1, 2, 'I'), (1, 3, 'I'),
-- Curso IS-201
(2, 1, 'F'), (2, 2, 'F'), (2, 5, 'I'),
-- Curso IS-301
(3, 1, 'V'), (3, 2, 'V'), (3, 6, 'F'),
-- Curso AE-101
(4, 1, 'I'), (4, 5, 'F'),
-- Curso AE-201
(5, 3, 'F'), (5, 4, 'F'), (5, 5, 'I'), (5, 6, 'I'),
-- Curso CO-101
(6, 1, 'I'), (6, 3, 'I')
ON DUPLICATE KEY UPDATE id_curso_objetivo = id_curso_objetivo;

-- ============================================================================
-- FIN DEL SCRIPT
-- ============================================================================
