<?php
namespace tests;

use PHPUnit_Extensions_Selenium2TestCase;

class LanceViewTest extends PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * @before
     */
    protected function setUp()
    {
        $this->setBrowserUrl('http://localhost:8080');
    }
    
    public function testNaoDeveDarLanceSemUsuario()
    {
        $leilaoPage = new LeilaoPage($this);
        $leilaoPage->novo();
        
        $descricao = 'Um produto';
        $valorInicial = 15.50;
        
        $leilaoPage->acessa();
        $leilaoPage->populaNovoForm($descricao, $valorInicial);
        $leilaoPage->enviaForm();
        
        $this->byLinkText('exibir')->click();
        
        $this->byId('btnDarLance')->click();
      
        $this->assertTrue(true);
    }
    
    public function testDeveDarLanceComUsuario()
    {
        $novoUsuarioPage = new UsuarioPage($this);
        $novoUsuarioPage->novo();
        
        $nome = 'Um Usuário';
        $email = 'usuario@email.com.br';
        
        $novoUsuarioPage->acessa();
        $novoUsuarioPage->populaNovoForm($nome, $email);
        $novoUsuarioPage->enviaForm();
  
        $leilaoPage = new LeilaoPage($this);
        $leilaoPage->novo();
        
        $descricao = 'Um produto';
        $valorInicial = 15.50;
        
        $leilaoPage->acessa();
        $leilaoPage->populaNovoForm($descricao, $valorInicial);
        $leilaoPage->enviaForm();
               
        // Leilao
        $this->byLinkText('exibir')->click();
        $campoValorLance = $this->byName('lance.valor');
        $campoValorLance->value(999);
        
        $this->byId('btnDarLance')->click();
        $pagina = $this;
        $this->waitUntil(function ($pagina) {
                return $pagina->byId('lancesDados');
        }, 3000);
        
        $source = $this->source();
        $lancesCriados = (strpos($source, $nome) > 0);
        
        $this->assertTrue($lancesCriados);
    }
    
    public function tearDown()
    {
        $this->url('/apenas-teste/limpa');
    }
}
