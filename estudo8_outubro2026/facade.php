<?php

/**
 * PADRÃO ESTRUTURAL: FACADE
 *
 * Serve pra criar uma porta de entrada simples pra um processo que envolve várias classes. Aqui a venda precisa
 * reservar estoque, cobrar, emitir nota fiscal e avisar o cliente, nessa ordem.
 *
 * A VendaFacade coordena: sabe o que chamar e em qual ordem, porém não sabe como cada classe faz esse processo, ela só manda fazer.
 * Cada classe injetada no construtor executa: sabe como fazer a sua parte.
 *
 */



final class Estoque
{
    public function reservar(string $produto, int $quantidade): void
    {
        echo "Estoque: {$quantidade} x {$produto} reservado\n";
    }
}

final class Pagamento
{
    public function cobrar(float $valor): void
    {
        echo "Pagamento: R$ {$valor} aprovado\n";
    }
}

final class NotaFiscal
{
    public function emitir(string $produto, float $valor): void
    {
        echo "Nota fiscal emitida: {$produto} R$ {$valor}\n";
    }
}

final class Notificador
{
    public function enviar(string $email, string $mensagem): void
    {
        echo "E-mail para {$email}: {$mensagem}\n";
    }
}


final class VendaFacade
{
    public function __construct(
        private Estoque $estoque,
        private Pagamento $pagamento,
        private NotaFiscal $notaFiscal,
        private Notificador $notificador,
    ) {}

    public function finalizar(string $produto, int $quantidade, float $precoUnitario, string $email): void
    {
        $total = $quantidade * $precoUnitario;

        $this->estoque->reservar($produto, $quantidade);
        $this->pagamento->cobrar($total);
        $this->notaFiscal->emitir($produto, $total);
        $this->notificador->enviar($email, 'Sua compra foi confirmada!');
    }
}


// Código cliente é uma controller nesse caso

$venda = new VendaFacade(new Estoque(), new Pagamento(), new NotaFiscal(), new Notificador());

$venda->finalizar('Caderno', 2, 15.00, 'danielborges@grupocoqueiro.com');