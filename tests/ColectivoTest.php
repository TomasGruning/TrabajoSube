<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase
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

        $tarjeta->saldo = -100;
        $this->assertEquals($cole->pagarCon($tarjeta), false);
    }

    public function testParcialLimitacionTiempo()
    {
        $cole = new Colectivo(103);

        //Caso verdadero
        $tarjeta = new FranquiciaParcial(uniqid(), 300);
        $cole->pagarCon($tarjeta);
        sleep(6);

        $this->assertEquals($cole->pagarCon($tarjeta), 180);

        //Caso falso
        $cole->pagarCon($tarjeta);
        sleep(3);

        $this->assertEquals($cole->pagarCon($tarjeta), false);

    }

    public function testParcialLimitacionDia()
    {
        $cole = new Colectivo(103);

        //Caso verdadero
        $tarjeta = new FranquiciaParcial(uniqid(), 300);
        for ($i = 0; $i < 2; $i++) {
            $cole->pagarCon($tarjeta);
            sleep(6);
        }

        $this->assertEquals($cole->pagarCon($tarjeta), 120);

        //Caso falso
        $tarjeta = new FranquiciaParcial(uniqid(), 1000);
        for ($i = 0; $i < 4; $i++) {
            $cole->pagarCon($tarjeta);
            sleep(6);
        }

        $this->assertEquals($cole->pagarCon($tarjeta), 640);

    }
}

?>