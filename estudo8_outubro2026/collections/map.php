<?php

/**
 * COLLECTIONS: MAP (MAPA / DICIONÁRIO)
 *
 * Coleção de pares CHAVE → VALOR. Cada chave é única e aponta para um valor.
 * A pergunta principal é "qual o valor dessa chave?", respondida em O(1).
 * Igual uma agenda: o nome é a chave, o telefone é o valor.
 *
 * No PHP, o array associativo já é um Map (e mantém a ordem de inserção).
 *
 * Custos:
 * - Buscar, adicionar e remover por CHAVE: O(1)
 * - Buscar por VALOR (array_search): O(n)
 *
 * Cuidados:
 * - isset() retorna false se o valor for null; use array_key_exists() nesse caso
 * - Só string e int podem ser chaves (para objetos: SplObjectStorage ou WeakMap)
 */

function titulo(string $texto): void
{
    echo "\n" . str_repeat('=', 60) . "\n";
    echo $texto . "\n";
    echo str_repeat('=', 60) . "\n";
}


// ------------------------------------------------------------
titulo('1. Operações básicas');
// ------------------------------------------------------------

$estados = [
    'DF' => 'Distrito Federal',
    'GO' => 'Goiás',
];

$estados['SP'] = 'São Paulo';        // adicionar
$estados['GO'] = 'Goiás (GO)';       // atualizar (mesma chave, troca o valor)

echo 'DF: ' . $estados['DF'] . "\n"; // buscar

echo 'Tem RJ? ' . (isset($estados['RJ']) ? 'sim' : 'não') . "\n"; // não

unset($estados['SP']);               // remover

foreach ($estados as $sigla => $nome) {
    echo "{$sigla} => {$nome}\n";
}

// Valor padrão quando a chave não existe
echo 'RJ: ' . ($estados['RJ'] ?? 'não cadastrado') . "\n";


// ------------------------------------------------------------
titulo('2. Armadilha: isset x array_key_exists');
// ------------------------------------------------------------

$descontos = ['ana' => 10, 'bruno' => null];

echo 'isset bruno: ' . var_export(isset($descontos['bruno']), true) . "\n";                       // false
echo 'array_key_exists bruno: ' . var_export(array_key_exists('bruno', $descontos), true) . "\n"; // true

// isset: "existe E não é null?"
// array_key_exists: "a chave existe?"


// ------------------------------------------------------------
titulo('3. Indexar por id: evitando laço dentro de laço');
// ------------------------------------------------------------

$clientes = [
    ['id' => 10, 'nome' => 'Ana'],
    ['id' => 20, 'nome' => 'Bruno'],
    ['id' => 30, 'nome' => 'Carla'],
];

$vendas = [
    ['numero' => 'V1', 'cliente_id' => 20, 'valor' => 150.00],
    ['numero' => 'V2', 'cliente_id' => 10, 'valor' => 80.00],
    ['numero' => 'V3', 'cliente_id' => 20, 'valor' => 300.00],
];

// array_column com null no 2º parâmetro: devolve a linha inteira, indexada pela coluna 'id'
$clientesPorId = array_column($clientes, null, 'id');
// [10 => ['id' => 10, 'nome' => 'Ana'], 20 => [...], 30 => [...]]

foreach ($vendas as $venda) {
    $cliente = $clientesPorId[$venda['cliente_id']]; // O(1), sem procurar na lista
    echo "{$venda['numero']}: {$cliente['nome']} - R$ {$venda['valor']}\n";
}

// Sem o mapa, seria um foreach de clientes DENTRO do foreach de vendas: O(n²)


// ------------------------------------------------------------
titulo('4. Agrupar: vendas por vendedor');
// ------------------------------------------------------------

$vendas = [
    ['vendedor' => 'Daniel', 'valor' => 200.00],
    ['vendedor' => 'Maria', 'valor' => 150.00],
    ['vendedor' => 'Daniel', 'valor' => 350.00],
    ['vendedor' => 'Maria', 'valor' => 50.00],
    ['vendedor' => 'João', 'valor' => 500.00],
];

$totalPorVendedor = [];

foreach ($vendas as $venda) {
    $vendedor = $venda['vendedor'];
    $totalPorVendedor[$vendedor] = ($totalPorVendedor[$vendedor] ?? 0) + $venda['valor'];
}

foreach ($totalPorVendedor as $vendedor => $total) {
    echo "{$vendedor}: R$ " . number_format($total, 2, ',', '.') . "\n";
}
// Daniel: R$ 550,00 | Maria: R$ 200,00 | João: R$ 500,00


// ------------------------------------------------------------
titulo('5. Contar: boletos por status');
// ------------------------------------------------------------

$statusBoletos = ['pago', 'aberto', 'pago', 'vencido', 'pago', 'aberto'];

// Forma manual
$contagem = [];
foreach ($statusBoletos as $status) {
    $contagem[$status] = ($contagem[$status] ?? 0) + 1;
}
print_r($contagem); // ['pago' => 3, 'aberto' => 2, 'vencido' => 1]

// Forma pronta do PHP
print_r(array_count_values($statusBoletos)); // mesmo resultado


// ------------------------------------------------------------
titulo('6. Tabela de consulta: trocando if/else por um mapa');
// ------------------------------------------------------------

// Em vez de:
// if ($codigo === '00') { ... } elseif ($codigo === '02') { ... } elseif ...
$ocorrenciasBancarias = [
    '02' => 'Entrada confirmada',
    '06' => 'Liquidação (pago)',
    '09' => 'Baixa',
    '17' => 'Liquidação após baixa',
];

$retornoDoBanco = ['02', '06', '99'];

foreach ($retornoDoBanco as $codigo) {
    echo "{$codigo}: " . ($ocorrenciasBancarias[$codigo] ?? 'Código desconhecido') . "\n";
}


// ------------------------------------------------------------
titulo('7. Objetos como chave: SplObjectStorage e WeakMap');
// ------------------------------------------------------------

final class Pedido
{
    public function __construct(public string $numero) {}
}

$pedido1 = new Pedido('P001');
$pedido2 = new Pedido('P002');

// SplObjectStorage: objeto → valor
$statusPedidos = new SplObjectStorage();
$statusPedidos[$pedido1] = 'em separação';
$statusPedidos[$pedido2] = 'enviado';

echo "{$pedido1->numero}: {$statusPedidos[$pedido1]}\n"; // em separação

// WeakMap: igual, mas esquece a entrada sozinho quando o objeto deixa de existir.
// Atenção: usamos pedidos novos aqui, porque o $pedido1 e o $pedido2 continuam guardados
// no SplObjectStorage acima, e enquanto alguém segura o objeto, ele não deixa de existir.
$pedido3 = new Pedido('P003');
$pedido4 = new Pedido('P004');

$anotacoes = new WeakMap();
$anotacoes[$pedido3] = 'Cliente pediu entrega rápida';
$anotacoes[$pedido4] = 'Embalar para presente';

echo 'Anotações antes: ' . count($anotacoes) . "\n"; // 2

unset($pedido4); // ninguém mais segura o P004, então ele deixa de existir

echo 'Anotações depois: ' . count($anotacoes) . "\n"; // 1 (a entrada do P004 sumiu sozinha)