<?php

/**
 * Observer é um padrão comportamental usado quando um objeto precisa avisar
 * vários outros objetos (Observers/Observadores) toda vez que algo mudar nele, sem precisar
 * conhecer quem são esses observadores e após emitir esse evento cada observador decide o que fazer
 * com a informação.
 * O objeto só sabe que existe uma lista de observadores que implementam uma interface comum,
 * e chama o metodo notificar() de cada um avisado que houve um alteração. Quem decide o que fazer com essa notificação é
 * responsabilidade de cada Observer, o Subject não sabe e não precisa saber. O problema que o Observer resolve é
 * acoplamento excessivo entre um objeto e tudo o que depende dele
 * 
 * SUBJECT = CLASSE QUE VAI SER OBSERVADA PELAS OUTRAS, NESSE CASO A CLASSE PEDIDO
 */

// Interface que todo observador precisa implementar e assim o Subject vai saber quem deve ser notificado
interface ObservadorInterface
{
    public function notificar(string $status): void;
}

/**
 * Interface do Subject (o "observado"). Define o contrato mínimo:
 * anexar um observador e notificar todo mundo
 */
interface NotificavelInterface
{
    public function anexar(Observador $observador): void;
    public function notificarTodos(): void;
}

/**
 * Classe concreta que representa o objeto observado (o Pedido).
 * Ela guarda a lista de observadores e dispara a notificação quando o status muda
 */
class Pedido implements NotificavelInterface
{
    // Array que guarda todos os observadores que vão estcutar sobre a mudança do pedido
    private array $observadores = [];

    // Ao criar um pedido setamos o status como pendente
    private string $status = 'pendente';

    public function __construct(private readonly int $id) {}


    // Adiciona um novo observador na lista, sem o Pedido saber o que esse observador faz
    public function anexar(ObservadorInterface $observador): void
    {
        $this->observadores[] = $observador;
    }

    // Aqui é onde tudo acontece, nós vamos percorrer a lista de observadores e notificar sobre a mudança
    // e cada classe que for notificada escolhe o que fazer com a informação recebida
    public function notificarTodos(): void
    {
        foreach ($this->observadores as $observador) {
            $observador->notificar($this->status);
        }
    }

    // Método que muda o status do pedido e dispara a notificação automaticamente, se não tiver mudança de status
    // então ele não disparada nenhuma notificação
    public function mudarStatus(string $novoStatus): void
    {
        if ($novoStatus !== $this->status) {
            $this->status = $novoStatus;

        echo "Pedido {$this->id} mudou para: {$novoStatus}" . PHP_EOL;

        // Assim que o status muda, avisa todo mundo que está observando
        $this->notificarTodos();
        }     
    }
}

// Observador 1: manda um email
class EmailObservador implements ObservadorInterface
{
    public function notificar(string $status): void
    {
        echo "-> Email enviado: o status do pedido agora é '{$status}'" . PHP_EOL;
    }
}

// Observador 2: atualiza o "estoque" se o pedido for aprovado
class EstoqueObservador implements ObservadorInterface
{
    public function notificar(string $status): void
    {
        if ($status === 'aprovado') {
            echo "-> Estoque atualizado: itens do pedido foram reservados" . PHP_EOL;
        }
    }
}

// Observador concreto 3: gera um "log" de auditoria
class LogObservador implements ObservadorInterface
{
    public function notificar(string $status): void
    {
        echo "-> Log registrado: status alterado para '{$status}' em " . date('H:i:s') . PHP_EOL;
    }
}

// Cria o pedido 
$pedido = new Pedido(id: 501);


// adiciona os observadores que queremos que reajam a mudanças do pedido
$pedido->anexar(new EmailObservador());
$pedido->anexar(new EstoqueObservador());
$pedido->anexar(new LogObservador());

// Ao mudar o status o Pedido, nós verificamos se o status é diferente do status atual
// se for diferente ai sim chamamos notificarTodos() e cada observador reage do seu próprio jeito
// sem o Pedido saber o que cada um faz por dentro
$pedido->mudarStatus('aprovado');

echo PHP_EOL;

// Se mudar de novo, todos os observadores já anexados reagem de novo automaticamente
$pedido->mudarStatus('cancelado');

/** Esqueleto do padrão:
 * A estrutura utilizada deve ser 2 interfaces criadas sendo elas: Quem vai notificar deve ter
 * o metodo de adicionar os observadores e um metodo de notificar todos os observadores. A outra
 * interface a ser criada deve ser a Observador e implementada pela classes observadoras e ter o
 * metodo notificar.
 * A mágica acontece quando nós mudamos o status do pedido e dentro do metodo verificamos se houve
 * realmente alguma mudança no status, se sim chamamos o notificarTodos que vai iterar sobre
 * todos os observadores e chamar o metodo notificar e vamos passar o novo status do pedido para 
 * eles como argumento e eles decidem o que fazer
 */
