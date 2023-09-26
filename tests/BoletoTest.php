<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase
{
    public function testGenerarBoleto()
    {
        $cole = new Colectivo(103);
        $tarjeta = new Tarjeta(uniqid(), 300);

        $cole->pagarCon($tarjeta);
        $this->assertEquals($tarjeta->getHistorialBoletos(0)->getTarjeta(), $tarjeta);
        $this->assertEquals($tarjeta->getHistorialBoletos(0)->Colectivo, $cole);

        $tarjeta = new MedioBoleto(uniqid(), 300);

        $cole->pagarCon($tarjeta);
        $this->assertEquals($tarjeta->getHistorialBoletos(0)->getTarjeta(), $tarjeta);
        $this->assertEquals($tarjeta->getHistorialBoletos(0)->Colectivo, $cole);

        $tarjeta = new BoletoGratuito(uniqid(), 300);

        $cole->pagarCon($tarjeta);
        $this->assertEquals($tarjeta->getHistorialBoletos(0)->getTarjeta(), $tarjeta);
        $this->assertEquals($tarjeta->getHistorialBoletos(0)->Colectivo, $cole);
    }
}

?>