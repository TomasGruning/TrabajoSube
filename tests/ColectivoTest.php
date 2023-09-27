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
        $tarjeta = new MedioBoleto(uniqid(), 300);
        $cole->pagarCon($tarjeta);
        $this->assertEquals($cole->pagarCon($tarjeta, time()+300), 180);

        //Caso falso
        $cole->pagarCon($tarjeta);
        $this->assertEquals($cole->pagarCon($tarjeta, time()+60), false);

    }

    public function testParcialLimitacionDia()
    {
        $cole = new Colectivo(103);

        //Caso verdadero
        $tarjeta = new MedioBoleto(uniqid(), 300);
        for ($i = 0; $i < 2; $i++) {
            $cole->pagarCon($tarjeta, time() + $i * 300);
        }

        $this->assertEquals($cole->pagarCon($tarjeta, time() + 600), 120);

        //Caso falso
        $tarjeta = new MedioBoleto(uniqid(), 1000);
        for ($i = 0; $i < 4; $i++) {
            $cole->pagarCon($tarjeta, time() + ($i) * 300);
        }

        $this->assertEquals($cole->pagarCon($tarjeta, time() + 1200), 640);

    }

    public function testCompletaLimitacionDia(){
        $cole = new Colectivo(103);

        $tarjeta = new BoletoGratuito(uniqid(), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), 180);

        $tarjeta = new BoletoGratuitoJubilado(uniqid(), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), 300);    
    }
}

?>