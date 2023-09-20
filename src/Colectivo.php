<?php
namespace TrabajoSube;

class Colectivo
{
    public $linea;

    public function __construct($linea)
    {
        $this->linea = $linea;
    }

    //Funcion de ejemplo para test
    public function getLinea()
    {
        return $this->linea;
    }

    public function pagarCon($Tarjeta)
    {
        if ($Tarjeta->saldo - $Tarjeta->precio >= $Tarjeta->saldoMinimo) {

            $limiteExcedido = true;

            if (get_class($Tarjeta) == "TrabajoSube\FranquiciaParcial") {
                if (isset($Tarjeta->historialBoletos[1]) && (time() - $Tarjeta->historialBoletos[0]->fecha_hora) < 5) {
                    return false;
                }

                if (isset($Tarjeta->historialBoletos[3])) {
                    for ($i = 0; $i < 3; $i++) {
                        if (date("d/m/Y", $Tarjeta->historialBoletos[$i]->fecha_hora) != date("d/m/Y", $Tarjeta->historialBoletos[$i + 1]->fecha_hora)) {
                            $limiteExcedido = false;
                            break;
                        }
                    }
                }
                else{
                    $limiteExcedido = false;
                }
            }


            if (get_class($Tarjeta) == "TrabajoSube\FranquiciaCompleta") {
                if (isset($Tarjeta->historialBoletos[1])) {
                    if (date("d/m/Y", $Tarjeta->historialBoletos[0]->fecha_hora) != date("d/m/Y", $Tarjeta->historialBoletos[1]->fecha_hora)) {
                        $limiteExcedido = false;
                    }
                }
                else{
                    $limiteExcedido = false;
                }
            }

            if ($limiteExcedido) {
                $Tarjeta->saldo = $Tarjeta->saldo - $Tarjeta->precio;
            } else {
                $Tarjeta->saldo = $Tarjeta->saldo - $Tarjeta->precio + $Tarjeta->descuento;
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