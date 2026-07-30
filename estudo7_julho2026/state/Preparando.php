<?php

namespace App;

use App\Interfaces\EstadoPedidoInterface;

class Preparando implements EstadoPedidoInterface
{

    public function preparar(Pedido $pedido): void
    {
        throw new \DomainException('O pedido já está sendo preparado');
    }

    public function iniciarEntrega(Pedido $pedido): void
    {
        // Lógica encapsulada para despachar o pedido para entrega
        // (a preparação em si já rodou em Realizado::preparar)

        // Despachado o pedido, este estado sabe que o próximo é EntregaIniciada
        $pedido->setEstado(new EntregaIniciada());
    }

    public function finalizarEntrega(Pedido $pedido): void
    {
        throw new \DomainException('O pedido ainda não pode ser finalizado pois ainda está sendo preparado');
    }
}