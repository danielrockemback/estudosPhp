<?php

/**
 * COLLECTIONS: PILHA (STACK)
 *
 * O último que entra é o primeiro que sai (LIFO: Last In, First Out).
 * Igual uma pilha de pratos: coloca em cima, tira de cima.
 *
 * Operações (todas O(1), porque mexem só no topo):
 * - push: coloca no topo
 * - pop: tira do topo
 * - peek/top: olha o topo sem tirar
 */

function titulo(string $texto): void
{
    echo "\n" . str_repeat('=', 60) . "\n";
    echo $texto . "\n";
    echo str_repeat('=', 60) . "\n";
}


// ------------------------------------------------------------
titulo('1. Pilha com array comum');
// ------------------------------------------------------------

$pilha = [];

$pilha[] = 'Prato 1'; // push
$pilha[] = 'Prato 2'; // push
$pilha[] = 'Prato 3'; // push

echo 'Topo (peek): ' . end($pilha) . "\n";     // Prato 3
echo 'Tirou (pop): ' . array_pop($pilha) . "\n"; // Prato 3
echo 'Tirou (pop): ' . array_pop($pilha) . "\n"; // Prato 2
echo 'Sobrou: ' . count($pilha) . " prato\n";    // 1

// Pilha vazia: array_pop devolve null (não dá erro)
array_pop($pilha);
var_dump(array_pop($pilha)); // NULL


// ------------------------------------------------------------
titulo('2. Pilha com SplStack');
// ------------------------------------------------------------

$pilha = new SplStack();

$pilha->push('Prato 1');
$pilha->push('Prato 2');
$pilha->push('Prato 3');

echo 'Topo (top): ' . $pilha->top() . "\n"; // Prato 3

// O foreach do SplStack percorre do topo para a base
foreach ($pilha as $prato) {
    echo $prato . "\n"; // Prato 3, Prato 2, Prato 1
}

echo 'Tirou (pop): ' . $pilha->pop() . "\n"; // Prato 3

// Pilha vazia: o SplStack lança exceção (diferente do array)
$pilha->pop();
$pilha->pop();

try {
    $pilha->pop();
} catch (RuntimeException $e) {
    echo 'Erro: ' . $e->getMessage() . "\n"; // Can't pop from an empty datastructure
}

echo 'Está vazia? ' . ($pilha->isEmpty() ? 'sim' : 'não') . "\n";


// ------------------------------------------------------------
titulo('3. Mundo real: desfazer (Ctrl+Z)');
// ------------------------------------------------------------

final class Editor
{
    private string $texto = '';
    private array $historico = []; // a pilha

    public function escrever(string $novoTexto): void
    {
        $this->historico[] = $this->texto; // push: guarda o estado ANTES da alteração
        $this->texto .= $novoTexto;
    }

    public function desfazer(): void
    {
        if ($this->historico === []) {
            echo "Nada para desfazer\n";
            return;
        }

        $this->texto = array_pop($this->historico); // pop: volta para o último estado
    }

    public function exibir(): void
    {
        echo "Texto: \"{$this->texto}\"\n";
    }
}

$editor = new Editor();
$editor->escrever('Olá');
$editor->escrever(', Daniel');
$editor->escrever('!');
$editor->exibir(); // Olá, Daniel!

$editor->desfazer();
$editor->exibir(); // Olá, Daniel

$editor->desfazer();
$editor->exibir(); // Olá

$editor->desfazer();
$editor->exibir(); // ""

$editor->desfazer(); // Nada para desfazer


// ------------------------------------------------------------
titulo('4. A pilha de chamadas (call stack)');
// ------------------------------------------------------------

// Cada chamada ainda não terminada fica esperando na pilha.
// A última chamada que entrou é a primeira a terminar (LIFO).
function contagemRegressiva(int $numero): void
{
    if ($numero === 0) {
        echo "Chegou no fundo da pilha\n";
        return;
    }

    echo "Entrou: {$numero}\n";
    contagemRegressiva($numero - 1);
    echo "Saiu: {$numero}\n"; // só roda quando a chamada de baixo terminar
}

contagemRegressiva(3);
// Entrou: 3, Entrou: 2, Entrou: 1, Chegou no fundo, Saiu: 1, Saiu: 2, Saiu: 3