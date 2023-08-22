<?php
namespace TrabajoSube;

class Tarjeta
{
    protected $id;
    public $nombre;
    private $saldo;
    public $recarga;
    public $recargasPosibles = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];

    function nuevaTarjeta($id, $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->saldo = 0;

        return "Nueva tarjeta creada. ID: " + $this->id + "Titular: " + $this->nombre;
    }

    function recargarSaldo($id, $recarga, $recargasPosibles)
    {
        if(($this->saldo + $recarga) > 6600){
            return "El saldo maximo de $6600 ha sido superado";
        }
        
        else{
            for($i = 0; $i < 23; $i++){
                if ($recarga == $recargasPosibles[$i]) {
                    $this->saldo = $this->saldo + $recarga;
                    return "Recarga completa. Nuevo saldo: " + $this->saldo;
                }
            }
            return "No se reconoce la cantidad a recargar";
        }

    }

}

?>