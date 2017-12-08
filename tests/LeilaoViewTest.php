<?php
namespace tests;

use PHPUnit_Extensions_Selenium2TestCase;

class LeilaoViewTest extends PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * @before
     */
    protected function setUp()
    {
        $this->setBrowserUrl('http://localhost:8080');
    }

    public function testDeveCriarNovoLeilaoSemNomeESemValor()
    {
        $leilaoPage = new LeilaoPage($this);
        $leilaoPage->novo();
        
        $descricao = '';
        $valorInicial = null;
        
        $leilaoPage->acessa();
        $leilaoPage->populaNovoForm($descricao, $valorInicial);
        $leilaoPage->enviaForm();
        
        $source = $this->source();
        
        $existeTexto = (strpos($source, 'Nome obrigatorio!') > 0);        
        $this->assertTrue($existeTexto);
        
        $existeTexto = (strpos($source, 'Valor inicial deve ser maior que zero!') > 0);
        $this->assertTrue($existeTexto);
    }
   
    public function testDeveCriarNovoLeilaoValorMaiorQueZero()
    {
        $leilaoPage = new LeilaoPage($this);
        $leilaoPage->novo();
        
        $descricao = 'Um Produto';
        $valorInicial = -1;
        
        $leilaoPage->acessa();
        $leilaoPage->populaNovoForm($descricao, $valorInicial);
        $leilaoPage->enviaForm();
        
        $source = $this->source();
        
        $existeTexto = (strpos($source, 'Valor inicial deve ser maior que zero!') > 0);
        $this->assertTrue($existeTexto);
    }
    public function testDeveCriarNovoLeilaoSemUsuario()
    {
        $leilaoPage = new LeilaoPage($this);
        $leilaoPage->novo();
       
        $descricao = 'Um produto';
        $valorInicial = 15.50;
        
        $leilaoPage->acessa();
        $leilaoPage->populaNovoForm($descricao, $valorInicial);
        $leilaoPage->enviaForm();
        
        $source = $this->source();
        $existeDescricao = (strpos($source, $descricao) > 0);

        $this->assertTrue($existeDescricao);
    }
    
    public function testDeveCriarNovoLeilaoComUsuario()
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
        $leilaoPage->populaNovoForm($descricao, $valorInicial, $nome);
        $leilaoPage->enviaForm();
        
        $source = $this->source();
        $existeDescricao = (strpos($source, $nome) > 0);
        
        $this->assertTrue($existeDescricao);
    }

    public function testDeveCriarComProdutoUsado()
    {
        $novoUsuarioPage = new UsuarioPage($this);
        $novoUsuarioPage->novo();
        
        $nome = 'Um Usuário';
        $email = 'usuario@email.com.br';
        $usado = true;
        
        $novoUsuarioPage->acessa();
        $novoUsuarioPage->populaNovoForm($nome, $email);
        $novoUsuarioPage->enviaForm();
        
        $leilaoPage = new LeilaoPage($this);
        $leilaoPage->novo();
        
        $descricao = 'Um produto';
        $valorInicial = 15.50;
        
        $leilaoPage->acessa();
        $leilaoPage->populaNovoForm($descricao, $valorInicial, $nome, $usado);
        $leilaoPage->enviaForm();
        
        $source = $this->source();
        $existeUsado = (strpos($source, 'Sim') > 0);

        $this->assertTrue($existeUsado);
    }

    public function tearDown()
    {
        $this->url('/apenas-teste/limpa');
    }
}
