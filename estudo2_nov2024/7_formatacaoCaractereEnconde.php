<?php

# printf() formata uma string e a exibe diretamente. Você define um "template" com placeholders que serão substituídos pelos valores fornecidos.
# %s para string, %d ou %i para inteiro e %f para float seendo que vc pode formatar as casas decimais (%.4f)

$nome = "João";
$idade = 25;
$peso = 85.52142335;

printf("Meu nome é %s e tenho %d anos e atualmente eu estou com %.2f KG", $nome, $idade, $peso) . PHP_EOL;
echo PHP_EOL;


#sprintf() Retorna uma string formatada para ser usada posteriormente

$produto1 = 'Café do Sítio';
$produto2 = 'Coca-Cola';
$preco1 = 29.99;
$preco2 = 9.99;

echo sprintf("%'.-40sR$%.2f", $produto1, $preco1) . PHP_EOL;
echo sprintf("%'.-38sR$%.2f", $produto2, $preco2) . PHP_EOL;

$valorProduto = 1234567.89;
echo sprintf("Valor do produto: R$ %s", number_format($valorProduto, 2, ',', '.')) . PHP_EOL;

#vsprintf() funciona como sprintf, mas permite passar os valores em um array. Isso é útil em situações onde os dados vêm de uma lista ou array dinâmico.

$dados = [$nome, $idade, $peso];

echo vsprintf("O funcionário %s tem %d anos", $dados).PHP_EOL;

#fprintf() formata uma string e a escreve diretamente em um arquivo ou outro recurso de saída. É útil para salvar dados formatados em arquivos, como logs.

$arquivo = fopen("log.txt", "a");
function gravarLog($arquivo, $nivel, $mensagem)
{
    $dataHora = date("d-m-Y H:i:s");
    fprintf($arquivo, "[%s] [%s]: %s\n", $dataHora, strtoupper($nivel), $mensagem);
}

gravarLog($arquivo, "info", "O sistema foi iniciado.");
gravarLog($arquivo, "warning", "Uso de memória elevado.");
gravarLog($arquivo, "error", "Erro ao conectar ao banco de dados.");

fclose($arquivo);
