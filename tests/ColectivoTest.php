<?php

namespace TrabajoSube;

use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase
{
    public function testGetlinea(){
        $cole = new Colectivo(103);
        $this->assertEquals($cole->getLinea(), 103);
    }

    public function testPagarCon(){
        $cole = new Colectivo(103);
        
        $tarjeta = new Tarjeta(uniqid(), 300);
        $this->assertEquals($cole->pagarCon($tarjeta), "Boleto Pagado. Nuevo saldo: 180");

        $tarjeta->saldo = -100;
        $this->assertEquals($cole->pagarCon($tarjeta), false);
    }
}