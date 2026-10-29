<?php

/**
 * PADRÃO FLYWEIGHT (Estrutural)
 *
 * Objetivo: economizar memória RAM quando o sistema precisa criar uma grande quantidade de objetos semelhantes.
 *
 * Estado intrínseco: dados iguais entre muitos objetos. Fica dentro do flyweight, é compartilhado e precisa ser imutável.
 * Estado extrínseco: dados únicos de cada objeto. Fica fora, no contexto, e não é compartilhado.
 *
 * O padrão não reduz a quantidade de objetos de contexto (ItemVenda), e sim evita duplicar os dados compartilhados
 * (Produto). Cada ItemVenda guarda apenas uma referência ao produto do cache.
 *
 * Pouco usado em requests web, porque o PHP libera a memória ao fim de cada request. Faz mais sentido em scripts CLI,
 * importações em lote e workers de longa duração.
 */

// Cenário: um script CLI importa um CSV com 500 mil linhas de vendas.
// Cada linha repete os dados do produto (código, descrição, categoria, unidade), mas existem só uns 2 mil produtos diferentes.

readonly final class Produto // O Flyweight do produto
{
    public function __construct(
        public readonly string $codigo,
        public readonly string $descricao,
        public readonly string $categoria,
        public readonly string $unidade,
    ) {}
}


final class ProdutoFactory // A Factory que vai ser usada como Cache
{
    private array $cache = [];

    public function obter(string $codigo, string $descricao, string $categoria, string $unidade): Produto
    {
        return $this->cache[$codigo] ??= new Produto($codigo, $descricao, $categoria, $unidade);
    }

    public function total(): int
    {
        return count($this->cache);
    }
}


final class ItemVenda
{
    public function __construct(
        public readonly Produto $produto,   // referência compartilhada
        public readonly float $quantidade,
        public readonly float $preco,
        public readonly string $data,
    ) {}

    public function total(): float
    {
        return $this->quantidade * $this->preco;
    }
}

// Código cliente

$factory = new ProdutoFactory();
$itens = [];
$arquivo = fopen('vendas.csv', 'r');    // Arquivo hipotético

while (($linha = fgetcsv($arquivo, separator: ';')) !== false) {
    [$codigo, $descricao, $categoria, $unidade, $qtd, $preco, $data] = $linha;

    // Aqui vamos chamar o método obter da nossa factory e dentro dele, nós vamos verificar se o código não está definido
    // ou ele é nulo, se for algum dos casos, ele vai criar uma instância do Produto e retornar pra gente. Após fazer isso
    // Nós vamos adicionar ele em um array de itens que cada item vai ser uma instância do ItemVenda que recebe como
    // parâmetro o nosso objeto criado $produto e o restante dos atributos necessários para esse caso
    $produto = $factory->obter($codigo, $descricao, $categoria, $unidade);
    $itens[] = new ItemVenda($produto, (float) $qtd, (float) $preco, $data);
}

fclose($arquivo);

echo "Itens: " . count($itens) . "\n";           // 500.000
echo "Produtos em memória: " . $factory->total(); // 2.000
echo "\nMemória: " . round(memory_get_peak_usage() / 1024 / 1024) . " MB\n";

// O pulo do gato nesse padrão é o operador ??= que ao chamar o obter, ele verifica se o código já existe em cache e tem
// valor, se sim, então retorna esse produto que já está em cache, se não existe ou é um valor nulo, ele salva
// em cache e devolve a instancia do produto e ao invés de criar 500.000 produtos repetidos dentro da factory, nós só criamos apenas 2 mil produtos
// que são diferentes ao invés de ter repetido milhares de vezes sem necessidade e isso acaba economizando memória ram