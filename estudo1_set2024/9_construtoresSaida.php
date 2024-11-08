<?php
$quebraLinha = str_repeat("=", 50) . PHP_EOL;

// Construtores da linguagem, de saída: die(); exit(); echo(); print();
// die() e exit() são usados para interromper a execução do script imediatamente, é possível deixar uma mensagem como parâmetro da função

$idade = 15;

if ($idade < 18) {
    die('Esse site de apostas é proibido para menores de 18 anos.');
}

// Comando de saída echo e print
echo "Olá, mundo!" . PHP_EOL;
print("Idade: {$idade} anos" .PHP_EOL);

echo $quebraLinha;

// Construtores da linguagem, de avaliação: empty(); eval(); include; include_onde; require; require_once; isset(); unset(); list();
// valores FALSY
$num = 0;
$numFloat = 0.0;
$zeroStr = '0';
$strVazia = '';
$valorNulo = null;
$bool = false;
$listaVazia = [];

// A função empty() verifica se uma variável está vazia. Considera como "vazia" os items acima
if (empty($num) && empty($numFloat) && empty($zeroStr) && empty($strVazia) && empty($valorNulo)
    && empty($bool) && empty($listaVazia)) {
    echo "Todos os valores verificados retornam falso." . PHP_EOL;
}else{
    echo "Um dos valores é verdadeiro" . PHP_EOL;
}

echo $quebraLinha;

// A função eval() em PHP é utilizada para avaliar uma string como código PHP e executá-la.
// Embora seja poderosa, deve ser usada com cautela devido ao risco de vulnerabilidades de segurança,
// especialmente se a string for derivada de entradas do usuário.

// Definindo uma função usando o EVAL

$nomeFuncao = "dobraValor";
$codigo = "
    function $nomeFuncao(\$num) {   
        \$resultado = \$num * 2;
        return \$resultado;
    }
";

eval($codigo);
echo dobraValor(5) .PHP_EOL; //      a \$ é uma forma de “escapar” o caractere, ou seja, indicar que ele deve ser tratado como um caractere literal

