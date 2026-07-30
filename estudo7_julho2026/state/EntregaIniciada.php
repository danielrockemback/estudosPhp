<?php

namespace App;

use App\Interfaces\EstadoPedidoInterface;

class EntregaIniciada implements EstadoPedidoInterface
{

    public function preparar(Pedido $pedido): void
    {
        throw new \DomainException('O pedido já foi preparado');
    }

    public function iniciarEntrega(Pedido $pedido): void
    {
        throw new \DomainException('O pedido já saiu para entrega');
    }

    public function finalizarEntrega(Pedido $pedido): void
    {
        // Lógica encapsulada para concluir a entrega (baixa no sistema, notificar o cliente...)

        // Concluída a entrega, este estado sabe que o próximo é EntregaFinalizada
        $pedido->setEstado(new EntregaFinalizada());
    }
}