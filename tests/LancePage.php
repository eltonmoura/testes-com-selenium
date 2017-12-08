<?php
namespace tests;

use PHPUnit_Extensions_Selenium2TestCase;

class LancePage
{
    private $page;
    private $rota;
    
    public function __construct(PHPUnit_Extensions_Selenium2TestCase $page)
    {
        $this->page = $page;
    }
 
    public function novo()
    {
        $this->rota = "/leiloes/new";
    }
    
    public function populaNovoForm($descricao, $valorInicial, $usuario = null, $usado = false)
    {
        $campoNome = $this->page->byName('leilao.nome');
        $campoNome->value($descricao);
        
        $campoValorInicial = $this->page->byName('leilao.valorInicial');
        $campoValorInicial->value($valorInicial);
        
        $select = $this->page->select(
            $this->page->byName('leilao.usuario.id')
        );
        
        $select->clearSelectedOptions($usuario);
        
        if ($usado) {
            $ckUsado = $this->page->byName('leilao.usado');
            $ckUsado->click();
        }
    }
    
    public function enviaForm()
    {
        $this->page->byTag('button')->click();
    }
    
    public function acessa()
    {
        $this->page->url($this->rota);
    }
}
