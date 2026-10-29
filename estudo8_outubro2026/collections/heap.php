<?php


/**
 * COLLECTIONS: HEAP (FILA DE PRIORIDADE)
 *
 * Sempre deixa no topo o item mais importante, não importa a ordem em que entraram.
 * Igual o pronto-socorro: quem é mais grave passa na frente.
 *
 * Min-heap: o MENOR fica no topo
 * Max-heap: o MAIOR fica no topo
 */

function titulo(string $texto): void
{
    echo "\n" . str_repeat('=', 60) . "\n";
    echo $texto . "\n";
    echo str_repeat('=', 60) . "\n";
}


// ------------------------------------------------------------
titulo('1. SplMinHeap e SplMaxHeap');
// ------------------------------------------------------------

$numeros = [30, 10, 50, 20, 40];

$minHeap = new SplMinHeap();
$maxHeap = new SplMaxHeap();

foreach ($numeros as $numero) {
    $minHeap->insert($numero);
    $maxHeap->insert($numero);
}

echo 'Topo da min-heap: ' . $minHeap->top() . "\n"; // 10
echo 'Topo da max-heap: ' . $maxHeap->top() . "\n"; // 50

echo 'Tirando da min-heap: ';
while (!$minHeap->isEmpty()) {
    echo $minHeap->extract() . ' '; // 10 20 30 40 50
}

echo "\nTirando da max-heap: ";
while (!$maxHeap->isEmpty()) {
    echo $maxHeap->extract() . ' '; // 50 40 30 20 10
}
echo "\n";


// ------------------------------------------------------------
titulo('2. Armadilha: o foreach esvazia a heap');
// ------------------------------------------------------------

$heap = new SplMinHeap();
$heap->insert(3);
$heap->insert(1);
$heap->insert(2);

echo 'Antes do foreach: ' . count($heap) . " itens\n"; // 3

foreach ($heap as $valor) {
    echo "Lendo {$valor}\n"; // 1, 2, 3
}

echo 'Depois do foreach: ' . count($heap) . " itens\n"; // 0 (ficou vazia!)


// ------------------------------------------------------------
titulo('3. SplPriorityQueue: chamados de suporte');
// ------------------------------------------------------------

// Prioridade maior sai primeiro
$chamados = new SplPriorityQueue();

$chamados->insert('Dúvida sobre relatório', 1);
$chamados->insert('Sistema fora do ar', 10);
$chamados->insert('Erro ao emitir boleto', 5);
$chamados->insert('Trocar senha', 1);

while (!$chamados->isEmpty()) {
    echo $chamados->extract() . "\n";
}
// Sistema fora do ar, Erro ao emitir boleto, e depois os dois de prioridade 1 (em qualquer ordem!)


// ------------------------------------------------------------
titulo('4. Desempate: mesma prioridade respeitando a ordem de chegada');
// ------------------------------------------------------------

// Truque: a prioridade vira um array [prioridade, -ordemDeChegada].
// O PHP compara arrays item por item: se a prioridade empatar, ganha quem tem o maior
// segundo valor. Como usamos negativo, quem chegou antes (-1 > -2) sai primeiro.
$chamados = new SplPriorityQueue();
$ordem = 0;

$novosChamados = [
    ['Dúvida sobre relatório', 1],
    ['Sistema fora do ar', 10],
    ['Trocar senha', 1],
    ['Erro ao emitir boleto', 5],
    ['Atualizar cadastro', 1],
];

foreach ($novosChamados as [$descricao, $prioridade]) {
    $ordem++;
    $chamados->insert($descricao, [$prioridade, -$ordem]);
}

while (!$chamados->isEmpty()) {
    echo $chamados->extract() . "\n";
}
// Sistema fora do ar, Erro ao emitir boleto, Dúvida sobre relatório, Trocar senha, Atualizar cadastro


// ------------------------------------------------------------
titulo('5. SplHeap com regra própria: boletos por vencimento');
// ------------------------------------------------------------

// No SplHeap, fica no topo quem o compare() disser que é "maior".
// Como queremos o vencimento MAIS PRÓXIMO no topo, invertemos a comparação.
final class BoletosPorVencimento extends SplHeap
{
    protected function compare(mixed $boleto1, mixed $boleto2): int
    {
        // Datas no formato Y-m-d podem ser comparadas como texto
        return $boleto2['vencimento'] <=> $boleto1['vencimento'];
    }
}

$boletos = new BoletosPorVencimento();
$boletos->insert(['numero' => 'B003', 'vencimento' => '2026-12-15']);
$boletos->insert(['numero' => 'B001', 'vencimento' => '2026-11-05']);
$boletos->insert(['numero' => 'B002', 'vencimento' => '2026-11-20']);

echo 'Próximo a vencer: ' . $boletos->top()['numero'] . "\n"; // B001

while (!$boletos->isEmpty()) {
    $boleto = $boletos->extract();
    echo "{$boleto['numero']} vence em {$boleto['vencimento']}\n";
}
// B001 (05/11), B002 (20/11), B003 (15/12)


// ------------------------------------------------------------
titulo('6. Top N: as 3 maiores vendas sem ordenar tudo');
// ------------------------------------------------------------

// Ideia: manter uma MIN-heap com só 3 itens.
// Toda vez que passar de 3, tira o menor. No final, sobram os 3 maiores.
$vendas = [1200, 350, 8900, 410, 5600, 75, 9900, 3100, 640, 7200];

$top3 = new SplMinHeap();

foreach ($vendas as $valor) {
    $top3->insert($valor);

    if (count($top3) > 3) {
        $top3->extract(); // remove o menor dos que estão guardados
    }
}

$maiores = [];
while (!$top3->isEmpty()) {
    $maiores[] = $top3->extract(); // sai do menor para o maior
}

echo 'As 3 maiores vendas: ' . implode(', ', array_reverse($maiores)) . "\n"; // 9900, 8900, 7200