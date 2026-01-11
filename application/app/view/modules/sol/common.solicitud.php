<?php
$clientes_enrol = array();
$is_selectable_cliente_rol = CtrUsuario::isSelectableClientRol();
if ($is_selectable_cliente_rol) {
    $resp_clientes = CtrTrcEmpresa::empresasPadre();
    if (Result::isSuccess($resp_clientes))
        $clientes_enrol = Result::getData($resp_clientes);
}

$filter_estados_solicitud = CtrConfiguracion::consultarTodosCategoria('estado_solicitud');
$filter_combos = CtrSrvCombos::findCombosActive();
//$filter_combos_cliente = CtrSrvCombos::conbosClientes();
