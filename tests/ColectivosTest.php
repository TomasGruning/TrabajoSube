<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivosTest extends TestCase
{
    public function testGetlinea()
    {
        $cole = new Colectivo(103);
        $this->assertEquals($cole->getLinea(), 103);
    }

    public function testPagarCon()
    {
        $cole = new Colectivo(103);

        $tarjeta = new Tarjeta(uniqid(), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), 180);

        $tarjeta = new Tarjeta(uniqid(), -300);
        $this->assertEquals($cole->pagarCon($tarjeta), false);
    }

    public function testColectivoInterurbano()
    {
        $cole = new ColectivoInterurbano(112);

        $tarjeta = new Tarjeta(uniqid(), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), 116);

        $tarjeta = new MedioBoleto(uniqid(), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), 208);
    }
}

?>