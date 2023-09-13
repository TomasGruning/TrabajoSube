<?php
namespace TrabajoSube;

class Colectivo
{
    protected $linea;
    
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

            return "Boleto Pagado. Nuevo saldo: " . $Tarjeta->saldo;
        }
        else{
            return false;
        }
    }
}

?>