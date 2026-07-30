<?php

/**
 * Iterator é um padrão comportamental usado para percorrer os elementos de uma coleção
 * (lista, array, árvore, etc) sem expor como essa coleção é organizada por dentro.
 *
 * Quem usa o Iterator não precisa saber se a coleção é um array, uma lista encadeada, ou
 * qualquer outra estrutura interna. Ele só sabe pedir "próximo elemento" e "ainda tem mais?",
 * sempre da mesma forma, não importa qual coleção está sendo percorrida.
 * 
 * Uma das grandes vantagens é controlar o fluxo das iterações e você decidir se quer fazer algo
 * dentro dos métodos
 */

/** É IMPORTANTE NÃO ALTERAR OS NOMES DOS MÉTODOS, SE NÃO O PHP VAI DISPARAR UM ERRO
 
 * 
 * A interface nativa Iterator do PHP exige 5 métodos
 * current() -> retorna o elemento atual
 * key() -> retorna a chave do elemento atual
 * next() -> avança para o próximo elemento
 * rewind() -> volta o ponteiro pro início (chamado no começo do foreach)
 * valid() -> diz se a posição atual ainda é válida (se ainda tem elemento pra ler)
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
        echo "[DEBUG] current() chamado, posição atual: {$this->posicao}" . PHP_EOL;
        return $this->funcionarios[$this->posicao];
    }

    // Retorna a chave (índice) da posição atual
    public function key(): int
    {
        echo "[DEBUG] key() chamado, retornando: {$this->posicao}" . PHP_EOL;
        return $this->posicao;
    }

    // Avança o ponteiro pra próxima posição
    public function next(): void
    {
        echo "[DEBUG] next() chamado, avançando de {$this->posicao} para " . ($this->posicao + 1) . PHP_EOL;
        $this->posicao++;
    }

    // Reinicia o ponteiro pro começo, isso é chamado automaticamente no início de um foreach
    public function rewind(): void
    {
        echo "[DEBUG] rewind() chamado, voltando ponteiro pro início" . PHP_EOL;
        $this->posicao = 0;
    }

    // Verifica se a posição atual ainda existe dentro do array
    // Enquanto isso retornar true, o foreach continua rodando
    public function valid(): bool
    {
        $resultado = isset($this->funcionarios[$this->posicao]);
        echo "[DEBUG] valid() chamado, posição {$this->posicao} é válida? " . ($resultado ? 'sim' : 'não') . PHP_EOL;
        return $resultado;
    }
}

// Montagem: criamos a coleção e adicionamos alguns funcionários
$funcionarios = new ColecaoFuncionarios();
$funcionarios->adicionar('Daniel');
$funcionarios->adicionar('Maria');
$funcionarios->adicionar('João');

echo "=== Iniciando foreach em ColecaoFuncionarios ===" . PHP_EOL;

// Como a classe implementa a interface Iterator, o PHP sabe automaticamente
// como percorrer ela dentro de um foreach, chamando rewind(), valid(), current(),
// key() e next() por trás dos panos sem a gente precisar chamar isso manualmente
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
        echo "[DEBUG] current() chamado, posição atual: {$this->posicao}" . PHP_EOL;
        return $this->produtos[$this->posicao];
    }

    public function key(): int
    {
        echo "[DEBUG] key() chamado, retornando: {$this->posicao}" . PHP_EOL;
        return $this->posicao;
    }

    public function next(): void
    {
        echo "[DEBUG] next() chamado, avançando de {$this->posicao} para " . ($this->posicao + 1) . PHP_EOL;
        $this->posicao++;
    }

    public function rewind(): void
    {
        echo "[DEBUG] rewind() chamado, voltando ponteiro pro início" . PHP_EOL;
        $this->posicao = 0;
    }

    public function valid(): bool
    {
        $resultado = isset($this->produtos[$this->posicao]);
        echo "[DEBUG] valid() chamado, posição {$this->posicao} é válida? " . ($resultado ? 'sim' : 'não') . PHP_EOL;
        return $resultado;
    }
}

$produtos = new ColecaoProdutos();
$produtos->adicionar('Teclado', 150.00);
$produtos->adicionar('Mouse', 80.00);

echo "=== Iniciando foreach em ColecaoProdutos ===" . PHP_EOL;

foreach ($produtos as $produto) {
    echo "Produto: {$produto['nome']} - R$ {$produto['preco']}" . PHP_EOL;
}

