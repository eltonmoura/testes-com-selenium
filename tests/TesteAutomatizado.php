<?php
namespace tests;

use PHPUnit_Extensions_Selenium2TestCase;

class TesteAutomatizado extends PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * @before
     */
    protected function setUp()
    {
        $this->setBrowserUrl('https://www.google.com.br');
    }
    
    public function testTitle()
    {
         $this->url("/");
         $campoDeTexto = $this->byName('q');
         $campoDeTexto->value('Caelum');
         $campoDeTexto->submit();
         sleep(1);
    }
}
