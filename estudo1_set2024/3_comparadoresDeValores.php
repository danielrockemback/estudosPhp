<?php

$a = 2;
$b = "2";
$c = 10;

$quebraLinha = str_repeat("=", 50) . PHP_EOL;

var_dump($a == $c) . PHP_EOL;   // == retorna true se a é igual a b / false
var_dump($a === $b) . PHP_EOL;  // === retorna true se for identico o tipo de dado e o valor    / false
var_dump($a != $b) . PHP_EOL;   // != retorna true se o valor for diferente de b    / false
var_dump($a !== $b) . PHP_EOL;  // !== retorna true se for identico o tipo de dado e o valor    / true
var_dump($a > $c) . PHP_EOL;    // > retorna true se a for maior que c  / false
var_dump($a < $c) . PHP_EOL;    // < retorna true se a for menor que c  / true
var_dump($a >= $c) . PHP_EOL;  // >= retorna true se a for maior ou igual a c  / false
var_dump($a <= $c) . PHP_EOL;   // <= retorna true se a for menor ou igual a c /    true

echo $quebraLinha;

// OPERAÇÕES EM ARRAYS

$lst = [1 => "a", 2 => "b", 3 => "c"];
$lst2 = [4 => "d", 5 => "e", 6 => "f"];
$lst3 = [1 => "a", 2 => "b", 3 => "c"];

print_r($lst + $lst2) . PHP_EOL;    // + a combinação de duas array que contenha indices diferente
var_dump($lst == $lst2) . PHP_EOL;   // == Verifica se dois arrays têm os mesmos elementos e as mesmas chaves, independentemente da ordem.  / False
var_dump($lst === $lst3) . PHP_EOL;   // === Verifica se dois arrays são idênticos, ou seja, têm os mesmos elementos na mesma ordem e com as mesmas chaves e tipos. /True
var_dump($lst != $lst2) . PHP_EOL; // != Verifica se dois arrays não são idênticos. Isso significa que eles podem ter os mesmos elementos, mas se a ordem for diferente ou os tipos de dados forem diferentes, a comparação será considerada verdadeira.    / True
var_dump($lst !== $lst3) . PHP_EOL; // !== Verifica se dois arrays não são iguais. A comparação de desigualdade ignora a ordem dos elementos, mas verifica se os valores e chaves são diferentes.   / False

echo $quebraLinha;

// OPERADORES LÓGICOS
$idade = 18;
$nome = 'Fulano';

echo "&& AND" . PHP_EOL;
if (($idade == 18) && ($nome == 'Fulano')):  // OPERADOR && (AND) retorna true se todas as confições forem True
    echo "É verdadeiro" . PHP_EOL;
else:
    echo "É Falso" . PHP_EOL;
endif;

echo "|| OR" . PHP_EOL;
if (($idade == 55) || ($nome == 'Fulano')):  // OPERADOR || (OR) retorna True se pelo menos uma condição for verdadeira
    echo "É verdadeiro" . PHP_EOL;
else:
    echo "É Falso" . PHP_EOL;
endif;

echo "XOR OU EXCLUSIVO" . PHP_EOL;
if ($idade == 18 xor $nome == 'Fulano'):  // OPERADOR XOR (XOR) retorna true APENAS se uma das condições forem verdadeiras, se caso as duas forem true, ela retorna false
    echo "É verdadeiro" . PHP_EOL;
else:
    echo "É Falso" . PHP_EOL;
endif;

echo "! NOT" . PHP_EOL;
if (!($idade == 18) && !($nome == 'Fulano')):  //
    echo "É verdadeiro" . PHP_EOL;
else:
    echo "É Falso" . PHP_EOL;
endif;
