<?php

$quebraLinha = str_repeat("=", 50) . PHP_EOL;

// if; else; elseif; if-else (ternário)

$idade = 17;

if ($idade < 16){
    echo 'Menor de 16 anos não pode votar.' . PHP_EOL;

}elseif ($idade >= 16 && $idade < 18 || $idade >= 70){
    echo 'Voto não obrigatório' . PHP_EOL;

}elseif ($idade >= 18 and $idade < 70){
    echo 'Voto obrigatório' . PHP_EOL;

}else{
    echo 'Dado inserido está incorreto.' . PHP_EOL;
}
echo $quebraLinha;
// OPERADOR TERNÁRIO

$ehMaior = $idade >= 18 ? 'É maior de idade' : 'Menor de idade.';   // operador ternário
echo $ehMaior . PHP_EOL;

$cpfCliente = '02142369578' . PHP_EOL;
echo $cpfCliente ?: 'CPF não informado.' . PHP_EOL; // Forma curta do ternário

$dataExclusao = null;
echo $dataExclusao ?? 'O funcionário ainda tem acesso.' . PHP_EOL;  // Ternário com Null Coalesce(??) verifica se a variável é nula, se for nula, retorna o valor depois de ??

echo $quebraLinha;
// Comparação combinada <=>
$a = 5;
$b = 10;
$c = 15;

echo $a <=> $b; //  se o primeiro valor for menor retorna: -1
echo PHP_EOL;
echo $b <=> $b; // se forem iguais retorna: 0
echo PHP_EOL;
echo $c <=> $b; // se o primeiro valor for maior retorna: 1
echo PHP_EOL;
echo $quebraLinha;

// SWITCH
// O switch compara uma variável com diferentes casos (valores) e executa o bloco de código correspondente.

$cor = 'Branco';

switch ($cor){
    case 'Azul':
        echo 'A cor é azul.' . PHP_EOL;
        break;
    case 'Verde':
        echo 'A cor é verde.' . PHP_EOL;
        break;
    case 'Vermelho':
        echo 'A cor é vermelho.' . PHP_EOL;
        break;
    case 'Branco':
        echo 'A cor é branco.' . PHP_EOL;
        break;
    default:
        echo 'Cor indefinida.' . PHP_EOL;
}

echo $quebraLinha;
