<?php
namespace TrabajoSube;

class Boleto
{
    public $fecha;
    public $hora;
    public $id;

    function nuevoRecibo($id, $fecha, $hora, $Colectivo)
    {
        return "Numero de boleto: " + $id + " Fecha: " + $fecha + " Hora: " + $hora + " Linea de colectivo " + $Colectivo->linea + " precio: " + $Colectivo->precio;
    }
}

?>