<?php
namespace tests;

use PHPUnit_Extensions_Selenium2TestCase;

class UsuarioPage
{
    private $page;

    public function __construct(PHPUnit_Extensions_Selenium2TestCase $page)
    {
        $this->page = $page;
    }
    
    public function novo()
    {
        $this->page->url("/usuarios/new");
    }
    
    
    public function populaNovoForm($nome, $email)
    {
        $campoNome = $this->page->byName('usuario.nome');
        $campoNome->value($nome);

        $campoEmail = $this->page->byName('usuario.email');
        $campoEmail->value($email);
    }

    public function enviaForm()
    {
        $this->page->byId('btnSalvar')->click();
    }
    
    public function acessa()
    {
        $this->page->url("/usuarios/new");
    }
}
