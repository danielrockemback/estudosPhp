<?php

// OPERADORES ARITIMÉTICOS + - * / % **

$num1 = 10;
$num2 = 2;
$quebraLinha = str_repeat("=", 50) . PHP_EOL;

echo $quebraLinha;

echo "A soma entre $num1 + $num2 = " . ($num1 + $num2) . PHP_EOL;
echo "A subtração entre $num1 - $num2 =  " . ($num1 - $num2) . PHP_EOL;
echo "A Multiplicação entre $num1 * $num2 = " . ($num1 * $num2) . PHP_EOL;
echo "A divisão entre $num1 / $num2 = " . ( $num1 / $num2) . PHP_EOL;
echo "O restante da divisão entre $num1 % $num2 = " . ($num1 % $num2) . PHP_EOL;
echo "A exponenciação de $num1 ** $num2 = " . ($num1 ** $num2) . PHP_EOL;

echo $quebraLinha;

// OPERADORES BITWISE &(AND), |(OR), ^(XOR),
// $num1 = 1010
// $num2 = 0010

# operador & (E bit a bit): Retorna 1 se ambos os bits forem 1.
echo decbin($num1 & $num2) . PHP_EOL;   //  = 0010

# operador | (OU bit a bit): Retorna 1 se pelo menos um dos bits for 1.
echo decbin($num1 | $num2) . PHP_EOL;   //  = 1010

# operador ^ (XOR bit a bit): Retorna 1 se os bits forem diferentes.
echo decbin($num1 ^ $num2) . PHP_EOL;   //  = 1000

# operador ~ (NÃO bit a bit): Inverte os bits.
echo decbin(~ $num1) . PHP_EOL; //  = 1111111111111111111111111111111111111111111111111111111111110101 = -11

# operador (<< left): Desloca os bits de um número para a esquerda, preenchendo com zeros à direita.
echo decbin($num1 << 1) . PHP_EOL; //    = 10100

# operador (>> right): Desloca os bits de um número para a direita, preenchendo com zeros à esquerda.
echo decbin($num1 >> 1) . PHP_EOL; //    = 0101

echo $quebraLinha;

// OPERADORES DE ATRIBUIÇÃO

$num3 = 50;
echo "Valor inicial de num3 é $num3" . PHP_EOL;
echo "A soma de num3 += 5 é igual " . ($num3 += 5) . " e o valor de num3 = $num3" . PHP_EOL;  // 55
echo "A subtração de num3 -= 10 é igual " .($num3 -= 10) . " e o valor de num3 = $num3" . PHP_EOL;    // 45
echo "A multiplicação de num3 *= 2 é igual " . ($num3 *= 2) . " e o valor de num3 = $num3" . PHP_EOL; // 90
echo "A divisão de num3 /= 9 é igual " . ($num3 /= 9) . " e o valor de num3 = $num3" . PHP_EOL;   // 10
echo "O resto de divsão de num3 %= 2 é igual " . ($num3 %= 2) . " e o valor de num3 = $num3" . PHP_EOL; // 0

$nome = "Daniel ";
$nome .= 'Borges';
echo $nome . PHP_EOL;

echo $quebraLinha;

// INCREMENTO E DECREMENTO ++ incrementa 1 e -- decrementa 1

$num = 10;

echo "INCREMENTO" . PHP_EOL;
echo ++$num . PHP_EOL;  // pré incremento 11
echo $num++ .PHP_EOL;    // pós incremento, vai ser incrementado quando o num for chamado novamente 11
echo $num . PHP_EOL;    // 12

echo "DECREMENTO" . PHP_EOL;
$num = 10;
echo --$num . PHP_EOL;  // pré decremento 9
echo $num-- . PHP_EOL;  // pós decremento vai ser decrementado quando o num for chamado novamente 9
echo $num . PHP_EOL;    // 8

echo $quebraLinha;

?>

