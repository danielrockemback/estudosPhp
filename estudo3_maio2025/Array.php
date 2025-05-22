<?php

//                             1 - Definições de Array

// array indexado
$frutas = ['maçã', 'uva', 'laranja'];

// Acessando um array indexado
echo $frutas[0] . PHP_EOL;
echo $frutas[count($frutas) - 1] . PHP_EOL;

// array associativo tem chaves e valores
$pessoa = ['nome' => 'Daniel', 'idade' => 29, 'cpf' => '054289412498'];

// Acessando um array associativo
echo "{$pessoa['nome']} tem {$pessoa['idade']} anos e é portador do CPF: {$pessoa['cpf']}" . PHP_EOL;

// array multidimensional
$alunos = [
    ["nome" => "Ana", "nota" => 9],
    ["nome" => "Carlos", "nota" => 7]
];

//                             2 - Manipulação de Arrays

// array original = $frutas = ['maçã', 'uva', 'laranja'];

// array_pop() – remove o último elemento do array (indexado, associativo ou multidimensional)
array_pop($frutas);
print_r($frutas);

// array_push() – adiciona elementos no final do array (indexado, associativo ou multidimensional)
array_push($frutas, "melancia", "laranja", "mexerica");
print_r($frutas);

// Ou tem como fazer sem usar a função array_push
$pessoa['altura'] = '1.87';
print_r($pessoa);

array_push($alunos, ['nome' => 'Joãozinho', 'nota' => 5]);
print_r($alunos);

// array_shift() – remove o primeiro elemento do array (indexado, associativo ou multidimensional)
array_shift($frutas);
print_r($frutas);

// array_unshift() – adiciona no início do array (indexado, associativo ou multidimensional)
array_unshift($frutas, "Caqui", "pera");
print_r($frutas);

// Modificando o array diretamente
$frutas[0] = 'Abacaxi';
$frutas[5] = 'Kiwi';
print_r($frutas);

$pessoa['nome'] = 'Maria';
$pessoa['altura'] = '1.55';
print_r($pessoa);

$alunos[0]['nome'] = 'Marcos';
$alunos[0]['nota'] = 10;
$alunos[1]['nome'] = 'Joana';
print_r($alunos);

//                             3 - Looping em Arrays

// loop em array indexado
foreach ($frutas as $indice => $valor) {
    echo "[$indice] - {$valor}" . PHP_EOL;
}

echo PHP_EOL;

// loop em array associativo
foreach ($pessoa as $chave => $valor) {
    echo "{$chave}: {$valor}" . PHP_EOL;

}

echo PHP_EOL;

// loop aninhado em array multidimensional
foreach ($alunos as $indice => $aluno) {
    foreach ($aluno as $nome => $nota) {
        echo "{$nome}: {$nota}" . PHP_EOL;
    }
    echo PHP_EOL;
}

// loop em array multidimensional pegando os indices
foreach ($alunos as $indice => $aluno) {
    echo "[$indice] - Nome: {$aluno['nome']}: Nota {$aluno['nota']}" . PHP_EOL;
}

echo PHP_EOL;

//                             4 - Callback (Funções anônimas)

// array_map() – aplica uma função em todos os valores do array
// Sintaxe: array_map(fn($variavel) => expressão, $arrayQualquer)
$numeros = [55, 1, 22, 3, 4];
$dobro = array_map(fn($n) => $n * 2, $numeros);
print_r($dobro);

$produtos = ['cimento' => 35.63, 'conexão' => 4.99, 'areia fina' => 240.00];
$descontoQuinzePorcento = array_map(fn($preco) => $preco - ($preco * 0.15), $produtos);
print_r($descontoQuinzePorcento);

// Aplicando uma função anônima para deixar todos os nomes em upper case
$frutas = array_map(fn($fruta) => strtoupper($fruta), $frutas);
print_r($frutas);

// array_filter() – filtra com base na condição criando um novo array
// Sintaxe: array_filter(fn($variavel) => expressão)
$pares = array_filter($numeros, fn($n) => $n % 2 === 0);
print_r($pares);

// filter no array assoc e multidimensional
$filterAssoc = array_filter($produtos, fn($preco) => $preco < 230);
print_r($filterAssoc);

$alunosAprovados = array_filter($alunos, fn($aluno) => $aluno['nota'] >= 7);
print_r($alunosAprovados);

// array_reduce() – reduz o array a um único valor
// array_reduce($array, $callback, $valorInicial)
$soma = array_reduce($numeros, fn($acumulador, $numero) => $acumulador + $numero, 0);
var_dump($soma);

// somando um carrinho de compra que é um array associativo
$carrinhoCompra = array_reduce($produtos, fn($soma, $valorProduto) => $soma + $valorProduto, 0);
echo "Valor total do seu carrinho é de R$ {$carrinhoCompra}" . PHP_EOL;

// Calculado a média das notas
$mediaNotas = array_reduce($alunos, fn($soma, $aluno) => $soma + $aluno['nota'], 0) / count($alunos);
echo "Média de nota dos alunos " . number_format($mediaNotas, 2) . PHP_EOL;

//                             5 - Testando Chaves e Valores
// in_array() – verifica se um valor existe dentro do array e retorna um bool
var_dump(in_array('LARANJA', $frutas,)) . PHP_EOL;

if (in_array($produtos['areia fina'] || $produtos['brita'], $produtos)) {
    echo "O frete vai ser calculado de forma diferente." . PHP_EOL;
} else {
    echo "Produto não encontrado." . PHP_EOL;
}

var_dump(in_array(['nome' => 'Marcos', 'nota' => 8], $alunos)) . PHP_EOL;

// array_key_exists() – verifica se uma chave existe:
var_dump(array_key_exists(10, $frutas)) . PHP_EOL;
var_dump(array_key_exists('email', $pessoa)) . PHP_EOL;
var_dump(array_key_exists('nota', $alunos[2])) . PHP_EOL;

// array_values($array) - retorna todos os valores do array
print_r(array_values($pessoa));

// array_keys($array) - retorna todos as chaves do array
print_r(array_keys($pessoa));

//                             6 - Ordenação
// sort() – ordena valores (array indexado)
sort($frutas);
print_r($frutas);

//  rsort() — igual ao sort(), mas em ordem decrescente
asort($numeros);
print_r($numeros);

//  asort() — ordena por valores [arsort() mesma função, mas ordem decrescente]
asort($produtos);
print_r($produtos);

// ksort() — ordena pelas chaves [krsort() mesma função, mas ordem decrescente]
ksort($produtos);
print_r($produtos);

//                             7 - Junção e Comparação
// array_merge() - Une dois ou mais arrays
$resultado = array_merge($pessoa, $produtos, $frutas, $alunos);
print_r($resultado);

// Unir com o operador +
$arr = $pessoa + $produtos + $numeros;
print_r($arr);

// array_merge_recursive() - Similar ao array_merge, mas mescla valores duplicados em arrays
$arr1 = ['a' => 1, 'b' => 2];
$arr2 = ['b' => 3];

$resultado2 = array_merge_recursive($arr1, $arr2);
print_r($resultado2);

// array_diff() - retorna a diferença somento do primeiro
$a = [1, 2, 3, 4];
$b = [2, 4];

$resultado3 = array_diff($a, $b);
print_r($resultado3);

//                             8 - SPL é estruturas de dados que pode se comportar como uma fila ou pilha

$pilha = new SplStack();
$pilha->push("Item 1");
$pilha->push("Item 2");

// push inseri no array e o metodo pop consume o último que entrou
echo $pilha->pop() . PHP_EOL;

// Uma fila padrão
$fila = new SplQueue();
$fila->enqueue("Cliente 1");
$fila->enqueue("Cliente 2");

// Consumiu o primeiro item da fila
echo $fila->dequeue() . PHP_EOL;
// Consumiu o "segundo" item da fila que na verdade agora é o primeiro
echo $fila->dequeue() . PHP_EOL;;

// Array com tamanho fixo
$array = new SplFixedArray(3);
$array[0] = "A";
$array[1] = "B";
$array[2] = "C";

echo $array[1] . PHP_EOL;
echo  PHP_EOL;

// Permite tratar arrays como objetos com métodos
$obj = new ArrayObject(['a' => 1, 'b' => 2]);
$obj->exchangeArray(['x' => 100, 'y' => 200]);

print_r($obj->getArrayCopy());

// Uma fila onde os itens tem níveis de prioridade sendo a maior prioridade é atendida primeiro
$fila = new SplPriorityQueue();
$fila->insert("Urgente", 3);
$fila->insert("Normal", 1);
$fila->insert("Importante", 2);

echo $fila->extract();
