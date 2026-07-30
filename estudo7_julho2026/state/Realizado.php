<?php

namespace App;

use App\Interfaces\EstadoPedidoInterface;

class Realizado implements EstadoPedidoInterface
{

    public function preparar(Pedido $pedido): void
    {
        // Lógica encapsulada para preparar o pedido

        // Depois que estiver preparado a classe vai alterar para o pŕoximo estado ***DO PEDIDO*** que vai se Preparando
        $pedido->setEstado(new Preparando());
    }

    public function iniciarEntrega(Pedido $pedido): void
    {
        throw new \DomainException('O pedido ainda não foi preparado');
    }

    public function finalizarEntrega(Pedido $pedido): void
    {
        throw new \DomainException('O pedido ainda não foi preparado');
    }
}