<?php

/**
 * PADRÃO ESTRUTURAL: BRIDGE
 *
 * Serve pra separar duas coisas que variam juntas. Aqui é o tipo de notificação (comum, urgente) e o canal
 * (e-mail, SMS). Sem o Bridge eu teria que criar uma classe pra cada combinação (NotificacaoUrgenteSms,
 * NotificacaoComumEmail...).
 *
 * A notificação decide O QUE enviar e o canal decide COMO enviar. A ponte é o $canal dentro da Notificacao.
 *
 * Se eu quiser um canal novo (WhatsApp), crio só uma classe e ela já funciona com todas as notificações.
 */

interface CanalInterface
{
    public function enviar(string $destino, string $mensagem): string;
}


// Classe concreta que implementa a interface CanalInterface para que possamos enviar a partir desse canal
final class CanalEmail implements CanalInterface
{
    public function enviar(string $destino, string $mensagem): string
    {
        return "[E-mail para {$destino}] {$mensagem}";
    }
}

final class CanalSms implements CanalInterface
{
    public function enviar(string $destino, string $mensagem): string
    {
        return "[SMS para {$destino}] {$mensagem}";
    }
}



abstract class Notificacao
{
    // A PONTE: a abstração guarda uma referência para um objeto que implementa CanalInterface. A Notificacao não sabe
    // qual canal é (e-mail, SMS), só sabe que ele tem o método enviar(). O canal é escolhido no construtor.
    public function __construct(protected CanalInterface $canal) {}

    // Quem herdar essa classe implementa o notificar(). Cada tipo de notificação decide O QUE enviar (formato da
    // mensagem) e delega ao canal COMO enviar.
    abstract public function notificar(string $destino, string $texto): string;
}


// Classe concreta que herda da classe abstrata Notificacao que implementa o método notificar que faz a ligação do
// tipo de notificacao e o canal
final class NotificacaoComum extends Notificacao
{
    // Implementação do método notificar da classe Abstrata Notificacao e aqui estamos chamando o método enviar do canal
    // pq o canal deve saber como ele deve enviar
    public function notificar(string $destino, string $texto): string
    {
        return $this->canal->enviar($destino, $texto);
    }
}

final class NotificacaoUrgente extends Notificacao
{
    public function notificar(string $destino, string $texto): string
    {
        $texto =  mb_strtoupper($texto);
        $mensagem = "[URGENTE] {$texto} Responda o quanto antes.";

        return $this->canal->enviar($destino, $mensagem);
    }
}


// Código cliente

// O pulo do gato é a propriedade $canal na classe abstrata Notificacao: ela liga a hierarquia de notificações
// (o que enviar) à hierarquia de canais (como enviar). No código cliente escolhemos as duas peças livremente:
// NotificacaoUrgente com CanalSms, NotificacaoComum com CanalEmail, ou qualquer outra combinação.
// Ao chamar notificar(), a notificação monta a mensagem e chama internamente o enviar() do canal escolhido.

$urgentePorSms = new NotificacaoUrgente(new CanalSms());
echo $urgentePorSms->notificar('61999990000', 'Boleto vence hoje');

$comumPorEmail = new NotificacaoComum(new CanalEmail());
echo $comumPorEmail->notificar('cliente@email.com', 'Seu boleto foi gerado');
