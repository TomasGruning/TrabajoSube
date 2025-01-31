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

    public function testSaldoMaximo()
    {
        $cole = new Colectivo(103);
        $tarjeta = new Tarjeta(uniqid(), 6500);

        $this->assertEquals($tarjeta->recargarSaldo(300), 6600);
        $this->assertEquals($tarjeta->getCargaPendiente(), 200);
        $this->assertEquals($cole->pagarCon($tarjeta), 6600);
        $this->assertEquals($tarjeta->getCargaPendiente(), 80);
    }

    public function testMedioBoletoLimitacionTiempo()
    {
        $cole = new Colectivo(103);

        // Caso verdadero
        $tarjeta = new MedioBoleto(uniqid(), 300);
        $cole->pagarCon($tarjeta);
        $this->assertEquals($cole->pagarCon($tarjeta, time() + 300), 180);

        // Caso falso
        $cole->pagarCon($tarjeta);
        $this->assertEquals($cole->pagarCon($tarjeta, time() + 60), false);

    }

    public function testMedioBoletoLimitacionDia()
    {
        $cole = new Colectivo(103);

        // Caso verdadero
        $tarjeta = new MedioBoleto(uniqid(), 300);
        for ($i = 0; $i < 2; $i++) {
            $cole->pagarCon($tarjeta, time() + $i * 300);
        }

        $this->assertEquals($cole->pagarCon($tarjeta, time() + 600), 120);

        // Caso falso
        $tarjeta = new MedioBoleto(uniqid(), 1000);
        for ($i = 0; $i < 4; $i++) {
            $cole->pagarCon($tarjeta, time() + ($i) * 300);
        }

        $this->assertEquals($cole->pagarCon($tarjeta, time() + 1200), 640);

    }

    public function testBoletoGratuitoLimitacionDia()
    {
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

    public function testFranquiciaLimitacionFranjaHoraria()
    {
        $cole = new Colectivo(103);

        // Caso verdadero
        $tarjeta = new MedioBoleto(uniqid(), 300);
        
        $tiempo = strtotime("2023-09-25 10:00:00"); 
        $this->assertEquals($cole->pagarCon($tarjeta, $tiempo), 240);

        // Casos falsos
        $tarjeta = new MedioBoleto(uniqid(), 300);

        $tiempo = strtotime("2023-09-25 23:00:00"); 
        $this->assertEquals($cole->pagarCon($tarjeta, $tiempo), 180);
        $tiempo = strtotime("2023-09-30 10:00:00"); 
        $this->assertEquals($cole->pagarCon($tarjeta, $tiempo), 60);

    }

    public function testUsoFrecuente()
    {
        $cole = new Colectivo(103);
        
        // Caso Normal
        $tarjeta = new Tarjeta(uniqid(), 6600);
        for ($i = 0; $i < 19; $i++) {
            $cole->pagarCon($tarjeta, time() + $i);
        }

        $this->assertEquals($cole->pagarCon($tarjeta, time() + 20), 4200);

        // Caso 20%
        $tarjeta = new Tarjeta(uniqid(), 6600);

        for ($i = 0; $i < 29; $i++) {
            $cole->pagarCon($tarjeta, time() + $i);
        }
        $this->assertEquals($cole->pagarCon($tarjeta, time() + 30), 3024);

        // Caso 25%
        $tarjeta = new Tarjeta(uniqid(), 6600);

        for ($i = 0; $i < 89; $i++) {
            $cole->pagarCon($tarjeta, time() + $i);
            $tarjeta->recargarSaldo(6600-$tarjeta->getSaldo());
            $this->assertEquals($tarjeta->getSaldo(), 6600);
        }
        $this->assertEquals($cole->pagarCon($tarjeta, time() + 90), 6510);

    }
}

?>