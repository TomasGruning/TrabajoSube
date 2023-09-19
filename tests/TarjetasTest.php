<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class TarjetasTest extends TestCase
{
    public function testFranquiciaCompleta()
    {
        $cole = new Colectivo(103);

        $tarjeta = new FranquiciaCompleta(uniqid(), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), 300);

        for ($x = 0; $x < 10; $x++) {
            $cole->pagarCon($tarjeta);
        }
        $this->assertEquals($cole->pagarCon($tarjeta), 300);
    }

    public function testFranquiciaParcial()
    {
        $cole = new Colectivo(103);
        $tarjeta = new FranquiciaParcial(uniqid(), 300);

        $this->assertEquals($cole->pagarCon($tarjeta), 240);
        $this->assertEquals($cole->pagarCon($tarjeta), 180);
    }

    public function testSaldoMaximo(){
        $cole = new Colectivo(103);
        $tarjeta = new Tarjeta(uniqid(), 6500);

        $this->assertEquals($tarjeta->recargarSaldo(200), 6600);
        $this->assertEquals($tarjeta->cargaPendiente, 100);
        $this->assertEquals($cole->pagarCon($tarjeta), 6580);
        $this->assertEquals($tarjeta->cargaPendiente, 80);
    }
}

?>