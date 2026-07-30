<?php

use App\Pedido;

require __DIR__ . '/Interfaces/EstadoPedidoInterface.php';
require __DIR__ . '/Realizado.php';
require __DIR__ . '/Preparando.php';
require __DIR__ . '/EntregaIniciada.php';
require __DIR__ . '/EntregaFinalizada.php';
require __DIR__ . '/Pedido.php';

/**
 * O construtor recebe por injeção de dependência qualquer classe que implemente a
 * EstadoPedidoInterface. Como aqui não passamos nada, vale o default do construtor,
 * que é o estado inicial Realizado.
 */
$pedido = new Pedido();

/**
 * O Pedido só delega para $this->estado. Neste momento o estado é Realizado, então
 * quem executa é Realizado::preparar() que encapsula a lógica de preparação e ao
 * terminar decide sozinho que o próximo estado é Preparando.
 */
$pedido->preparar();          // Realizado -> Preparando

/**
 * Mesma chamada delegada, mas o estado agora é Preparando, então quem responde é
 * Preparando::iniciarEntrega().
 */
$pedido->iniciarEntrega();    // Preparando -> EntregaIniciada

/**
 * Agora o estado é EntregaIniciada ou seja, a entrega já está em curso. Por isso é o finalizarEntrega() que avança daqui
 */
$pedido->finalizarEntrega();  // EntregaIniciada -> EntregaFinalizada

/**
 * A mágica acontece Pedido->EstadoAtual->SetEstado voltar para o Pedido e fazer o mesmo passo até zerar o passo a passo
 */

// Exemplo de chamar o pedido depois que ele foi finalizado, vai cair o catch e mostrar um erro
try {
    $pedido->preparar();

} catch (\DomainException $e) {
    echo $e->getMessage() . PHP_EOL;
}
