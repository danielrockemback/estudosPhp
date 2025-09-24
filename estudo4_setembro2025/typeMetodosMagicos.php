<?php

//
class Mercadoria
{
    private $idMercadoria;
    private $nomeMercadoria;
    private $valor;
    public function __construct(int $idMercadoria, string $nomeMercadoria, float $valor)
    {
        $this->idMercadoria = $idMercadoria;
        $this->nomeMercadoria = $nomeMercadoria;
        $this->valor = $valor;
    }

    /**
     * @return int
     */
    public function getIdMercadoria(): int
    {
        return $this->idMercadoria;
    }

    /**
     * @param int $idMercadoria
     */
    public function setIdMercadoria(int $idMercadoria): void
    {
        $this->idMercadoria = $idMercadoria;
    }

    /**
     * @return string
     */
    public function getNomeMercadoria(): string
    {
        return $this->nomeMercadoria;
    }

    /**
     * @param string $nomeMercadoria
     */
    public function setNomeMercadoria(string $nomeMercadoria): void
    {
        $this->nomeMercadoria = $nomeMercadoria;
    }

    /**
     * @return float
     */
    public function getValor(): float
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     */
    public function setValor(float $valor): void
    {
        $this->valor = $valor;
    }
}


class CarrinhoItem implements IteratorAggregate {

    private $itensCarrinho = [];

    public function adicionarItem(Mercadoria $objMercadoria)
    {
        $this->itensCarrinho[] = $objMercadoria;
        return $this;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->itensCarrinho);
    }

    /**
     * @return array
     */
    public function getItensCarrinho(): array
    {
        return $this->itensCarrinho;
    }

}

$listaMercadoria = [];

$objMercadoria = new Mercadoria(198, 'Cimento 50 KG', 29.99);
$objMercadoria2 = new Mercadoria(32, 'Arame 10 KG', 16.57);

$listaMercadoria[] = $objMercadoria;
$listaMercadoria[] = $objMercadoria2;

$objCarrinhoItem = new CarrinhoItem();

/** @var Mercadoria $produto */
foreach ($listaMercadoria as $produto) {
    $objCarrinhoItem->adicionarItem($produto);
}

// Como implementamos o IteratorAggregate, nós podemos chamar assim para fazer o looping
foreach ($objCarrinhoItem as $produto) {
    echo "{$produto->getNomeMercadoria()} : R$ {$produto->getValor()}\n";
}