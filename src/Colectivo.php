<?php
namespace TrabajoSube;

class Colectivo
{
    public $linea;
    
    public function __construct($linea){
        $this->linea = $linea;
    }
    
    //Funcion de ejemplo para test
    public function getLinea(){
        return $this->linea;
    }

    public function pagarCon($Tarjeta)
    {
        if($Tarjeta->saldo - $Tarjeta->precio >= $Tarjeta->saldoMinimo){

            $Tarjeta->saldo = $Tarjeta->saldo - $Tarjeta->precio;

            $boleto = new Boleto(uniqid(), time(), $this, $Tarjeta);
            array_unshift($Tarjeta->historialBoletos, $boleto);
            return $Tarjeta->saldo;
        }
        else{
            return false;
        }
    }
}

?>