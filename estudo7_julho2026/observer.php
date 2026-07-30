<?php

/**
 * Observer é um padrão comportamental usado quando um objeto (o Subject/Sujeito) precisa avisar
 * vários outros objetos (os Observers/Observadores) toda vez que algo mudar nele, sem precisar
 * conhecer quem são esses observadores especificamente.
 *
 * O Subject só sabe que existe uma lista de "observadores" que implementam uma interface comum,
 * e chama o método notificar() de cada um. Quem decide o que fazer com essa notificação é
 * responsabilidade de cada Observer, o Subject não sabe e não precisa saber.
 *
 * Exemplo clássico: um pedido muda de status (pendente -> aprovado), e vários serviços precisam
 * reagir a isso (enviar email, gerar nota fiscal, notificar o estoque), sem o Pedido precisar
 * conhecer o EmailService, o EstoqueService, etc.
 */

// Interface que todo observador precisa implementar, assim o Subject sabe chamar todos do mesmo jeito
interface Observador
{
    public function notificar(string $status): void;
}

/**
 * Interface do Subject (o "observado"). Define o contrato mínimo:
 * anexar um observador, remover um observador e notificar todo mundo
 */
interface Notificavel
{
    public function anexar(Observador $observador): void;
    public function notificarTodos(): void;
}

/**
 * Classe concreta que representa o objeto observado (o Pedido).
 * Ela guarda a lista de observadores e dispara a notificação quando o status muda
 */
class Pedido implements Notificavel
{
    // Array que guarda todos os observadores anexados a esse pedido
    private array $observadores = [];

    private string $status = 'pendente';

    public function __construct(private readonly int $id)
    {
    }

    // Adiciona um novo observador na lista, sem o Pedido saber o que esse observador faz
    public function anexar(Observador $observador): void
    {
        $this->observadores[] = $observador;
    }

    // Percorre todos os observadores anexados e chama o método notificar() de cada um
    public function notificarTodos(): void
    {
        foreach ($this->observadores as $observador) {
            $observador->notificar($this->status);
        }
    }

    // Método que muda o status do pedido e dispara a notificação automaticamente
    public function mudarStatus(string $novoStatus): void
    {
        $this->status = $novoStatus;
        echo "Pedido {$this->id} mudou para: {$novoStatus}" . PHP_EOL;

        // Assim que o status muda, avisa todo mundo que está observando
        $this->notificarTodos();
    }
}

// Observador concreto 1: manda um "email" (só simulando com echo)
class EmailObservador implements Observador
{
    public function notificar(string $status): void
    {
        echo "-> Email enviado: o status do pedido agora é '{$status}'" . PHP_EOL;
    }
}

// Observador concreto 2: atualiza o "estoque" (só simulando com echo)
class EstoqueObservador implements Observador
{
    public function notificar(string $status): void
    {
        if ($status === 'aprovado') {
            echo "-> Estoque atualizado: itens do pedido foram reservados" . PHP_EOL;
        }
    }
}

// Observador concreto 3: gera um "log" de auditoria (só simulando com echo)
class LogObservador implements Observador
{
    public function notificar(string $status): void
    {
        echo "-> Log registrado: status alterado para '{$status}' em " . date('H:i:s') . PHP_EOL;
    }
}

// Montagem: cria o pedido e anexa os observadores que queremos que reajam a mudanças nele
$pedido = new Pedido(id: 501);

$pedido->anexar(new EmailObservador());
$pedido->anexar(new EstoqueObservador());
$pedido->anexar(new LogObservador());

// Ao mudar o status, o Pedido chama notificarTodos() sozinho (veja dentro de mudarStatus())
// e cada observador reage do seu próprio jeito, sem o Pedido saber o que cada um faz por dentro
$pedido->mudarStatus('aprovado');

echo PHP_EOL;

// Se mudar de novo, todos os observadores já anexados reagem de novo automaticamente
$pedido->mudarStatus('cancelado');
