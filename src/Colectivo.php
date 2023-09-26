<?php
namespace TrabajoSube;

class Colectivo
{
    public $linea;
    public $precio = 120;

    public function __construct($linea)
    {
        $this->linea = $linea;
    }

    //Funcion de ejemplo para test
    public function getLinea()
    {
        return $this->linea;
    }

    public function limiteExcedido($Tarjeta){
        if (get_class($Tarjeta) == "TrabajoSube\MedioBoleto") {
            if (isset($Tarjeta->historialBoletos[3])) {
                for ($i = 0; $i < 3; $i++) {
                    if (date("d/m/Y", $Tarjeta->historialBoletos[$i]->fecha_hora) != date("d/m/Y", $Tarjeta->historialBoletos[$i + 1]->fecha_hora)) {
                        return false;
                    }
                }
            }
            else{
                return false;
            }
        }

        else if (get_class($Tarjeta) == "TrabajoSube\BoletoGratuito") {
            if (isset($Tarjeta->historialBoletos[1])) {
                if (date("d/m/Y", $Tarjeta->historialBoletos[0]->fecha_hora) != date("d/m/Y", $Tarjeta->historialBoletos[1]->fecha_hora)) {
                    return false;
                }
            }
            else{
                return false;
            }
        }

        else if (get_class($Tarjeta) == "TrabajoSube\BoletoGratuitoJubilado"){
            return false;
        }

        return true;
    }

    public function pagarCon($Tarjeta)
    {
        if ($Tarjeta->saldo - $this->precio >= $Tarjeta->saldoMinimo) {

            if (get_class($Tarjeta) == "TrabajoSube\MedioBoleto") {
                if (isset($Tarjeta->historialBoletos[0]) && (time() - $Tarjeta->historialBoletos[0]->fecha_hora) < 5) {
                    return false;
                }
            }

            if ($this->limiteExcedido($Tarjeta)) {
                $Tarjeta->saldo = $Tarjeta->saldo - $this->precio;
            } else {
                $Tarjeta->saldo = $Tarjeta->saldo - $this->precio + $Tarjeta->descuento;
            }

            $Tarjeta->recargarSaldo($Tarjeta->cargaPendiente);

            $boleto = new Boleto(uniqid(), time(), $this, $Tarjeta);

            array_unshift($Tarjeta->historialBoletos, $boleto);

            return $Tarjeta->saldo;
        }

        return false;
    }
}

?>