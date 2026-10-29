<?php

/*
 * PADRÃO DE PROJETO ESTRUTURAL: COMPOSITE
 *
 * Esse padrão é usado para fazer um grupo se comportar como se fosse uma coisa só. Só faz sentido quando os dados
 * formam uma árvore (coisas dentro de coisas do mesmo tipo), como kit dentro de kit.
 *
 * Esse padrão poderia ser aplicado na tela do siscom onde mostra as contas orçamentarias pq lá temos a conta pai e as
 * contas filhas que daria pra ser acessada recursivamente que é a proposta desse padrão
 */

// a interface comum entre item simples e grupo
interface ItemInterface
{
    public function preco(): float;
}

// item simples, sem filhos
final class Produto implements ItemInterface
{
    public function __construct(private float $preco) {}

    public function preco(): float
    {
        return $this->preco;
    }
}

// Composite: item que contém outros itens (produtos ou outros kits)
final class Kit implements ItemInterface
{
    private array $itens = [];

    // Só vamos adicionar no kit um objeto que implementa o ItemInterface
    public function adicionar(ItemInterface $item): void
    {
        $this->itens[] = $item;
    }

    // Esse método é recursivo, ele soma tanto o valor de um produto quanto do kit de forma recursiva entrando nas camadas
    // do objeto
    public function preco(): float
    {
        $total = 0;
        foreach ($this->itens as $item) {
            $total += $item->preco(); // produto ou kit, tanto faz
        }
        return $total;
    }
}


// Código cliente

// Produtos avulsos (folhas)
$caneta  = new Produto(2.50);
$caderno = new Produto(15.00);
$lapis   = new Produto(1.00);
$borracha = new Produto(0.50);

// Um kit simples
$kitEscrita = new Kit();
$kitEscrita->adicionar($lapis);
$kitEscrita->adicionar($borracha);

// Um kit que contém produtos E outro kit
$kitEscritorio = new Kit();
$kitEscritorio->adicionar($caneta);
$kitEscritorio->adicionar($caderno);
$kitEscritorio->adicionar($kitEscrita); // kit dentro de kit

// Aqui foi criado um novo kit que inclui um novo produto notebook mais o $kitescritorio
$notebook = new Produto(7000);
$kitEscritorioProxMax = new Kit();
$kitEscritorioProxMax->adicionar($notebook);
$kitEscritorioProxMax->adicionar($kitEscritorio);

// Tudo é ItemInterface, então todos respondem preco() do mesmo jeito
echo "Caneta: R$"         . $caneta->preco()        . "\n"; // 2.5
echo "Kit Escrita: R$"    . $kitEscrita->preco()    . "\n"; // 1.5
echo "Kit Escritório: R$" . $kitEscritorio->preco() . "\n"; // 19
echo "Kit Escritório ProMax: R$" . $kitEscritorioProxMax->preco() . "\n"; // 7019 (7000 do notebook + 19 do kit escritório)