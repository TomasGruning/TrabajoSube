<?php
namespace TrabajoSube;

class Boleto
{
    public $id;
    public $fecha_hora;
    public $Colectivo;
    public $Tarjeta;

    public function __construct($id, $fecha_hora, $Colectivo, $Tarjeta)
    {
        $this->id = $id;
        $this->fecha_hora = $fecha_hora;
        $this->Colectivo = $Colectivo;
        $this->Tarjeta = $Tarjeta;
    }

    function imprimirRecibo()
    {
        return
            "ID Boleto: " . $this->id .
            "\n Fecha y hora: " . date("d/m/Y H:i:s", $this->fecha_hora) .
            "\n Linea de colectivo: " . $this->Colectivo->linea .
            "\n Precio: " . $this->Colectivo->precio .
            "\n ID Tarjeta: " . $this->Tarjeta->id .
            "\n Tipo de tarjeta: " . get_class($this->Tarjeta) .
            "\n Saldo restante: " . $this->Tarjeta->saldo;
    }
}

?>