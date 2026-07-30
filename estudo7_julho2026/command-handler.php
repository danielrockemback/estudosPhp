<?php

final class AprovarVendaCommand
{
    public function __construct(
        public readonly int $pedidoId,
        public readonly int $usuarioId,
        public readonly ?string $observacao = null
    ) {
    }

    public function getPedidoId(): int
    {
        return $this->pedidoId;
    }

    public function getUsuarioId(): int
    {
        return $this->usuarioId;
    }

    public function getObservacao(): ?string
    {
        return $this->observacao;
    }
}

final class AprovarVendaCommandHandler
{
    public function __construct(
        private readonly PedidoRepository $pedidoRepository,
        private readonly UsuarioRepository $usuarioRepository
    ) {
    }

    public function handle(AprovarVendaCommand $command): void
    {
        $pedido = $this->pedidoRepository->find($command->pedidoId);
        $usuario = $this->usuarioRepository->find($command->usuarioId);

        // regra de negócio de verdade
        $pedido->aprovar($usuario, $command->observacao);

        $this->pedidoRepository->save($pedido);
    }
}

class PedidoController
{
    public function aprovarVenda(Request $request)
    {
        $command = new AprovarVendaCommand(
            pedidoId: $request->get('pedido_id'),
            usuarioId: $request->get('usuario_id'),
            observacao: $request->get('observacao')
        );

        $handler = new AprovarVendaCommandHandler(
            new PedidoRepository(),
            new UsuarioRepository()
        );

        $handler->handle($command);

        return new Response('Venda aprovada com sucesso');
    }
}