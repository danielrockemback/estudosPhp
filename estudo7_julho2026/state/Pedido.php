<?php

namespace App;

use App\Interfaces\EstadoPedidoInterface;

/**
 * Contexto do padrão State.
 *
 * O Pedido não sabe e não deve saber qual classe concreta está em $estado: ele só
 * conhece o EstadoPedidoInterface e delega a chamada. É esse desconhecimento que substitui o
 * if/switch em cima de um campo "status" e permite adicionar um estado novo um Cancelado por exemplo sem tocar nesta classe.
 */
class Pedido
{
    public function __construct(
        private EstadoPedidoInterface $estado = new Realizado()
    ) {
    }

    public function setEstado(EstadoPedidoInterface $estado): void
    {
        $this->estado = $estado;
    }

    public function preparar(): void
    {
        // Delega para o estado atual, qualquer que seja ele, e passa o próprio pedido
        // como argumento para que o estado possa chamar setEstado() de volta
        $this->estado->preparar($this);
    }

    public function iniciarEntrega(): void
    {
        $this->estado->iniciarEntrega($this);
    }

    public function finalizarEntrega(): void
    {
        $this->estado->finalizarEntrega($this);
    }
}