<?php

/**
Chain of Responsibility é um padrão usado para evitar if/else/switch, a intenção é montar uma cadeia de handlers para
executar uma requisição e se por acaso não for atendida ele pula para próxmo elo da cadeia.
 */



/**
 * Aqui vamos criar uma interface para ser implementada na nossa classe abstrata que vai ser a base do encadeamento
 */
interface AprovadorDespesaInterface
{
    public function processar(float $valor): string;
}

/**
 * Vamos usar uma classe abstrata que implementa a nossa interface e dentro da classe nós vamos centralizar quano resolver
 * ou delegar
 */
abstract class AprovadorBaseAbstrata implements AprovadorDespesaInterface
{
    // Aqui no construtor da classe abstrata nós vamos passar o próximo objeto a ser encadeado via injeção de dependência
    // e se não for passado nenhum argumento no parâmetro isso define o fim do encadeameto
    public function __construct(
        protected readonly ?AprovadorDespesaInterface $proximo = null
    ) {
    }

    public function processar(float $valor): string
    {
        if ($this->podeAprovar($valor)) {
            return $this->aprovar($valor);
        }

        return $this->proximo?->processar($valor) ?? "Nenhum aprovador disponível para R$ {$valor}" . PHP_EOL;
    }

    abstract protected function podeAprovar(float $valor): bool;
    abstract protected function aprovar(float $valor): string;
}

class Gestor extends AprovadorBaseAbstrata
{
    protected function podeAprovar(float $valor): bool
    {
        return $valor <= 5000;
    }

    protected function aprovar(float $valor): string
    {
        return "Gestor aprovou R$ {$valor}" . PHP_EOL;
    }
}

class Gerente extends AprovadorBaseAbstrata
{
    protected function podeAprovar(float $valor): bool
    {
        return $valor <= 1000;
    }

    protected function aprovar(float $valor): string
    {
        return "Gerente aprovou R$ {$valor}"  . PHP_EOL;
    }
}

class Diretor extends AprovadorBaseAbstrata
{
    protected function podeAprovar(float $valor): bool
    {
        return $valor <= 15000;
    }

    protected function aprovar(float $valor): string
    {
        return "Diretor aprovou R$ {$valor}" . PHP_EOL;
    }
}

// Montagem da cadeia por injeção de dependencia cada aprovador recebe o próximo já pronto
// Gerente é a entrada da cadeia e o fluxo vai ser Gerente -> Gestor -> Diretor
// Para adicionar um CEO/DONO no fim é só criar a classe e passar no  construtor da classe Diretor: new Diretor(new Ceo())
$cadeia = new Gerente(
    new Gestor(
        new Diretor(
            // New Ceo() ou New Dono por exemplo
        )
    )
);

// o último valor não é atendido por ninguém e cai no fim da cadeia e vai cair no Nenhum aprovador disponível para R$ {$valor}"
$valores = [800, 3000, 12000, 50000];

foreach ($valores as $valor) {
    // a primeira chamada de cadeia vai ser o Gerente e vamos chamar o processar e dentro do processar vamos chamar o
    // podeAprovar e se retornar true ele chama o método aprovar e assim acaba o encadeamento, mas se não atender nós vamos
    // para a próxima verificação
    echo $cadeia->processar($valor);
}
