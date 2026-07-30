<?php

/**
 * Iterator é um padrão comportamental usado para percorrer os elementos de uma coleção
 * (lista, array, árvore, etc) sem expor como essa coleção é organizada por dentro.
 *
 * Quem usa o Iterator não precisa saber se a coleção é um array, uma lista encadeada, ou
 * qualquer outra estrutura interna. Ele só sabe pedir "próximo elemento" e "ainda tem mais?",
 * sempre da mesma forma, não importa qual coleção está sendo percorrida.
 *
 * O PHP já tem uma interface nativa pra isso chamada Iterator, que faz parte do SPL
 * (Standard PHP Library). Ao implementar essa interface, sua classe pode ser usada
 * diretamente dentro de um foreach, como se fosse um array comum.
 */

/**
 * A interface nativa Iterator do PHP exige 5 métodos:
 * current()  -> retorna o elemento atual
 * key()      -> retorna a chave do elemento atual
 * next()     -> avança para o próximo elemento
 * rewind()   -> volta o ponteiro pro início (chamado no começo do foreach)
 * valid()    -> diz se a posição atual ainda é válida (se ainda tem elemento pra ler)
 */
class ColecaoFuncionarios implements Iterator
{
    // Array interno que guarda os funcionários de verdade, escondido de quem usa a classe
    private array $funcionarios = [];

    // Ponteiro que guarda em qual posição do array estamos no momento
    private int $posicao = 0;

    // Adiciona um funcionário na coleção interna
    public function adicionar(string $nome): void
    {
        $this->funcionarios[] = $nome;
    }

    // Retorna o elemento que está na posição atual do ponteiro
    public function current(): string
    {
        return $this->funcionarios[$this->posicao];
    }

    // Retorna a chave (índice) da posição atual
    public function key(): int
    {
        return $this->posicao;
    }

    // Avança o ponteiro pra próxima posição
    public function next(): void
    {
        $this->posicao++;
    }

    // Reinicia o ponteiro pro começo, isso é chamado automaticamente no início de um foreach
    public function rewind(): void
    {
        $this->posicao = 0;
    }

    // Verifica se a posição atual ainda existe dentro do array
    // Enquanto isso retornar true, o foreach continua rodando
    public function valid(): bool
    {
        return isset($this->funcionarios[$this->posicao]);
    }
}

// Montagem: criamos a coleção e adicionamos alguns funcionários
$funcionarios = new ColecaoFuncionarios();
$funcionarios->adicionar('Daniel');
$funcionarios->adicionar('Maria');
$funcionarios->adicionar('João');

// Como a classe implementa a interface Iterator, o PHP sabe automaticamente
// como percorrer ela dentro de um foreach, chamando rewind(), valid(), current(),
// key() e next() por trás dos panos, sem a gente precisar chamar isso na mão
foreach ($funcionarios as $indice => $nome) {
    echo "Funcionário {$indice}: {$nome}" . PHP_EOL;
}

echo PHP_EOL;

/**
 * Uma segunda coleção, só pra mostrar que o foreach funciona igual em qualquer
 * classe que implemente Iterator, não importa o que tem dentro dela
 */
class ColecaoProdutos implements Iterator
{
    private array $produtos = [];
    private int $posicao = 0;

    public function adicionar(string $nome, float $preco): void
    {
        // Guardamos como um array associativo dentro da coleção
        $this->produtos[] = ['nome' => $nome, 'preco' => $preco];
    }

    public function current(): array
    {
        return $this->produtos[$this->posicao];
    }

    public function key(): int
    {
        return $this->posicao;
    }

    public function next(): void
    {
        $this->posicao++;
    }

    public function rewind(): void
    {
        $this->posicao = 0;
    }

    public function valid(): bool
    {
        return isset($this->produtos[$this->posicao]);
    }
}

$produtos = new ColecaoProdutos();
$produtos->adicionar('Teclado', 150.00);
$produtos->adicionar('Mouse', 80.00);

foreach ($produtos as $produto) {
    echo "Produto: {$produto['nome']} - R$ {$produto['preco']}" . PHP_EOL;
}
