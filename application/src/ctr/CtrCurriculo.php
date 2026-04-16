<?php

class CtrCurriculo
{
    public static function dashboard()
    {
        $cursos = self::listarCursos();
        $programas = self::listarProgramas();
        $competencias = self::listarCompetencias();
        $objetivos = self::listarObjetivos();
        $objetivosSinAsignar = self::countObjetivosSinAsignar();
        $competenciasSinObjetivos = self::countCompetenciasSinObjetivos();

        return Result::success(
            array(
                'cursos' => Result::getData($cursos),
                'programas' => Result::getData($programas),
                'competencias' => Result::getData($competencias),
                'objetivos' => Result::getData($objetivos),
                'objetivosSinAsignar' => $objetivosSinAsignar,
                'competenciasSinObjetivos' => $competenciasSinObjetivos
            ),
            "dashboard curricular"
        );
    }

    public static function listarCursos($filtros = array())
    {
        $programa = isset($filtros['programa']) && $filtros['programa'] !== "" ? $filtros['programa'] : null;
        $competencia = isset($filtros['competencia']) && $filtros['competencia'] !== "" ? $filtros['competencia'] : null;
        $objetivo = isset($filtros['objetivo']) && $filtros['objetivo'] !== "" ? $filtros['objetivo'] : null;
        $nivel = isset($filtros['nivel']) && $filtros['nivel'] !== "" ? $filtros['nivel'] : null;

        $result = QuerySQL::select(
            <<<SQL
                SELECT
                    c.id_curso,
                    c.id_programa,
                    c.codigo,
                    c.nombre,
                    c.descripcion,
                    c.creditos,
                    p.nombre AS programa,
                    COUNT(DISTINCT co.id_objetivo) AS total_objetivos,
                    COUNT(DISTINCT o.id_competencia) AS total_competencias,
                    GROUP_CONCAT(DISTINCT comp.nombre ORDER BY comp.nombre SEPARATOR '||') AS competencias,
                    GROUP_CONCAT(
                        DISTINCT CONCAT(o.nombre, ' [', co.nivel, ']')
                        ORDER BY o.nombre
                        SEPARATOR '||'
                    ) AS objetivos_nivel,
                    GROUP_CONCAT(
                        DISTINCT co.nivel
                        ORDER BY FIELD(co.nivel, 'I', 'F', 'V')
                        SEPARATOR ', '
                    ) AS niveles
                FROM cursos c
                INNER JOIN programas p ON p.id_programa = c.id_programa
                LEFT JOIN curso_objetivo co ON co.id_curso = c.id_curso
                LEFT JOIN objetivos o ON o.id_objetivo = co.id_objetivo
                LEFT JOIN competencias comp ON comp.id_competencia = o.id_competencia
                WHERE (:programa IS NULL OR c.id_programa = :programa)
                  AND (:competencia IS NULL OR o.id_competencia = :competencia)
                  AND (:objetivo IS NULL OR co.id_objetivo = :objetivo)
                  AND (:nivel IS NULL OR co.nivel = :nivel)
                GROUP BY
                    c.id_curso,
                    c.id_programa,
                    c.codigo,
                    c.nombre,
                    c.descripcion,
                    c.creditos,
                    p.nombre
                ORDER BY c.nombre
            SQL,
            array(
                "programa" => $programa,
                "competencia" => $competencia,
                "objetivo" => $objetivo,
                "nivel" => $nivel
            ),
            true,
            "N"
        );

        return Result::success($result, "listar cursos curriculares");
    }

    public static function listarProgramas()
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT 
                    p.*,
                    COUNT(DISTINCT c.id_curso) AS total_cursos
                FROM programas p
                LEFT JOIN cursos c ON c.id_programa = p.id_programa
                GROUP BY
                    p.id_programa,
                    p.nombre,
                    p.codigo,
                    p.descripcion,
                    p.created_at,
                    p.updated_at
                ORDER BY p.nombre
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "listar programas");
    }

    public static function listarCompetencias()
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT
                    c.*,
                    COUNT(DISTINCT o.id_objetivo) AS total_objetivos
                FROM competencias c
                LEFT JOIN objetivos o ON o.id_competencia = c.id_competencia
                GROUP BY
                    c.id_competencia,
                    c.nombre,
                    c.descripcion,
                    c.created_at,
                    c.updated_at
                ORDER BY c.nombre
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "listar competencias");
    }

    public static function listarObjetivos()
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT
                    o.*,
                    c.nombre AS competencia,
                    COUNT(DISTINCT co.id_curso) AS total_cursos
                FROM objetivos o
                INNER JOIN competencias c ON c.id_competencia = o.id_competencia
                LEFT JOIN curso_objetivo co ON co.id_objetivo = o.id_objetivo
                GROUP BY
                    o.id_objetivo,
                    o.id_competencia,
                    o.nombre,
                    o.descripcion,
                    o.created_at,
                    o.updated_at,
                    c.nombre
                ORDER BY o.nombre
            SQL,
            array(),
            true,
            "N"
        );

        return Result::success($result, "listar objetivos");
    }

    public static function obtenerAnalisisCobertura()
    {
        $totalObjetivos = self::countTabla("objetivos", "id_objetivo");
        $objetivosSinAsignar = self::countObjetivosSinAsignar();
        $totalCompetencias = self::countTabla("competencias", "id_competencia");
        $competenciasSinObjetivos = self::countCompetenciasSinObjetivos();

        $result = array(
            'totalObjetivos' => $totalObjetivos,
            'objetivosSinAsignar' => $objetivosSinAsignar,
            'porcentajeObjetivosSin' => $totalObjetivos > 0 ? round(($objetivosSinAsignar / $totalObjetivos) * 100, 2) : 0,
            'totalCompetencias' => $totalCompetencias,
            'competenciasSinObjetivos' => $competenciasSinObjetivos,
            'porcentajeCompetenciasSin' => $totalCompetencias > 0 ? round(($competenciasSinObjetivos / $totalCompetencias) * 100, 2) : 0
        );

        return Result::success($result, "analisis cobertura curricular");
    }

    private static function countTabla($tabla, $campo)
    {
        $result = QuerySQL::select(
            "SELECT COUNT($campo) AS total FROM $tabla",
            array(),
            false,
            "N"
        );

        return intval($result['total'] ?? 0);
    }

    private static function countObjetivosSinAsignar()
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT COUNT(*) AS total
                FROM v_objetivos_sin_asignar
            SQL,
            array(),
            false,
            "N"
        );

        return intval($result['total'] ?? 0);
    }

    private static function countCompetenciasSinObjetivos()
    {
        $result = QuerySQL::select(
            <<<SQL
                SELECT COUNT(*) AS total
                FROM v_competencias_sin_objetivos
            SQL,
            array(),
            false,
            "N"
        );

        return intval($result['total'] ?? 0);
    }
}
