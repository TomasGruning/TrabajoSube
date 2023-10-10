<?php
namespace TrabajoSube;

class Colectivo
{
    public $linea;
    protected $precio = 120;

    public function __construct($linea)
    {
        $this->linea = $linea;
    }

    public function getLinea()
    {
        return $this->linea;
    }
    public function getPrecio()
    {
        return $this->precio;
    }

    private function limiteExcedido($Tarjeta, $Tiempo)
    {
        if (get_class($Tarjeta) != "TrabajoSube\Tarjeta") {
            // Obtiene el día de la semana (0 para domingo, 6 para sábado) y la hora actual
            $diaSemana = date("w", $Tiempo);
            $hora = date("G", $Tiempo);

            // Verifica si es fin de semana o si la hora está fuera del horario permitido (6:00 a 22:00)
            if ($diaSemana == 0 || $diaSemana == 6 || $hora < 6 || $hora > 22) {
                return true;
            }
        } else {
            return false; // No se excede el límite para tarjetas de tipo TrabajoSube\Tarjeta
        }

        // Verifica el tipo de tarjeta y aplica lógica específica para cada tipo

        if (get_class($Tarjeta) == "TrabajoSube\MedioBoleto") {
            if ($Tarjeta->getHistorialBoletos(3) != false) {
                // Si los ultimos cuatro boletos no tienen la misma fecha no se exede el limite
                for ($i = 0; $i < 3; $i++) {
                    if (date("d/m/Y", $Tarjeta->getHistorialBoletos($i)->getFecha_Hora()) != date("d/m/Y", $Tarjeta->getHistorialBoletos($i + 1)->getFecha_Hora())) {
                        return false;
                    }
                }
            } else {
                return false; // No se excede el límite si no hay cuatro boletos en el historial
            }
        } else if (get_class($Tarjeta) == "TrabajoSube\BoletoGratuito") {
            if ($Tarjeta->getHistorialBoletos(1) != false) {
                // Si los ultimos tres boletos no tienen la misma fecha no se exede el limite
                if (date("d/m/Y", $Tarjeta->getHistorialBoletos(0)->getFecha_Hora()) != date("d/m/Y", $Tarjeta->getHistorialBoletos(1)->getFecha_Hora())) {
                    return false;
                }
            } else {
                return false; // No se excede el límite si no hay historial de boletos
            }
        } else if (get_class($Tarjeta) == "TrabajoSube\BoletoGratuitoJubilado") {
            return false; // No se excede el límite para tarjetas de boleto gratuito para jubilados
        }

        return true; // Por defecto, se asume que se excede el límite si no se cumple ninguna condición específica
    }
    
    public function pagarCon($Tarjeta, $Tiempo = null)
    {
        // Si no se proporciona un tiempo, se toma el tiempo actual
        if ($Tiempo === null) {
            $Tiempo = time();
        }

        // Verifica si hay saldo suficiente en la tarjeta para pagar el pasaje
        if ($Tarjeta->getSaldo() - $this->precio >= $Tarjeta->getSaldoMinimo()) {

            if (
                get_class($Tarjeta) == "TrabajoSube\MedioBoleto"
                && $Tarjeta->getHistorialBoletos(0) != false
                && ($Tiempo - $Tarjeta->getHistorialBoletos(0)->getFecha_Hora()) < 300
            ) {
                return false; // No se puede pagar si el último viaje fue muy reciente
            } else {
                // Descuenta el saldo de la tarjeta y retorna el saldo actual
                return $Tarjeta->descontarSaldo($this->limiteExcedido($Tarjeta, $Tiempo), $this, $Tiempo);
            }
        }

        return false; // Retorna false si no hay saldo suficiente para pagar el pasaje
    }

}

?>