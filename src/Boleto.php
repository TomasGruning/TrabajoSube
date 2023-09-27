<?php
namespace TrabajoSube;

class Boleto
{
    private $id;
    private $fecha_hora;
    public $Colectivo;
    private $Tarjeta;

    public function __construct($id, $fecha_hora, $Colectivo, $Tarjeta)
    {
        $this->id = $id;
        $this->fecha_hora = $fecha_hora;
        $this->Colectivo = $Colectivo;
        $this->Tarjeta = $Tarjeta;
    }

    public function getTarjeta()
    {
        return $this->Tarjeta;
    }
    public function getFecha_Hora()
    {
        return $this->fecha_hora;
    }

    function imprimirRecibo()
    {
        return
            "ID Boleto: " . $this->id .
            "\n Fecha y hora: " . date("d/m/Y H:i:s", $this->fecha_hora) .
            "\n Linea de colectivo: " . $this->Colectivo->linea .
            "\n Precio: " . $this->Colectivo->getPrecio() .
            "\n ID Tarjeta: " . $this->Tarjeta->id .
            "\n Tipo de tarjeta: " . get_class($this->Tarjeta) .
            "\n Saldo restante: " . $this->Tarjeta->saldo;
    }
}

?>