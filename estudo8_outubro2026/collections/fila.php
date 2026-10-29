<?php


/**
 * COLLECTIONS: FILA (QUEUE)
 *
 * O primeiro que entra é o primeiro que sai (FIFO: First In, First Out).
 * Igual a fila do banco: entra no final, sai pela frente.
 *
 * Operações:
 * - enqueue: entra no final
 * - dequeue: sai da frente
 * - peek: olha quem é o próximo sem tirar
 *
 * Cuidado: com array comum, o array_shift() renumera todos os índices (O(n)).
 * O SplQueue tira da frente em O(1).
 */

function titulo(string $texto): void
{
    echo "\n" . str_repeat('=', 60) . "\n";
    echo $texto . "\n";
    echo str_repeat('=', 60) . "\n";
}


// ------------------------------------------------------------
titulo('1. Fila com array comum');
// ------------------------------------------------------------

$fila = [];

$fila[] = 'Cliente 1'; // enqueue
$fila[] = 'Cliente 2'; // enqueue
$fila[] = 'Cliente 3'; // enqueue

echo 'Próximo (peek): ' . reset($fila) . "\n";        // Cliente 1
echo 'Atendido (dequeue): ' . array_shift($fila) . "\n"; // Cliente 1
echo 'Atendido (dequeue): ' . array_shift($fila) . "\n"; // Cliente 2
echo 'Ainda na fila: ' . count($fila) . "\n";             // 1

// Fila vazia: array_shift devolve null
array_shift($fila);
var_dump(array_shift($fila)); // NULL


// ------------------------------------------------------------
titulo('2. Fila com SplQueue');
// ------------------------------------------------------------

$fila = new SplQueue();

$fila->enqueue('Cliente 1');
$fila->enqueue('Cliente 2');
$fila->enqueue('Cliente 3');

echo 'Próximo (bottom): ' . $fila->bottom() . "\n"; // Cliente 1 (a frente da fila)

// O foreach percorre na ordem de chegada, SEM tirar ninguém da fila
foreach ($fila as $cliente) {
    echo $cliente . "\n"; // Cliente 1, Cliente 2, Cliente 3
}

echo 'Atendido (dequeue): ' . $fila->dequeue() . "\n"; // Cliente 1
echo 'Ainda na fila: ' . count($fila) . "\n";           // 2

// Fila vazia: o SplQueue lança exceção
$fila->dequeue();
$fila->dequeue();

try {
    $fila->dequeue();
} catch (RuntimeException $e) {
    echo 'Erro: ' . $e->getMessage() . "\n";
}

echo 'Está vazia? ' . ($fila->isEmpty() ? 'sim' : 'não') . "\n";


// ------------------------------------------------------------
titulo('3. Pilha x Fila com os mesmos dados');
// ------------------------------------------------------------

$pedidos = ['Pedido A', 'Pedido B', 'Pedido C'];

$pilha = new SplStack();
$fila = new SplQueue();

foreach ($pedidos as $pedido) {
    $pilha->push($pedido);
    $fila->enqueue($pedido);
}

echo 'Pilha (LIFO): ';
while (!$pilha->isEmpty()) {
    echo $pilha->pop() . '  '; // Pedido C, Pedido B, Pedido A
}

echo "\nFila  (FIFO): ";
while (!$fila->isEmpty()) {
    echo $fila->dequeue() . '  '; // Pedido A, Pedido B, Pedido C
}
echo "\n";


// ------------------------------------------------------------
titulo('4. Mundo real: fila de envio de notas fiscais');

// ------------------------------------------------------------

final class FilaNotasFiscais
{
    private SplQueue $fila;

    public function __construct()
    {
        $this->fila = new SplQueue();
    }

    // Quem gera a nota só coloca na fila e segue a vida (não espera a SEFAZ)
    public function adicionar(string $numeroNota): void
    {
        $this->fila->enqueue($numeroNota);
        echo "Nota {$numeroNota} entrou na fila\n";
    }

    // O "worker" processa uma por vez, na ordem de chegada
    public function processar(): void
    {
        while (!$this->fila->isEmpty()) {
            $nota = $this->fila->dequeue();
            echo "Transmitindo nota {$nota} para a SEFAZ... OK\n";
        }

        echo "Fila vazia, nada mais para transmitir\n";
    }
}

$notas = new FilaNotasFiscais();
$notas->adicionar('001');
$notas->adicionar('002');
$notas->adicionar('003');

echo "\n";
$notas->processar(); // 001, 002, 003 (mesma ordem em que entraram)


// ------------------------------------------------------------
titulo('5. Big O na prática: array_shift x SplQueue');
// ------------------------------------------------------------

$quantidade = 20_000;

// Array comum: cada array_shift renumera todos os índices (O(n))
$filaArray = range(1, $quantidade);
$inicio = microtime(true);

while ($filaArray !== []) {
    array_shift($filaArray);
}

$tempoArray = microtime(true) - $inicio;

// SplQueue: cada dequeue é O(1)
$filaSpl = new SplQueue();
foreach (range(1, $quantidade) as $numero) {
    $filaSpl->enqueue($numero);
}

$inicio = microtime(true);

while (!$filaSpl->isEmpty()) {
    $filaSpl->dequeue();
}

$tempoSpl = microtime(true) - $inicio;

echo "Esvaziando uma fila com {$quantidade} itens:\n";
echo 'array_shift: ' . number_format($tempoArray * 1000, 2, ',', '.') . " ms\n";
echo 'SplQueue:    ' . number_format($tempoSpl * 1000, 2, ',', '.') . " ms\n";
echo "(os tempos variam de máquina para máquina; aumente a quantidade e veja a diferença crescer)\n";