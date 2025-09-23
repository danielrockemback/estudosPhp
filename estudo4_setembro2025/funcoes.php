<?php
// Passo 6 - Funções: Declarações e Definições, Parts, Escopo, Referência, Closures
const ID_GRUPO_COMPRADOR_MATERIAL_BASICO = [16, 64, 89];

// 1 - Declaração e definição de uma função

/**
 * Verifica se no carrinho existe alguma mercadoria que é classificada com material básico.
 *
 * @param array $listaProdutos <- parâmetro que a função espera tem que ser do tipo array
 * @return bool|void <- O returno pode um booleano ou retornar um vázio.
 */
function hasMaterialBasicoCarrinho(array $listaProdutos = []) // Parâmetros podem receber valores padrão
    {
        // 3 - Dentro da função é chamado de Escopo Local e as variaveis aqui de dentro só podem ser usada aqui dentro da função

        if (!$listaProdutos) {
            return false;
        }

        foreach ($listaProdutos as $produto) {
            // A constante ID_GRUPO_COMPRADOR_MATERIAL_BASICO tem o escopo global, podendo ser em qualquer parte do projeto
            if (in_array($produto['idMercadoriaGrupoComprador'],  ID_GRUPO_COMPRADOR_MATERIAL_BASICO)) {
                return true;
            }
        }
    }


$carrinhoCompra = [
    ['idProduto' => 43, 'quantidade' => 10, 'precoProduto' => 100, 'idMercadoriaGrupoComprador' => 102],
    ['idProduto' => 12, 'quantidade' => 12, 'precoProduto' => 20, 'idMercadoriaGrupoComprador' => 50],
    ['idProduto' => 86, 'quantidade' => 1, 'precoProduto' => 1, 'idMercadoriaGrupoComprador' => 16],
    ['idProduto' => 1335, 'quantidade' => 50, 'precoProduto' => 0.5, 'idMercadoriaGrupoComprador' => 25],
];

// 2 - Chamada da função
$hasMaterialBasicoCarrinho = hasMaterialBasicoCarrinho($carrinhoCompra);

if ($hasMaterialBasicoCarrinho) {
    echo 'Esse pedido contém material básico e só pode ser retirado nos depósitos.' . PHP_EOL;
} else {
    echo 'Esse pedido só pode ser retirado nas lojas.' . PHP_EOL;
}

// 4 - Funções estáticas
// Ao tipar uma variável como static dentro de uma função, ela mantem o valor dessa variável enquanto o script está rodando

function registraContagemXmlInseridos(Object $objXml, int &$acumulador = 0): string
    {
        static $totalXmlInseridos = 0;
        $totalXmlInseridos ++;
        $acumulador ++;

        return "O Xml com a chave {$objXml->getChave()} foi inserida no banco de dados. Total = {$totalXmlInseridos}" . PHP_EOL;
    }

class Xml {
    private string $chave;
    private int $idTipoOperacao;

    /**
     * @return null|string
     */
    public function getChave(): ?string
    {
        return $this->chave;
    }

    /**
     * @param mixed $chave
     */
    public function setChave(string $chave): void
    {
        $this->chave = $chave;
    }

    /**
     * @return null|int
     */
    public function getIdTipoOperacao(): ?int
    {
        return $this->idTipoOperacao;
    }

    /**
     * @param int $idTipoOperacao
     */
    public function setIdTipoOperacao(int $idTipoOperacao): void
    {
        $this->idTipoOperacao = $idTipoOperacao;
    }


}

for ($i = 0; $i < 3; $i++) {
    $objXml = new Xml();

    $chave = implode('', array_map(
        fn() => rand(0, 9),
        range(1, 42)
    ));

    $idTipoOperacao = rand(1, 4);

    $objXml->setChave($chave);
    $objXml->setIdTipoOperacao($idTipoOperacao);

    echo registraContagemXmlInseridos($objXml);
}

echo PHP_EOL;

// 5 - Passagem por referência
// Vamos usar o mesmo exemplo de cima, mas ao invés de usar o static dentro do escopo da função, vamos passar o valor
// por referência que ser alterado dentro da função e ser usado fora do escopo dela

$acumuladorOriginal = 0;

for ($i = 0; $i < 50; $i++) {
    $objXml = new Xml();

    // 6 - Clousures: São funções anônimas usadas como valores de uma variável no caso estamos gerando uma chave aleatório e passando o valor gerado para o objXml
    $chave = implode('', array_map(
        fn() => rand(0, 9),
        range(1, 42)
    ));

    $idTipoOperacao = rand(1, 4);

    $objXml->setChave($chave);
    $objXml->setIdTipoOperacao($idTipoOperacao);

    registraContagemXmlInseridos($objXml, $acumuladorOriginal);
}

if ($acumuladorOriginal) {
    echo "Foram inseridos {$acumuladorOriginal} XMLs novos no banco de dados." . PHP_EOL;

}  else {
    echo "Não houve XMLs novos no banco de dados." . PHP_EOL;
}
