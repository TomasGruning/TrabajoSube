<?php
namespace TrabajoSube;

class Tarjeta
{
    private $id;
    public $saldo;
    public $descuento = 0;
    protected $saldoMinimo = -211.84;
    protected $saldoMaximo = 6600;
    protected $recargasPosibles = [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000];
    protected $historialBoletos = [];
    protected $cargaPendiente = 0;

    public function __construct($id, $saldo = 0)
    {
        $this->id = $id;
        $this->saldo = $saldo;
    }

    public function getSaldoMinimo()
    {
        return $this->saldoMinimo;
    }
    public function getCargaPendiente()
    {
        return $this->cargaPendiente;
    }
    public function getHistorialBoletos($pos = 0)
    {
        if(isset($this->historialBoletos[$pos])){return $this->historialBoletos[$pos];}
        else{return false;}
    }

    public function recargarSaldo($recarga)
    {
        if (($this->saldo + $recarga) > $this->saldoMaximo) {
            $this->cargaPendiente = ($this->saldo + $recarga) - $this->saldoMaximo;
            $this->saldo = $this->saldoMaximo;

            return $this->saldo;
        } else if ($this->cargaPendiente == 0) {
            for ($i = 0; $i < 23; $i++) {
                if ($recarga == $this->recargasPosibles[$i]) {
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

    public function descontarSaldo($Colectivo)
    {
        $this->recargarSaldo($this->cargaPendiente);

        $boleto = new Boleto(uniqid(), time(), $Colectivo, $this);
        array_unshift($this->historialBoletos, $boleto);

        return $this->saldo;
    }

}

?>