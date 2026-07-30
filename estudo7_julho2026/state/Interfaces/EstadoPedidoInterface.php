<?php

namespace App\Interfaces;

use App\Pedido;

interface EstadoPedidoInterface
{
    public function preparar(Pedido $pedido): void;
    public function iniciarEntrega(Pedido $pedido): void;
    public function finalizarEntrega(Pedido $pedido): void;
}