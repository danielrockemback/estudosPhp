<?php
#                         Boundary Metacharacters
//Boundary Metacharacters são usados em expressões regulares para identificar limites em uma string.
//Esses limites podem ser o início ou o fim de uma string ou os limites de uma palavra.

//  ^: Verifica o início da string.     "/^Coqueiro/"
//  $: Verifica o final da string.      '/Coqueiro$/'
//  \b: Limite de palavra (word boundary).
//  \B: Não é um limite de palavra.
//  return = 0 (false), 1 = (True)

$padrao = "/^Coqueiro/";
$padrao2 = '/Coqueiro$/';
$string = "Grupo Coqueiro";

// preg_match($padrao, $string, $array(<-Opcional esse param)) pega a primeira ocorrência do regex
echo preg_match($padrao, $string) . PHP_EOL;    #Retorna false, (^) vai verificar se Coqueiro está no início da string
echo preg_match($padrao2, $string) . PHP_EOL;   #Retorna true, ($) vai verificar se Coqueiro está no final da string

// preg_match_all(), é parecido com o anterior, porém pega todas as ocorrências
//  \d+ = um ou mais digítos
//  \s = espaço
//  reais = corresponde a palavra "reais"

$string2 = 'O cimento custá em torno de 30 reais';
$padrao3 = "/\d+\sreais/";
preg_match($padrao3, $string2, $resultado) . PHP_EOL;  # Retorna true = 1
print_r($resultado) . PHP_EOL;  # $resultado vai retornar um array com as ocorrências
echo PHP_EOL;

#                       Character Classes []
//Character Classes definem conjuntos de caracteres uqe podem ser correspondidos
// [abc]: Corresponde a "a", "b" ou "c".
// [a-z]: Corresponde a qualquer letra minúscula
// \d: Corresponde a qualquer dígito entre a [0-9]
// \w: Corresponde a um conjunto alfanumérico
// \s: Corresponde a qualquer espaço
// [^a-z]: ^ no começo corresponde a uma negação, eu não quero nenhuma letra

$string3 = 'Estudo_Regex 3';
$padrao4 = '[\w\s]';    # Verifica se a string é alfanumérico + espaços + underline
echo preg_match($padrao4, $string3) . PHP_EOL;  # true

#                       Greediness
//refere-se ao comportamento dos quantificadores nas expressões regulares, ou seja, a maneira como eles
//tentam corresponder o máximo possível de caracteres dentro da string.

//              Tipos de Quantifiers
//  *: Corresponde a zero ou mais ocorrências do padrão anterior.
//  +: Corresponde a uma ou mais ocorrências do padrão anterior.
//  ?: Corresponde a zero ou uma ocorrência do padrão anterior.
//  {n,m}: Corresponde a n a m ocorrências do padrão anterior.

$string4 = 'O cachorro late muito alto';
$padrao5 = '/l.*o/';    # * pega a primeira ocorrência 'c' e vai até a última ocorrência 'o'. Padrão Greedy
preg_match_all($padrao5, $string4, $resultado);
print_r($resultado) . PHP_EOL;
echo PHP_EOL;

$padrao6 = '/c.*?o/';
preg_match($padrao6, $string4, $resultado); # ? retornar ocorrência que começa com 'c' e termina no primeiro 'o'. Padrão Lazy
print_r($resultado) . PHP_EOL;
echo PHP_EOL;

$padrao7 = '/c.+e/';
preg_match($padrao7, $string4, $resultado); # ? retornar ocorrência que começa com 'c' e terminar no primeiro 'o'. Padrão Lazy
print_r($resultado) . PHP_EOL;  # + retorna o máximo de caracteres entre 'c' até o 'e'
echo PHP_EOL;

$frutas = ["maçã", "banana", "cereja", "damasco", "morango"];
$padrao8 = "/^m/";

#   preg_grep: filtra de dentro de um array e retorna os elementos de acordo com o padrão passado
print_r(preg_grep($padrao8, $frutas)) . PHP_EOL;
echo PHP_EOL;

$texto = "O gato é muito perigoso, mas o gato é esperto.";
$padrao9 = '/gato/';
$replace = 'cachorro';

#   preg_replace: procura por um padrão dentro da string e substitui as ocorrências por outra string
echo preg_replace($padrao9, $replace, $texto) . PHP_EOL;
echo PHP_EOL;

$texto2 = "um,dois,três,quatro,cinco";
$padrao10 = "/,/";

#   preg_split: divide uma string com base num separador que é escolhido no padrão e retorna um array
print_r(preg_split($padrao10, $texto2)) . PHP_EOL;
echo PHP_EOL;

#                                      mbstring
// O objetivo principal da mbstring é garantir que as funções que lidam com strings considerem
// a correta largura dos caracteres, não apenas a contagem de bytes.

#                                     mb_check_encoding
# A função mb_check_encoding é usada para verificar se uma string está em uma codificação de caracteres especificada.

$string = "Olá, mundo! こんにちは世界";

echo mb_check_encoding($string, 'UTF-8');   // vai retornar true
echo mb_convert_encoding($string, 'UTF-8', 'ISO-8859-1');  // Vai fazer a conversão de um encoding para o outro

# Funções de mbstring mais usadas

//mb_strlen: Retorna o número de caracteres em uma string multibyte.
//mb_substr: Extrai uma parte de uma string multibyte
//mb_strpos: Encontra a posição da primeira ocorrência de uma substring em uma string multibyte.
//mb_strtolower e mb_strtoupper: Converte todos os caracteres de uma string multibyte para minúsculas ou maiúsculas.
//mb_split: Divide uma string multibyte em um array de strings com base em um separador