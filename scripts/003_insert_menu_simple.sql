-- Agregar menú Gestión Curricular - Versión Simplificada

INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES ('Gestión Curricular', 'Gestión de cursos, competencias y objetivos', '<i class="nav-icon fas fa-graduation-cap"></i>', '#', 0, 'item');

INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES ('Dashboard', 'Visualizar estadísticas', '<i class="nav-icon fas fa-chart-pie"></i>', '?page=curriculoGestion', (SELECT id FROM usr_menu WHERE etiqueta = 'Gestión Curricular' LIMIT 1), 'submenu');

INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES ('Cursos', 'Gestionar cursos académicos', '<i class="nav-icon fas fa-book"></i>', '?page=curriculoGestion', (SELECT id FROM usr_menu WHERE etiqueta = 'Gestión Curricular' LIMIT 1), 'submenu');

INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES ('Competencias', 'Gestionar competencias', '<i class="nav-icon fas fa-star"></i>', '?page=curriculoGestion', (SELECT id FROM usr_menu WHERE etiqueta = 'Gestión Curricular' LIMIT 1), 'submenu');

INSERT INTO usr_menu (etiqueta, descripcion, html, href, padre, tipo) 
VALUES ('Objetivos', 'Gestionar objetivos de aprendizaje', '<i class="nav-icon fas fa-target"></i>', '?page=curriculoGestion', (SELECT id FROM usr_menu WHERE etiqueta = 'Gestión Curricular' LIMIT 1), 'submenu');
