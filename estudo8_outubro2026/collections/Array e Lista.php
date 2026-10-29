<?php

/**
 * COLLECTIONS: ARRAY E LISTA
 *
 * Array (conceito clássico): sequência de tamanho fixo, posições numeradas a partir de 0.
 * Lista: sequência ordenada que pode crescer e diminuir.
 *
 * No PHP, o array é um mapa ordenado que serve pra tudo (lista, dicionário, pilha, fila).
 * Uma "lista" no PHP é um array com chaves 0, 1, 2... em sequência.
 *
 * Custos:
 * - Acessar por índice: O(1)
 * - Adicionar no final: O(1)
 * - Adicionar no início (array_unshift): O(n), renumera todos
 * - Buscar por valor (in_array): O(n), olha item por item
 */

function titulo(string $texto): void
{
    echo "\n" . str_repeat('=', 60) . "\n";
    echo $texto . "\n";
    echo str_repeat('=', 60) . "\n";
}


// ------------------------------------------------------------
titulo('1. Array no PHP: lista e dicionário');
// ------------------------------------------------------------

$lista = ['Caneta', 'Caderno', 'Lápis'];               // chaves 0, 1, 2
$dicionario = ['nome' => 'Daniel', 'cidade' => 'DF'];  // chaves texto

print_r($lista);
print_r($dicionario);


// ------------------------------------------------------------
titulo('2. Operações básicas de uma lista');
// ------------------------------------------------------------

$produtos = ['Caneta', 'Caderno'];

// Adicionar no final
$produtos[] = 'Lápis';

// Acessar por índice
echo "Índice 1: {$produtos[1]}\n"; // Caderno

// Adicionar no início (renumera todos os índices)
array_unshift($produtos, 'Borracha');

// Buscar por valor
echo 'Tem Lápis? ' . (in_array('Lápis', $produtos) ? 'sim' : 'não') . "\n";

// Tamanho
echo 'Quantidade: ' . count($produtos) . "\n";

// Percorrer
foreach ($produtos as $indice => $produto) {
    echo "{$indice}: {$produto}\n";
}


// ------------------------------------------------------------
titulo('3. Armadilha: unset não renumera');
// ------------------------------------------------------------

$produtos = ['Caneta', 'Caderno', 'Lápis'];
unset($produtos[1]);

print_r($produtos); // [0 => 'Caneta', 2 => 'Lápis']
echo 'É lista? ' . (array_is_list($produtos) ? 'sim' : 'não') . "\n";      // não
echo 'JSON com buraco: ' . json_encode($produtos) . "\n";                    // {"0":"Caneta","2":"Lápis"}

// Correção: array_values renumera a partir de 0
$produtos = array_values($produtos);

print_r($produtos); // [0 => 'Caneta', 1 => 'Lápis']
echo 'É lista? ' . (array_is_list($produtos) ? 'sim' : 'não') . "\n";      // sim
echo 'JSON corrigido: ' . json_encode($produtos) . "\n";                     // ["Caneta","Lápis"]


// ------------------------------------------------------------
titulo('4. SplFixedArray: array clássico de tamanho fixo');
// ------------------------------------------------------------

$vagas = new SplFixedArray(3); // exatamente 3 posições

$vagas[0] = 'Carro A';
$vagas[1] = 'Carro B';
$vagas[2] = 'Carro C';

foreach ($vagas as $indice => $carro) {
    echo "Vaga {$indice}: {$carro}\n";
}

// Tentando usar uma posição que não existe
try {
    $vagas[3] = 'Carro D';
} catch (RuntimeException $e) {
    echo 'Erro: ' . $e->getMessage() . "\n"; // Index invalid or out of range
}


// ------------------------------------------------------------
titulo('5. SplDoublyLinkedList: lista ligada');
// ------------------------------------------------------------

// Cada item aponta pro próximo e pro anterior, como vagões de trem
$listaLigada = new SplDoublyLinkedList();

$listaLigada->push('Caneta');   // adiciona no final
$listaLigada->push('Caderno');  // adiciona no final
$listaLigada->unshift('Lápis'); // adiciona no início, sem renumerar ninguém

foreach ($listaLigada as $item) {
    echo $item . "\n"; // Lápis, Caneta, Caderno
}

echo 'Quantidade: ' . count($listaLigada) . "\n";