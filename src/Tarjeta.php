<?php
namespace TrabajoSube;

class Tarjeta
{
    protected $id;
    public $nombre;
    private $saldo;
    public $recarga;

    function nuevaTarjeta($id, $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->saldo = 0;

        return "Nueva tarjeta creada. ID: " + $this->id + "Titular: " + $this->nombre;
    }

    function pagarBoleto($id, $precio)
    {
        $this->saldo = $this->saldo - $precio;

        return "Boleto Pagado. Nuevo saldo: " + $this->saldo;
    }

    function recargarSaldo($id, $recarga)
    {
        $this->saldo = $this->saldo + $recarga;

        return "Recarga completa. Nuevo saldo: " + $this->saldo;
    }

}

?>