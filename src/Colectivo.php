<?php
namespace TrabajoSube;

class Colectivo
{
    public $linea;
    private $precio = 120;

    public function __construct($linea)
    {
        $this->linea = $linea;
    }

    //Funcion de ejemplo para test
    public function getLinea()
    {
        return $this->linea;
    }
    public function getPrecio()
    {
        return $this->precio;
    }

    //Esta cosa probablemente no ande
    private function limiteExcedido($Tarjeta)
    {
        if (get_class($Tarjeta) == "TrabajoSube\MedioBoleto") {
            if ($Tarjeta->getHistorialBoletos(3) != false) {
                for ($i = 0; $i < 3; $i++) {
                    if (date("d/m/Y", $Tarjeta->getHistorialBoletos($i)->getFecha_Hora()) != date("d/m/Y", $Tarjeta->getHistorialBoletos($i + 1)->getFecha_Hora())) {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else if (get_class($Tarjeta) == "TrabajoSube\BoletoGratuito") {
            if ($Tarjeta->getHistorialBoletos(1) != false) {
                if (date("d/m/Y", $Tarjeta->getHistorialBoletos(0)->getFecha_Hora()) != date("d/m/Y", $Tarjeta->getHistorialBoletos(1)->getFecha_Hora())) {
                    return false;
                }
            } else {
                return false;
            }
        } else if (get_class($Tarjeta) == "TrabajoSube\BoletoGratuitoJubilado") {
            return false;
        }

        return true;
    }

    //Esta cosa tampoco
    public function pagarCon($Tarjeta)
    {
        if ($Tarjeta->saldo - $this->precio >= $Tarjeta->getSaldoMinimo()) {

            if (get_class($Tarjeta) == "TrabajoSube\MedioBoleto" 
            && $Tarjeta->getHistorialBoletos(0) != false 
            && (time() - $Tarjeta->getHistorialBoletos(0)->getFecha_Hora()) < 5) {
                return false;
            } else if ($this->limiteExcedido($Tarjeta)) {
                $Tarjeta->saldo = $Tarjeta->saldo - $this->precio;
            } else {
                $Tarjeta->saldo = $Tarjeta->saldo - $this->precio + $Tarjeta->descuento;
            }

            return $Tarjeta->descontarSaldo($this);
        }

        return false;
    }
}

?>