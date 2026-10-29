<?php

/**
 * PADRÃO PROTOTYPE (Criacional)
 *
 * Serve para criar novos objetos copiando um objeto já existente (o modelo), em vez de montar do zero. Na cópia,
 * alteramos só o que muda. O clone do PHP é raso: primitivos ficam independentes, mas objetos internos continuam
 * compartilhados. Por isso usamos o __clone() para clonar os objetos internos mutáveis.
 *
 *
 * sem o __clone: Use quando os atributos forem dados primitivos
 * com o __clone: Se o atributo for mutável, então temos que usar o __clone para proteger tanto o objeto original quanto
 * o objeto clonado para que eles não compartilhem os objetos mutáveis
 */


final class BoletoMensalidade
{
    public function __construct(
        private string $pagador,
        private float $valor,
        private float $multa,
        private DateTimeImmutable $vencimento,
    ) {}

    // Clona a si mesmo e muda só o vencimento pq o restante dos atributos são iguais. Nesse exemplo não estamos usando
    // o __clone então o $vencimento faz referência, porém ele é imutável
    public function paraVencimento(DateTimeImmutable $vencimento): self
    {
        $copia = clone $this;
        $copia->vencimento = $vencimento;

        return $copia;
    }

    public function resumo(): string
    {
        return "{$this->pagador} | R$ {$this->valor} | vence em {$this->vencimento->format('d/m/Y')}";
    }
}


// Monta o modelo uma vez e abaixo vamos mudar somente um atributo para a geração do boleto
$modelo = new BoletoMensalidade('Daniel', 150.00, 2.0, new DateTimeImmutable('2026-11-10'));

// Gera os próximos 3 meses clonando
for ($mes = 0; $mes < 3; $mes++) {
    $boleto = $modelo->paraVencimento(new DateTimeImmutable("2026-11-10 +{$mes} month"));
    echo $boleto->resumo() . "\n";
}


// Objeto interno MUTÁVEL (por isso o boleto vai precisar do __clone)
final class Endereco
{
    public function __construct(private string $cidade)
    {
    }

    public function getCidade(): string
    {
        return $this->cidade;
    }

    public function setCidade(string $cidade): void
    {
        $this->cidade = $cidade;
    }
}


// O Prototype
final class BoletoMensalidadeComEndereco
{
    public function __construct(
        private string            $pagador,
        private float             $valor,
        private Endereco          $endereco,             // objeto mutável
        private DateTimeImmutable $vencimento,  // objeto imutável
    )
    {
    }

    // Roda após chamar o clone $this;
    public function __clone()
    {
        // Cria uma cópia do objeto Endereco do original (mesmos dados, mas outro objeto) para o clone,
        // assim alterar o endereço da cópia não afeta o original.
        $this->endereco = clone $this->endereco;
    }

    // Cria uma cópia e muda somente a data de vencimento da cópia
    public function paraVencimento(DateTimeImmutable $vencimento): self
    {
        /// Ao chamar clone $this, o PHP copia o objeto e executa o __clone() na cópia antes de devolvê-la
        $copia = clone $this;
        $copia->vencimento = $vencimento;

        return $copia;
    }

    public function mudarCidade(string $cidade): void
    {
        $this->endereco->setCidade($cidade);
    }

    public function getEndereco(): Endereco
    {
        return $this->endereco;
    }

    public function resumo(): string
    {
        return "{$this->pagador} | R$ {$this->valor} | {$this->endereco->getCidade()} | "
            . "vence em {$this->vencimento->format('d/m/Y')}";
    }
}


// Código cliente

$modelo = new BoletoMensalidadeComEndereco(
    'Daniel',
    150.00,
    new Endereco('Brasília'),
    new DateTimeImmutable('2026-11-10'),
);

// Ao chamar o paraVencimento, nós vamos clonar o objeto original e depois alterar o vencimento somente do clone e depois vamos
// retornar esse objeto clonado return $copia;
$dezembro = $modelo->paraVencimento(new DateTimeImmutable('2026-12-10'));

// Após passar pelo método __clone, a gente muda o endereço somente do clone e mantém o original do jeito que está
$dezembro->mudarCidade('Goiânia');

echo $modelo->resumo() . " OBJETO ORIGINAL" . "\n";
echo $dezembro->resumo() . " CÓPIA" . "\n";