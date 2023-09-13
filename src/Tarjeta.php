<?php
namespace TrabajoSube;

class Tarjeta
{
    public $id;
    public $saldo;
    public $precio = 120;
    public $saldoMinimo = -211.84;
    public $recargasPosibles = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];
    public $historialBoletos = [];
    
    
    public function __construct($id, $saldo=0)
    {
        $this->id = $id;
        $this->saldo = $saldo;
    }

    public function recargarSaldo($recarga)
    {
        if(($this->saldo + $recarga) > 6600){
            return "El saldo maximo de $6600 ha sido superado";
        }
        
        else{
            for($i = 0; $i < 23; $i++){
                if ($recarga == $this->recargasPosibles[$i]) {
                    $this->saldo = $this->saldo + $recarga;
                    return $this->saldo;
                }
            }
            return false;
        }

    }

}

?>