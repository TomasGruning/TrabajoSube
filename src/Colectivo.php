<?php
namespace TrabajoSube;

class Colectivo
{
    protected $linea;
    public $precio = 120;

    public function __construct($linea)
    {
        $this->linea = $linea;
    }

    //    Funcion de ejemplo para test
    public function getLinea()
    {
        return $this->linea;
    }

    function pagarBoleto($Tarjeta)
    {
        $Tarjeta->saldo = $Tarjeta->saldo - $this->precio;

        return "Boleto Pagado. Nuevo saldo: " + $Tarjeta->saldo;
    }
}

?>