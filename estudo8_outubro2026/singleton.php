<?php

/**
 * PADRÃO CRIACIONAL: SINGLETON
 *
 * O objetivo desse padrão é garantir que uma classe tenha apenas uma única instância e fornece um ponto de acesso global
 * a esse instância
 */


final class Configuracao
{
    private static ?Configuracao $instancia = null;
    private array $valores;

    // Construtor privado: ninguém de fora consegue dar new, é importante ser private para que somente a pŕopria classe
    // possa criar uma instancia getInstancia ou devolver a instancia que já foi criada
    private function __construct()
    {
        echo "Carregando configuração...\n";

        $this->valores = [
            'banco'    => 'sqlsrv',
            'timezone' => 'America/Sao_Paulo',
        ];
    }

    // Ponto de acesso: cria na primeira vez, devolve a mesma nas próximas
    public static function getInstancia(): self
    {
        // Operador de atribuição de coalescência nula: se $instancia já tem valor, retorna esse valor. Se for null,
        // cria a instância com new self(), atribui em $instancia e retorna.
        return self::$instancia ??= new self();
    }

    public function get(string $chave): mixed
    {
        return $this->valores[$chave] ?? null;
    }

    // Como o __clone está como private, então ninguém fora dessa classe pode chamar o __clone
    private function __clone() {}

    // Bloqueia a desserialização. O unserialize() cria um objeto novo SEM passar pelo construtor, então furaria
    // o construtor privado. O PHP chama o __wakeup() logo após desserializar, e a exceção impede a nova instância.
    public function __wakeup(): void
    {
        throw new LogicException('Não é permitido desserializar um Singleton.');
    }
}


// Código cliente

// Criando a instancia da classe de Configuracao
$config1 = Configuracao::getInstancia();

// Pedindo a instância novamente. Como ela já existe, o getInstancia() devolve a mesma.
$config2 = Configuracao::getInstancia();

var_dump($config1 === $config2);          // true
echo $config1->get('timezone');           // America/Sao_Paulo