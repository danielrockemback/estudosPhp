<?php

/*
 * O padrão Builder é um padrão criacional que permite você montar um objeto complexo parte a parte, isso é muito bom
 * para evitar um método construtor muito grande
 */

final class Boleto
{
    public function __construct(
        public readonly float $valor,
        public readonly DateTimeImmutable $vencimento,
        public readonly string $pagador,
        public readonly float $multa,
        public readonly float $juros,
        public readonly float $desconto,
        public readonly array $instrucoes,
    ) {}
}

final class BoletoBuilder
{
    private ?float $valor = null;
    private ?DateTimeImmutable $vencimento = null;
    private ?string $pagador = null;
    private float $multa = 0.0;
    private float $juros = 0.0;
    private float $desconto = 0.0;
    private array $instrucoes = [];

    public function valor(float $valor): static
    {
        $this->valor = $valor;
        return $this;
    }

    public function vencimento(DateTimeImmutable $vencimento): static
    {
        $this->vencimento = $vencimento;
        return $this;
    }

    public function pagador(string $pagador): static
    {
        $this->pagador = $pagador;
        return $this;
    }

    public function multa(float $percentual): static
    {
        $this->multa = $percentual;
        return $this;
    }

    public function juros(float $percentual): static
    {
        $this->juros = $percentual;
        return $this;
    }

    public function desconto(float $valor): static
    {
        $this->desconto = $valor;
        return $this;
    }

    public function instrucao(string $texto): static
    {
        $this->instrucoes[] = $texto;
        return $this;
    }

    public function build(): Boleto
    {
        if ($this->valor === null || $this->vencimento === null || $this->pagador === null) {
            throw new LogicException('Valor, vencimento e pagador são obrigatórios.');
        }

        if ($this->desconto >= $this->valor) {
            throw new LogicException('O desconto não pode ser maior ou igual ao valor.');
        }

        return new Boleto(
            $this->valor,
            $this->vencimento,
            $this->pagador,
            $this->multa,
            $this->juros,
            $this->desconto,
            $this->instrucoes,
        );
    }
}

// Cada método faz uma coisa e retorna a própria classe e assim a gente pode  ir encadear e o código fica mais legível
// podemos fazer do jeito abaixo ou pode ir fazer ao decorrer do código e quando o objeto builder estiver pronto, nós
// podemos chamar o método build() e vamos criar uma instância do Boleto a partir dos atributos passado no BoletoBuilder
$boleto = (new BoletoBuilder())
    ->valor(150.00)
    ->vencimento(new DateTimeImmutable('2026-11-10'))
    ->pagador('Daniel')
    ->multa(2.0)
    ->instrucao('Não receber após 30 dias do vencimento')
    ->build();

var_dump($boleto);