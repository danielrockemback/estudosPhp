<?php

/**
 * O padrão de projeto Abstract Factory é usado para garantir que objetos que precisam trabalhar juntos sejam sempre
 * criados juntos na mesma família, assim garantindo que regras de negócios diferentes não se misturem. Isso também
 * garante um código desacoplado e se por acaso a gente quiser criar outro banco a gente só precisa fazer as implementações
 * igual ao do Itau e Bradesco
 */


// As duas interfaces vão ser nosso AbstractProducts que quem implementar vai ter que criar o método
interface CalculadoraDigitoInterface
{
    public function calcular(string $nossoNumero): int;
}

interface GeradorRemessaInterface
{
    public function gerar(array $boletos): string;
}


// ConcreteProducts: cada classe concreta implementa uma das interfaces acima. As classes do mesmo banco formam uma
// família, agrupadas pela fábrica. Itaú e Bradesco seguem o mesmo contrato, mas cada um tem sua própria regra de
// cálculo e seu próprio layout de remessa.

final class ItauCalculadoraDigito implements CalculadoraDigitoInterface
{
    public function calcular(string $nossoNumero): int
    {
        return 7; // Módulo 10 do Itaú (simplificado para o exemplo)
    }
}

final class ItauGeradorRemessa implements GeradorRemessaInterface
{
    public function gerar(array $boletos): string
    {
        return "Remessa no layout Itaú com " . count($boletos) . " boletos";
    }
}


// ConcreteProducts: família Bradesco

final class BradescoCalculadoraDigito implements CalculadoraDigitoInterface
{
    public function calcular(string $nossoNumero): int
    {
        return 3; // Módulo 11 do Bradesco (simplificado para o exemplo)
    }
}

final class BradescoGeradorRemessa implements GeradorRemessaInterface
{
    public function gerar(array $boletos): string
    {
        return "Remessa no layout Bradesco com " . count($boletos) . " boletos";
    }
}


// AbstractFactory: Como Itau e Bradesco são bancos, aqui a gente cria uma interface com os métodos que retornam
// a classe para executar o processo. Aqui é parecido com o padrão factory method que vai devolver um objeto criado
interface BancoFactoryInterface
{
    public function criarCalculadoraDigito(): CalculadoraDigitoInterface;

    public function criarGeradorRemessa(): GeradorRemessaInterface;
}


// ConcreteFactories: uma por família que vai saber qual classe deve retornar pra executar o processo

final class ItauFactory implements BancoFactoryInterface
{
    public function criarCalculadoraDigito(): CalculadoraDigitoInterface
    {
        return new ItauCalculadoraDigito();
    }

    public function criarGeradorRemessa(): GeradorRemessaInterface
    {
        return new ItauGeradorRemessa();
    }
}

final class BradescoFactory implements BancoFactoryInterface
{
    public function criarCalculadoraDigito(): CalculadoraDigitoInterface
    {
        return new BradescoCalculadoraDigito();
    }

    public function criarGeradorRemessa(): GeradorRemessaInterface
    {
        return new BradescoGeradorRemessa();
    }
}


// Aqui vamos ter uma classe de serviço que é composta por alguma classe concreta que implementa a interface BancoFactoryInterface
// O emitir é fixo e o comportamento dos processos muda de acordo com a fábrica que foi passada como argumento

final class ServicoCobranca
{
    public function __construct(private BancoFactoryInterface $banco)
    {
    }

    public function emitir(array $boletos): string
    {
        // chamando o método do banco criarCalculadoraDigito que vai retornar um objeto
        $calculadora = $this->banco->criarCalculadoraDigito();

        foreach ($boletos as &$boleto) {
            // chamando o método calcular do objeto calculadora
            $boleto['dv'] = $calculadora->calcular($boleto['nossoNumero']);
        }
        unset($boleto);

        // gerando a remessa de acordo com a fábrica passada
        return $this->banco->criarGeradorRemessa()->gerar($boletos);
    }
}


// Código cliente

$boletos = [
    ['nossoNumero' => '12345678'],
    ['nossoNumero' => '87654321'],
];

$servico = new ServicoCobranca(new ItauFactory());
echo $servico->emitir($boletos); // Remessa no layout Itaú com 2 boletos