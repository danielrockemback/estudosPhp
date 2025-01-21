<?php

# Aspas simples: São literais
# Aspas duplas: São interpretativas, se quiser deixar a variável entre aspas duplas é só usar o "xxxxxxxxxxxx  xxxxxx xxxxx \"$nome\" xxxxx xxx x"
# Em questão de performance, as aspas simples são mais rápidas, mas a diferença não é tão grande

$loja = "Coqueiro";

echo 'O nome da loja é $loja' . PHP_EOL;
echo "O nome da loja é $loja" . PHP_EOL;

echo PHP_EOL;
#                                               HEREDOC
//Heredoc é uma forma de declarar strings em PHP que permite incluir variáveis e múltiplas linhas de texto sem necessidade
//de concatenação. Começa com <<< seguido de um identificador e termina com o mesmo identificador em uma linha própria.

$mensagem = <<<MSG
Olá, seja bem vindo
a loja $loja, nós
temos os melhores preços,
confira tudo!
MSG;

# HEREDOC com HTML
$nome = "João";

$html = <<<HTML
<h1>Bem-vindo, $nome!</h1>
<p>Esta é uma mensagem simples usando Heredoc.</p>
HTML . PHP_EOL;

echo $html . PHP_EOL;

#                                           NOWDOC
# O Nowdoc é semelhante ao Heredoc, mas é usado para strings que não interpretam variáveis. É indicado com aspas simples.

$template = <<<'HTML'
<div class="container">
    <h1>Título do Template</h1>
    <p>Conteúdo que não será alterado.</p>
</div>
HTML . PHP_EOL;

echo $template . PHP_EOL;

$url = 'https://www.lojascoqueiro.com.br/';

# substr(): Faz o fatiamento da string de acordo com índice
echo substr($url, 12, -8) . PHP_EOL;

if (substr($url, 0, 5) == 'https') {
    echo "O site $url é um site seguro! " . PHP_EOL;
}

# strpos(): é usada para encontrar a posição da primeira ocorrência de uma substring dentro de uma string. Ela retorna
# a posição (base 0) ou false se a substring não for encontrada. Se for pra achar uma palavra, ele retorna o índice de onde começa

$email = 'danielborgesgrupocoqueiro.com.br';
$find = '@';

if (!strpos($email, $find)) {
    echo 'O E-mail está incorreto!' . PHP_EOL;
}

# strcasecmp():  compara duas strings ignorando a diferença entre maiúsculas e minúsculas. Retorna 0 se as strings
# forem iguais (ignorando o caso), um valor negativo se a primeira for menor que a segunda, e um valor positivo se a primeira for maior.


$string1 = "PHP é ótimo";
$string2 = "php é ótimo";


$resultado = strcasecmp($string1, $string2);

if ($resultado == 0){
    echo "As duas strings são iguais" . PHP_EOL;
}

#strcmp() é semelhante ao strcasecmp, mas é sensível a maiúsculas e minúsculas. Compara duas strings exatamente
# e retorna 0 se forem iguais, um número negativo se a primeira for menor, e positivo se a primeira for maior.

$resultado = strcmp($string1, $string2);

if (!$resultado == 0){
    echo "As strings são diferentes." . PHP_EOL;
}

#similar_text() mede a similaridade entre duas strings, calculando uma porcentagem. Ele conta quantos caracteres estão em sequência entre as duas strings.


$str1 = "casa";
$str2 = "casamento";

similar_text($str1, $str2, $porcentagem);
echo "Similaridade: $porcentagem" . PHP_EOL;

#levenshtein() mede a "distância" entre duas strings, calculando o número mínimo de alterações necessárias para transformar uma string na outra

$string1 = "kitten";
$string2 = "sitting";

$distancia = levenshtein($string1, $string2);
echo "Distância Levenshtein: $distancia" . PHP_EOL;

#strlen() a função strlen retorna o número de caracteres em uma string. Isso inclui espaços e pontuações.

if (strlen($email) <= 4 or !strpos($email, '@')) {
    echo 'O email que você digitou está incorreto!' . PHP_EOL;
}

#str_word_count() conta o número de palavras em uma string. Ela também pode retornar as palavras como um array se quisermos.


$string = "Olá, mundo! Bem-vindo ao PHP.";
$numeroDePalavras = str_word_count($string);    // Se quiser que tudo retorne dentro de uma array é só colocar 1 depois da $string

echo "Número de palavras: $numeroDePalavras" . PHP_EOL;

#soundex() gera um código fonético para uma string. Esse código é baseado na forma como a palavra é pronunciada
# em inglês e é útil para comparar palavras que soam de forma semelhante, mas podem ser escritas de maneira diferente.


$palavra1 = "Smith";
$palavra2 = "Smyth";

$soundex1 = soundex($palavra1);     // Retorna: S530
$soundex2 = soundex($palavra2);     // Retorna: S530

if ($soundex1 === $soundex2) {
    echo "As palavras soam semelhantes." . PHP_EOL;
}

#metaphone() também gera um código fonético, mas utiliza um algoritmo mais complexo que pode dar resultados mais precisos
# em alguns casos. O código gerado é mais longo que o gerado pelo soundex e é também sensível à pronúncia.


$palavra1 = "Smith";
$palavra2 = "Smyth";

$metaphone1 = metaphone($palavra1);     // Saída: Metaphone de 'Smith': S530
$metaphone2 = metaphone($palavra2);     // Saída: Metaphone de 'Smyth': S530

if ($metaphone1 === $metaphone2) {
    echo "As palavras soam semelhantes." . PHP_EOL;
} else {
    echo "As palavras não soam semelhantes." . PHP_EOL;
}

# Essas funções podem ser usada para quando o usuário pesquisar um nome, o sistema sugerir algum nome semelhante e ajudando a encontrar rapidamente


# explode() divide uma string em partes, usando um delimitador específico. O resultado é um array contendo as substrings geradas pela divisão.
# função split do python

$string = "maçã, banana, laranja, uva";
$frutas = explode(", ", $string);


# print_r() é utilizada para imprimir informações sobre uma variável de forma legível. É especialmente útil para visualizar o conteúdo de arrays ou objetos de maneira estruturada.
print_r($frutas);

