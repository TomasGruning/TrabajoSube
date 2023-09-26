<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class TarjetasTest extends TestCase
{
    public function testBoletoGratuito()
    {
        $cole = new Colectivo(103);

        $tarjeta = new BoletoGratuito(uniqid(), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), 300);
    }

    public function testMedioBoleto()
    {
        $cole = new Colectivo(103);
        $tarjeta = new MedioBoleto(uniqid(), 300);

        $this->assertEquals($cole->pagarCon($tarjeta), 240);
    }

    public function testSaldoMaximo(){
        $cole = new Colectivo(103);
        $tarjeta = new Tarjeta(uniqid(), 6500);

        $this->assertEquals($tarjeta->recargarSaldo(300), 6600);
        $this->assertEquals($tarjeta->cargaPendiente, 200);
        $this->assertEquals($cole->pagarCon($tarjeta), 6600);
        $this->assertEquals($tarjeta->cargaPendiente, 80);
    }
}

?>