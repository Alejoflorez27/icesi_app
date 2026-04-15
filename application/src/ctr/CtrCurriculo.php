<?php

/**
 * Controlador: Gestion Curricular
 * Consolida dashboard, filtros y analisis del modulo.
 */
class CtrCurriculo extends DATABASE
{
    public function __construct()
    {
        parent::__construct(1);
    }

    public function dashboard()
    {
        return [
            'cursos' => $this->listarCursos(),
            'programas' => $this->listarProgramas(),
            'competencias' => $this->listarCompetencias(),
            'objetivos' => $this->listarObjetivos(),
            'objetivosSinAsignar' => $this->countValue("SELECT COUNT(*) AS total FROM v_objetivos_sin_asignar"),
            'competenciasSinObjetivos' => $this->countValue("SELECT COUNT(*) AS total FROM v_competencias_sin_objetivos")
        ];
    }

    public function listarCursos($filtros = [])
    {
        $sql = "SELECT
                    c.id_curso,
                    c.id_programa,
                    c.codigo,
                    c.nombre,
                    c.descripcion,
                    c.creditos,
                    p.nombre AS programa,
                    COUNT(DISTINCT co.id_objetivo) AS total_objetivos,
                    COUNT(DISTINCT o.id_competencia) AS total_competencias,
                    COALESCE(GROUP_CONCAT(DISTINCT comp.nombre ORDER BY comp.nombre SEPARATOR ', '), '') AS competencias,
                    COALESCE(GROUP_CONCAT(DISTINCT o.nombre ORDER BY o.nombre SEPARATOR ', '), '') AS objetivos,
                    COALESCE(GROUP_CONCAT(DISTINCT co.nivel ORDER BY co.nivel SEPARATOR ', '), '') AS niveles
                FROM cursos c
                INNER JOIN programas p ON p.id_programa = c.id_programa
                LEFT JOIN curso_objetivo co ON co.id_curso = c.id_curso
                LEFT JOIN objetivos o ON o.id_objetivo = co.id_objetivo
                LEFT JOIN competencias comp ON comp.id_competencia = o.id_competencia
                WHERE 1=1";

        $params = [];

        if (!empty($filtros['programa'])) {
            $sql .= " AND c.id_programa = :programa";
            $params['programa'] = $filtros['programa'];
        }

        if (!empty($filtros['competencia'])) {
            $sql .= " AND o.id_competencia = :competencia";
            $params['competencia'] = $filtros['competencia'];
        }

        if (!empty($filtros['objetivo'])) {
            $sql .= " AND co.id_objetivo = :objetivo";
            $params['objetivo'] = $filtros['objetivo'];
        }

        if (!empty($filtros['nivel'])) {
            $sql .= " AND co.nivel = :nivel";
            $params['nivel'] = $filtros['nivel'];
        }

        $sql .= " GROUP BY
                    c.id_curso,
                    c.id_programa,
                    c.codigo,
                    c.nombre,
                    c.descripcion,
                    c.creditos,
                    p.nombre
                  ORDER BY c.nombre";

        return $this->fetchAllAssoc($sql, $params);
    }

    public function listarProgramas()
    {
        return $this->fetchAllAssoc(
            "SELECT p.*, COUNT(DISTINCT c.id_curso) AS total_cursos
             FROM programas p
             LEFT JOIN cursos c ON c.id_programa = p.id_programa
             GROUP BY p.id_programa, p.nombre, p.codigo, p.descripcion, p.activa, p.created_at, p.updated_at
             ORDER BY p.nombre"
        );
    }

    public function listarCompetencias()
    {
        return $this->fetchAllAssoc(
            "SELECT c.*,
                    COUNT(DISTINCT o.id_objetivo) AS total_objetivos
             FROM competencias c
             LEFT JOIN objetivos o ON o.id_competencia = c.id_competencia
             GROUP BY c.id_competencia, c.nombre, c.descripcion, c.created_at, c.updated_at
             ORDER BY c.nombre"
        );
    }

    public function listarObjetivos()
    {
        return $this->fetchAllAssoc(
            "SELECT o.*,
                    c.nombre AS competencia,
                    COUNT(DISTINCT co.id_curso) AS total_cursos
             FROM objetivos o
             INNER JOIN competencias c ON c.id_competencia = o.id_competencia
             LEFT JOIN curso_objetivo co ON co.id_objetivo = o.id_objetivo
             GROUP BY o.id_objetivo, o.id_competencia, o.nombre, o.descripcion, o.created_at, o.updated_at, c.nombre
             ORDER BY o.nombre"
        );
    }

    public function obtenerAnalisisCobertura()
    {
        $totalObjetivos = $this->countValue("SELECT COUNT(*) AS total FROM objetivos");
        $objetivosSinAsignar = $this->countValue("SELECT COUNT(*) AS total FROM v_objetivos_sin_asignar");
        $totalCompetencias = $this->countValue("SELECT COUNT(*) AS total FROM competencias");
        $competenciasSinObjetivos = $this->countValue("SELECT COUNT(*) AS total FROM v_competencias_sin_objetivos");

        return [
            'totalObjetivos' => $totalObjetivos,
            'objetivosSinAsignar' => $objetivosSinAsignar,
            'porcentajeObjetivosSin' => $totalObjetivos > 0 ? round(($objetivosSinAsignar / $totalObjetivos) * 100, 2) : 0,
            'totalCompetencias' => $totalCompetencias,
            'competenciasSinObjetivos' => $competenciasSinObjetivos,
            'porcentajeCompetenciasSin' => $totalCompetencias > 0 ? round(($competenciasSinObjetivos / $totalCompetencias) * 100, 2) : 0
        ];
    }

    private function fetchAllAssoc($sql, $params = [])
    {
        $stmt = $this->getDb()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function countValue($sql, $params = [])
    {
        $stmt = $this->getDb()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($row['total'] ?? 0);
    }
}
