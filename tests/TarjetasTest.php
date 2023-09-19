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
}

?>