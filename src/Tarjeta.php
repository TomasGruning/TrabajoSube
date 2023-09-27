<?php
namespace TrabajoSube;

class Tarjeta
{
    private $id;
    protected $saldo;
    protected $cargaPendiente = 0;
    protected $historialBoletos = [];
    protected $descuentoPorcentaje = 0;
    const saldoMinimo = -211.84;
    const saldoMaximo = 6600;
    const recargasPosibles = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];

    public function __construct($id, $saldo = 0)
    {
        $this->id = $id;
        $this->saldo = $saldo;
    }

    public function getSaldo()
    {
        return $this->saldo;
    }
    public function getdescuentoPorcentaje()
    {
        return $this->descuentoPorcentaje;
    }
    public function getCargaPendiente()
    {
        return $this->cargaPendiente;
    }
    public function getHistorialBoletos($pos = 0)
    {
        if (isset($this->historialBoletos[$pos])) {
            return $this->historialBoletos[$pos];
        } else {
            return false;
        }
    }
    public function getSaldoMinimo()
    {
        return self::saldoMinimo;
    }

    public function recargarSaldo($recarga)
    {
        if (($this->saldo + $recarga) > self::saldoMaximo) {
            $this->cargaPendiente = ($this->saldo + $recarga) - self::saldoMaximo;
            $this->saldo = self::saldoMaximo;

            return $this->saldo;
        } else if ($this->cargaPendiente == 0) {
            for ($i = 0; $i < 23; $i++) {
                if ($recarga == self::recargasPosibles[$i]) {
                    $this->saldo = $this->saldo + $recarga;
                    return $this->saldo;
                }
            }
            return false;
        } else {
            $this->saldo = $this->saldo + $this->cargaPendiente;
            $this->cargaPendiente = 0;
            return $this->saldo;
        }

    }

    public function descontarSaldo($Excepcion, $Colectivo, $Tiempo)
    {
        $boleto = new Boleto(uniqid(), $Tiempo, $Colectivo, $this);
        array_unshift($this->historialBoletos, $boleto);

        if ($Excepcion) {
            $this->saldo = $this->saldo - $Colectivo->getPrecio();
        } else {
            $this->saldo = $this->saldo - $Colectivo->getPrecio() + $Colectivo->getPrecio() * ($this->descuentoPorcentaje / 100);
        }

        $this->recargarSaldo($this->cargaPendiente);
        return $this->saldo;
    }

}

?>