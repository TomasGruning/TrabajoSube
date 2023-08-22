<?php
namespace TrabajoSube;

class Colectivo
{
    public $linea;
    protected $precio = 120;
    function pagarBoleto($Tarjeta)
    {
        $Tarjeta->saldo = $Tarjeta->saldo - $this->precio;

        return "Boleto Pagado. Nuevo saldo: " + $Tarjeta->saldo;
    }
}

?>