<?php

class CtrSolFormacion
{
    //Crear una formacion academica
    public static function crear($id_solicitud, $id_servicio, $nivel_escolaridad, $nombre_institucion, $programa_academico, $fch_grado, $acta_folio, $nom_funcionario, $tel_funcionario, $obs_academica)
    {
        if (!isset($id_solicitud) || $id_solicitud == "")
            return BaseResponse::error(__FUNCTION__, "Id Solicitud es requerido");

        /*if (!isset($id_servicio) || $id_servicio == "")
            return BaseResponse::error(__FUNCTION__, "Id Servicio es requerido");*/

        $obj_solFormacion = new SolFormacion();
        $obj_solFormacion->setProperty('id_solicitud', $id_solicitud);
        $obj_solFormacion->setProperty('id_servicio', $id_servicio);
        $obj_solFormacion->setProperty('nivel_escolaridad', $nivel_escolaridad);
        $obj_solFormacion->setProperty('nombre_institucion', $nombre_institucion);
        $obj_solFormacion->setProperty('programa_academico', $programa_academico);
        $obj_solFormacion->setProperty('fch_grado', $fch_grado);
        $obj_solFormacion->setProperty('acta_folio', $acta_folio);
        $obj_solFormacion->setProperty('nom_funcionario', $nom_funcionario);
        $obj_solFormacion->setProperty('tel_funcionario', $tel_funcionario);
        $obj_solFormacion->setProperty('obs_academica', $obs_academica);
        

        $result = $obj_solFormacion->insert();
        if ($result['success']) {
            return BaseResponse::success($result);
        } else {
            return BaseResponse::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Crear una formacion academica
    //listar los estudios del candidato
    public static function findAll($id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT sf.id_formacion, sf.id_solicitud, sf.nivel_escolaridad,sf.nombre_institucion, c2.descripcion AS descripcion_niv_escol,
                   sf.programa_academico, sf.fch_grado, sf.acta_folio, sf.usr_create, sf.fch_create 
            FROM sol_formacion sf, configurations c2
            WHERE sf.id_solicitud = :id_solicitud
            and c2.codigo =  sf.nivel_escolaridad 
            and c2.categoria = 'tipo_nivel_escolar' 
            and id_servicio is null;
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin de listar los estudios del candidato
    //listar los estudios del candidato
    public static function findAllVisitas($id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT sf.id_formacion, sf.id_solicitud, sf.nivel_escolaridad,sf.nombre_institucion, c2.descripcion AS descripcion_niv_escol,
                   sf.programa_academico, sf.fch_grado, sf.acta_folio, sf.usr_create, sf.fch_create 
            FROM sol_formacion sf, configurations c2
            WHERE sf.id_solicitud = :id_solicitud
            -- and sf.id_servicio = :id_servicio
            and c2.codigo =  sf.nivel_escolaridad 
            and c2.categoria = 'tipo_nivel_escolar'  
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin de listar los estudios del candidato

    //listar los estudios del candidato
    public static function findAllEstudioConfiabilidad($id_solicitud)
    {

        $result = QuerySQL::select(
            <<<SQL
            SELECT sf.id_formacion, 
                   sf.id_solicitud, 
                   sf.nivel_escolaridad,
                   sf.nombre_institucion,
                   fcn_desc_configurations('tipo_nivel_escolar', sf.nivel_escolaridad ) descripcion_niv_escol,
                   sf.programa_academico, 
                   sf.fch_grado, 
                   sf.acta_folio,
                   sf.nom_funcionario,
                   sf.tel_funcionario,
                   sf.obs_academica,
                   sf.usr_create, 
                   sf.fch_create 
            FROM sol_formacion sf
            WHERE sf.id_solicitud = :id_solicitud
            -- and sf.id_servicio = :id_servicio 
            SQL,
            array("id_solicitud" => $id_solicitud),
            true,
            "N"
        );

        return Result::success($result, "buscar formacion");
    }//Fin de listar los estudios del candidato

    //Editar un registro de formacion academica del candidato
    public static function findByIdFormacion($id_formacion)
    {
        if (!isset($id_formacion) || $id_formacion == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $result = QuerySQL::select(
            <<<SQL
                select sf.id_formacion, 
                       sf.id_solicitud, 
                       sf.nivel_escolaridad, 
                       sf.nombre_institucion, 
                       sf.programa_academico, 
                       sf.fch_grado, 
                       sf.acta_folio, 
                       sf.nom_funcionario, 
                       sf.tel_funcionario,
                       sf.obs_academica, 
                       sf.usr_create, 
                       sf.fch_create
                    from sol_formacion sf, sol_solicitud sc
                    where sf.id_solicitud  = sc.id_solicitud
                    and  sf.id_formacion  = :id_formacion
            SQL,
            array("id_formacion" => $id_formacion),
            false,
            "N"
        );

        return Result::success($result, "buscar formación");
    }//Fin de Editar un registro de formacion academica del candidato

    //Borrar un registro por id
    public static function delete($id_formacion)
    {
        if (!isset($id_formacion) || $id_formacion == "")
            return Result::error(__FUNCTION__, "id es requerido");

        $dao = new SolFormacion($id_formacion);

        $result =  $dao->delete();
        if ($result['success']) {
            return Result::success($result);
        } else {
            return Result::error(__CLASS__ . "." . __FUNCTION__, $result);
        }
    }//Fin de Borrar un registro por id

    //Actualizar la Formacion Academica
/**
 * Actualiza un registro de Formación Académica.
 *
 * @param int $id_formacion           ID del registro de formación.
 * @param string $nivel_escolaridad   Nivel de escolaridad.
 * @param string $nombre_institucion  Nombre de la institución educativa.
 * @param string $programa_academico  Nombre del programa académico.
 * @param string $fch_grado           Fecha de grado (YYYY-MM-DD).
 * @param string $acta_folio          Número de acta o folio.
 * @param string|null $nom_funcionario Nombre del funcionario (opcional según servicio).
 * @param string|null $tel_funcionario Teléfono del funcionario (opcional según servicio).
 * @param string|null $obs_academica  Observaciones académicas (opcional según servicio).
 * @param int $id_servicio            ID del servicio relacionado.
 * 
 * @return array Resultado con estado de éxito o error.
 */
public static function update(
    $id_formacion,
    $nivel_escolaridad,
    $nombre_institucion,
    $programa_academico,
    $fch_grado,
    $acta_folio,
    $nom_funcionario = null,
    $tel_funcionario = null,
    $obs_academica = null,
    $id_servicio
) {
    // 🧩 Validar ID obligatorio
    if (empty($id_formacion)) {
        return Result::error(__FUNCTION__, "El ID de formación es requerido.");
    }

    // 🧩 Validar campos requeridos básicos
    $camposObligatorios = [
        'nivel_escolaridad' => $nivel_escolaridad,
        'nombre_institucion' => $nombre_institucion,
        'programa_academico' => $programa_academico,
        //'fch_grado' => $fch_grado,
        //'acta_folio' => $acta_folio
    ];

    foreach ($camposObligatorios as $campo => $valor) {
        if (empty($valor)) {
            return Result::error(__FUNCTION__, "El campo '{$campo}' es obligatorio.");
        }
    }

    try {
        $dao = new SolFormacion($id_formacion);

        // 🧱 Asignar propiedades comunes
        $propiedadesComunes = [
            'nivel_escolaridad' => $nivel_escolaridad,
            'nombre_institucion' => $nombre_institucion,
            'programa_academico' => $programa_academico,
            'fch_grado' => $fch_grado,
            'acta_folio' => $acta_folio
        ];

        foreach ($propiedadesComunes as $campo => $valor) {
            $dao->setProperty($campo, $valor);
        }

        // ⚙️ Propiedades específicas según servicio
        switch ((int)$id_servicio) {
            case 3:
                // Servicio 3 → solo campos comunes
                break;

            case 8:
            case 9:
                // Servicios 8 y 9 → agregar observaciones
                // Usar isset en lugar de !empty para permitir strings vacíos
                $dao->setProperty('obs_academica', $obs_academica);
                break;

            default:
                // Otros servicios → incluir todo
                // Siempre establecer los valores, incluso si son null o vacíos
                $dao->setProperty('nom_funcionario', $nom_funcionario);
                $dao->setProperty('tel_funcionario', $tel_funcionario);
                $dao->setProperty('obs_academica', $obs_academica);
                break;
        }

        // 💾 Ejecutar actualización
        $result = $dao->update();

        return $result['success']
            ? Result::success($result)
            : Result::error(__CLASS__ . "." . __FUNCTION__, $result);

    } catch (Exception $e) {
        return Result::error(__CLASS__ . "." . __FUNCTION__, "Error al actualizar: " . $e->getMessage());
    }
}

}
