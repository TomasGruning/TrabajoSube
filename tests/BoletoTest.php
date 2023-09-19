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
        $this->assertEquals($tarjeta->historialBoletos[0]->Tarjeta, $tarjeta);
        $this->assertEquals($tarjeta->historialBoletos[0]->Colectivo, $cole);

        $tarjeta = new FranquiciaParcial(uniqid(), 300);

        $cole->pagarCon($tarjeta);
        $this->assertEquals($tarjeta->historialBoletos[0]->Tarjeta, $tarjeta);
        $this->assertEquals($tarjeta->historialBoletos[0]->Colectivo, $cole);

        $tarjeta = new FranquiciaCompleta(uniqid(), 300);

        $cole->pagarCon($tarjeta);
        $this->assertEquals($tarjeta->historialBoletos[0]->Tarjeta, $tarjeta);
        $this->assertEquals($tarjeta->historialBoletos[0]->Colectivo, $cole);
    }
}

?>