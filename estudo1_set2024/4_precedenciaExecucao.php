<?php

// PRECEDÊNCIA DE OPERADORES
// () EXPONENCIÇÃO/ MULTIPLICAÇÃO DIVISÃO/  ADIÇÃO SUBTRAÇÃO = PP.E.M.D.A.S

$quebraLinha = str_repeat("=", 50) . PHP_EOL;
$num1 = 10;
$num2 = 20;
$num3 = 2 + 2 ** 4 - (11 - 5) / 2 * 5;
//      2 + 16 - (11 - 5) / 2 * 5
//      2 + 16 - 6 / 2 * 5
//      2 + 16 - 15
//      18 - 15
//         3

$media = ($num1 + $num2) / 2;

echo "A média entre $num1 e $num2 é " . $media .PHP_EOL;
echo "Resultado: " . $num3 . PHP_EOL;

echo $quebraLinha;

// OPERADOS DE EXECUÇÃO:

$comando = 'dir';    // Comando para listar arquivos e retorna apenas a última linha da saída ou pode ser salva a saída completa em uma array
$saida = exec($comando, $lista);
print_r($lista) . PHP_EOL;

$comando2 = 'ping google.com';
$saida = shell_exec($comando2);  // shell_exec executa um comando passado e retorna toda a saída deste comando como uma string
echo $saida;

$comando3 = 'set';  // variáveis de ambiente
system($comando3);   // Executa o comando informado em comando e imprime o resultado imediatamente
