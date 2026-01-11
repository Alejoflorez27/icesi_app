<?php

class SMS {

    public $api_cliente, $api_clave;

    function __construct($cliente, $clave) {
        $this->api_cliente = $cliente;
        $this->api_clave = $clave;
    }

    public function envio($destinatarios, $sms_texto, $fecha = "", $campaña = "") {

        $url = 'https://api.hablame.co/sms/envio/';

        $data = array(
            'cliente' => $this->api_cliente, //Numero de cliente
            'api' => $this->api_clave, //Clave API suministrada
            'numero' => $destinatarios, //numero o numeros telefonicos a enviar el SMS (separados por una coma ,)
            'sms' => $sms_texto, //Mensaje de texto a enviar
            'fecha' => $fecha, //(campo opcional) Fecha de envio, si se envia vacio se envia inmediatamente (Ejemplo: 2017-12-31 23:59:59)
            'referencia' => $campaña, //(campo opcional) Numero de referencio ó nombre de campaña
        );

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = json_decode((file_get_contents($url, false, $context)), true); // ENVIADO si $result === 0 :

        return $result;
    }

    public function saldo() {

        $url = 'https://api.hablame.co/saldo/consulta/index.php';

        $data = array(
            'cliente' => $this->api_cliente, //Numero de cliente
            'api' => $this->api_clave, //Clave API suministrada
        );

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = json_decode((file_get_contents($url, false, $context)), true);

        return $result;
    }

}
