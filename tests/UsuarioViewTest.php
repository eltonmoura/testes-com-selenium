<?php
namespace tests;

use PHPUnit_Extensions_Selenium2TestCase;

class UsuarioViewTest extends PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * @before
     */
    protected function setUp()
    {
        $this->setBrowserUrl('http://localhost:8080');
    }

    public function testDeveCriarNovoUsuario()
    {
        $novoUsuarioPage = new UsuarioPage($this);
        $novoUsuarioPage->novo();
       
        $nome = 'Satiro';
        $email = 'daniel@satiro.me';
        
        $novoUsuarioPage->acessa();
        $novoUsuarioPage->populaNovoForm($nome, $email);
        $novoUsuarioPage->enviaForm();
        
        $source = $this->source();
        $existeNome = (strpos($nome, $source) !== 0);
        $existeEmail = (strpos($email, $source) !== 0);
        
        $this->assertTrue($existeNome);
        $this->assertTrue($existeEmail);
    }
    
    public function testDeveCriarNovoUsuarioSemNome()
    {
        $novoUsuarioPage = new UsuarioPage($this);
        $novoUsuarioPage->novo();
        
        $nome = '';
        $email = 'daniel@satiro.me';
        
        $novoUsuarioPage->acessa();
        $novoUsuarioPage->populaNovoForm($nome, $email);
        $novoUsuarioPage->enviaForm();
        
        $mostraErro = (strpos('Nome obrigatorio!', $this->source()) !== 0);
        
        $this->assertTrue($mostraErro);
    }

    public function testDeveCriarNovoUsuarioSemEmail()
    {
        $novoUsuarioPage = new UsuarioPage($this);
        $novoUsuarioPage->novo();
        
        $nome = 'Satiro';
        $email = '';
        
        $novoUsuarioPage->acessa();
        $novoUsuarioPage->populaNovoForm($nome, $email);
        $novoUsuarioPage->enviaForm();
        
        $mostraErro = (strpos('E-mail obrigatorio!', $this->source()) !== 0);
 
        $this->assertTrue($mostraErro);
    }
 
    public function testDeveExibirInfo()
    {
        $novoUsuarioPage = new UsuarioPage($this);
        $novoUsuarioPage->novo();
        
        $nome = 'Um Usuário';
        $email = 'usuario@email.com.br';
        
        $novoUsuarioPage->acessa();
        $novoUsuarioPage->populaNovoForm($nome, $email);
        $novoUsuarioPage->enviaForm();
        
        $source = $this->source();
        
        
        $this->byLinkText('exibir')->click();
        
        $existeNome = (strpos($nome, $source) !== 0);
        $existeEmail = (strpos($email, $source) !== 0);
        
        $this->assertTrue($existeNome);
        $this->assertTrue($existeEmail);
    }

    public function testDeveEditar()
    {
        $novoUsuarioPage = new UsuarioPage($this);
        $novoUsuarioPage->novo();
        
        $nome = 'Um Usuário';
        $email = 'usuario@email.com.br';
        
        $novoUsuarioPage->acessa();
        $novoUsuarioPage->populaNovoForm($nome, $email);
        $novoUsuarioPage->enviaForm();
        
        $source = $this->source();
        
        $this->byLinkText('editar')->click();
        
        $novoUsuarioPage->populaNovoForm($nome.'Edited', $email.'Edited');
        $novoUsuarioPage->enviaForm();
        
        $existeNome = (strpos($nome.'Edited', $source) !== 0);
        $existeEmail = (strpos($email.'Edited', $source) !== 0);
        
        $this->assertTrue($existeNome);
        $this->assertTrue($existeEmail);
    }

    public function testDeveExcluirQuandoConfirmado()
    {
        $novoUsuarioPage = new UsuarioPage($this);
        $novoUsuarioPage->novo();
        
        $nome = 'Um Usuário';
        $email = 'usuario@email.com.br';
        
        $novoUsuarioPage->acessa();
        $novoUsuarioPage->populaNovoForm($nome, $email);
        $novoUsuarioPage->enviaForm();
                
        $this->byTag('button')->click();
        $this->acceptAlert();

        $source = $this->source();
        
        $naoExisteNome = (strpos($source, $nome) === false);
        $naoExisteEmail = (strpos($source, $email) === false);
        
        $this->assertTrue($naoExisteNome);
        $this->assertTrue($naoExisteEmail);
    }
    
    public function testNaoDeveExcluirQuandoNaoConfirmado()
    {
        $novoUsuarioPage = new UsuarioPage($this);
        $novoUsuarioPage->novo();
        
        $nome = 'Um Usuário';
        $email = 'usuario@email.com.br';
        
        $novoUsuarioPage->acessa();
        $novoUsuarioPage->populaNovoForm($nome, $email);
        $novoUsuarioPage->enviaForm();
        
        $this->byTag('button')->click();
        $this->dismissAlert();
        
        $source = $this->source();
        
        $existeNome = (strpos($source, $nome) > 0);
        $existeEmail = (strpos($source, $email) > 0);
        
        $this->assertTrue($existeNome);
        $this->assertTrue($existeEmail);
    }

    public function tearDown()
    {
        $this->url('/apenas-teste/limpa');
    }
}
