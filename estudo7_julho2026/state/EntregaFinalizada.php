<?php

namespace App;

use App\Interfaces\EstadoPedidoInterface;

/**
 * Estado terminal: o pedido já foi entregue, então não existe próximo estado.
 * Todos os métodos lançam exceção, pois qualquer transição a partir daqui é inválida.
 */
class EntregaFinalizada implements EstadoPedidoInterface
{

    public function preparar(Pedido $pedido): void
    {
        throw new \DomainException('O pedido já foi entregue para o cliente.');
    }

    public function iniciarEntrega(Pedido $pedido): void
    {
        throw new \DomainException('O pedido já foi entregue para o cliente.');
    }

    public function finalizarEntrega(Pedido $pedido): void
    {
        throw new \DomainException('O pedido já foi entregue para o cliente.');
    }
}