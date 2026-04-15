-- ============================================================================
-- SCRIPT DE INSERCIÓN DE MENÚ - GESTIÓN CURRICULAR
-- ============================================================================

-- Nota: Asume que la tabla usr_menu existe
-- Si la tabla es diferente, ajustar según corresponda

-- 1. Agregar menú principal: "Gestión Curricular"
INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES (
    'Gestión Curricular',
    'Gestión de cursos, competencias y objetivos de aprendizaje',
    '<i class="nav-icon fas fa-graduation-cap"></i>',
    '#',
    0,
    'item'
) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);

SET @menu_padre_id = LAST_INSERT_ID();

-- 2. Agregar submenú: "Dashboard"
INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES (
    'Dashboard',
    'Visualizar estadísticas y análisis',
    '<i class="nav-icon fas fa-chart-pie"></i>',
    '?page=curriculoGestion&section=dashboard',
    @menu_padre_id,
    'submenu'
) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);

-- 3. Agregar submenú: "Cursos"
INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES (
    'Cursos',
    'Gestionar cursos académicos',
    '<i class="nav-icon fas fa-book"></i>',
    '?page=curriculoGestion&section=cursos',
    @menu_padre_id,
    'submenu'
) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);

-- 4. Agregar submenú: "Competencias"
INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES (
    'Competencias',
    'Gestionar competencias',
    '<i class="nav-icon fas fa-star"></i>',
    '?page=curriculoGestion&section=competencias',
    @menu_padre_id,
    'submenu'
) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);

-- 5. Agregar submenú: "Objetivos"
INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES (
    'Objetivos',
    'Gestionar objetivos de aprendizaje',
    '<i class="nav-icon fas fa-target"></i>',
    '?page=curriculoGestion&section=objetivos',
    @menu_padre_id,
    'submenu'
) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);

-- 6. Agregar submenú: "Análisis"
INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES (
    'Análisis',
    'Ver análisis de cobertura curricular',
    '<i class="nav-icon fas fa-chart-bar"></i>',
    '?page=curriculoGestion&section=analisis',
    @menu_padre_id,
    'submenu'
) ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id);

-- ============================================================================
-- Verificar que se insertaron correctamente
-- ============================================================================
-- SELECT * FROM usr_menu WHERE etiqueta LIKE 'Gestión Curricular%' OR padre = @menu_padre_id;
