<?php
namespace TrabajoSube;

class Colectivo
{
    protected $linea;
    protected $precio = 120;
    
    public function __construct($linea, $precio=120){
        $this->linea = $linea;
        $this->precio = $precio;
    }
    
    //Funcion de ejemplo para test
    public function getLinea(){
        return $this->linea;
    }

    public function pagarCon($Tarjeta)
    {
        if($Tarjeta->saldo - $this->precio >= $Tarjeta->saldoMinimo){

            $Tarjeta->saldo = $Tarjeta->saldo - $this->precio;

            return "Boleto Pagado. Nuevo saldo: " . $Tarjeta->saldo;
        }
        else{
            return false;
        }
    }
}

?>