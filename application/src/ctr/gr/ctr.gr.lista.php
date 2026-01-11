<?php

class CtrLista
{

    public static function lugar()
    {
        $result = QuerySQL::select(
            <<<SQL
                select concat(c.pais,'*',c.depto,'*',c.ciudad) as codigo,
                concat(c.nombre,' - ',substr(REPLACE(d.nombre,' ',''),1,3)) as lugar
                from gr_pais p, gr_departamento d, gr_ciudad c
                where p.codigo =d.pais
                and d.pais=c.pais
                and d.depto=c.depto
                order by 2
            SQL,
            array(),
            true,
            "N"
        );

        return BaseResponse::success($result, __CLASS__ . "." . __FUNCTION__);
    }

    
}
