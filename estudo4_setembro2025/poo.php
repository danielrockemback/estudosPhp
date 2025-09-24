<?php

/**
 *  OOP: Construtor de classe, Objeto, Autoload, Visibilidade, Construtor/Destrutor, Class Inheritance, Final, Classes e Métodos abstratos
 *
 *  O autoload carrega automaticamente classes quando elas são usadas, sem precisar de require ou include manual. Nós usamos o composer
 *
 *  Visibilidade dos métodos e atributos
 *  public: acessível de qualquer lugar.
 *  protected: acessível apenas na classe e subclasses (herança).
 *  private: acessível apenas dentro da própria classe.
 */

require_once 'AbstractVeiculo.php';

use estudo4_setembro2025\AbstractVeiculo;

// A Classe CaminhaoCacamba está estendendo (herdando) da classe abstrata AbstractVeiculo
// final em uma classe impede que ela seja herdada.
final class CaminhaoCacamba extends AbstractVeiculo {

    private ?DateTime $ultimaManutencao;
    private ?DateTime $dataInicioViagem = null;
    private ?DateTime $dataTerminoViagem = null;

    /** Método construdor da classe
     *
     * @param string $anoFabricacao
     * @param string $placa
     * @param float $capacidadeTanque
     * @param bool $ativo
     * @param bool $cacamba
     * @param float $capacidadeCarga
     * @param int $idMotoristaResponsavel
     * @param null|DateTime $ultimaManutencao
     * @param null|DateTime $dataInicioViagem
     * @param null|DateTime $dataTerminoViagem
     */

    // inicializa o objeto no método construtor
    public function __construct(
        string $anoFabricacao,
        string $placa,
        float $capacidadeTanque,
        bool $ativo,
        bool $cacamba,
        float $capacidadeCarga,
        int $idMotoristaResponsavel,
        ?DateTime $ultimaManutencao ,
    )
    {
        // Método construtor da classe abstrata
        parent::__construct($anoFabricacao, $placa, $capacidadeTanque, $ativo, $cacamba, $capacidadeCarga, $idMotoristaResponsavel);

        $this->ultimaManutencao = $ultimaManutencao;
        $this->dataInicioViagem = $ultimaManutencao;
        $this->dataTerminoViagem = $ultimaManutencao;
    }

    // Método mágico __get é chamado quando você tenta acessar uma propriedade que não existe ou é privada.
    public function __get(string $propriedade): bool
    {
        if (!property_exists($this, $propriedade)) {
            echo "A propriedade {$propriedade} não existe nesse classe." . PHP_EOL;
            return false;
        }

        return true;
    }

    // Método mágico __call é chamado quando você tenta tenta chamar um método que não existe.
    public function __call($metodo, $args) {
        echo "Método '$metodo' não existe." . PHP_EOL;
    }


    // Método mágico __toString é chamado quando o objeto é chamado como string.
    public function __toString(): string {
        return "Identificação do motorista responsável: $this->idMotoristaResponsavel" . PHP_EOL;
    }


    // Método mágico __invoke é chamado quando o objeto é invocado, pode ter ou não argumentos.
    public function __invoke() {
        echo "A viagem vai ser iniciada {$this->getDataInicioViagem()->format('d-m-Y-H-i-s')}" . PHP_EOL;
    }


    // Método mágico __clone é chamado quando o objeto é invocado, pode ter ou não argumentos.
    public function __clone() {
        $this->capacidadeCarga += 555;
    }


    /**
     * @return DateTime|null
     */
    public function getUltimaManutencao(): ?DateTime
    {
        return $this->ultimaManutencao;
    }

    /**
     * @param DateTime|null $ultimaManutencao
     */
    public function setUltimaManutencao(?DateTime $ultimaManutencao): void
    {
        $this->ultimaManutencao = $ultimaManutencao;
    }

    public function iniciarViagem(): void
    {
        $this->setDataInicioViagem(new DateTime());
    }

    /**
     * @throws DateMalformedStringException
     */
    public function encerrarViagem(): void
    {
        $this->setDataTerminoViagem((new DateTime())->modify('+3 days'));
        echo "A viagem foi iniciada no dia {$this->getDataInicioViagem()->format('d/m/Y')} e foi finalizada ás {$this->getDataTerminoViagem()->format('d/m/Y')}" . PHP_EOL;
    }

    /**
     * @return DateTime|null
     */
    public function getDataInicioViagem(): ?DateTime
    {
        return $this->dataInicioViagem;
    }

    /**
     * @param DateTime|null $dataInicioViagem
     */
    private function setDataInicioViagem(?DateTime $dataInicioViagem): void
    {
        $this->dataInicioViagem = $dataInicioViagem;
    }

    /**
     * @return DateTime|null
     */
    public function getDataTerminoViagem(): ?DateTime
    {
        return $this->dataTerminoViagem;
    }

    /**
     * @param DateTime|null $dataTerminoViagem
     */
    private function setDataTerminoViagem(?DateTime $dataTerminoViagem): void
    {
        $this->dataTerminoViagem = $dataTerminoViagem;
    }

    public function getIdMotoristaResponsavel(): int
    {
        return $this->idMotoristaResponsavel;
    }


    public static function calculaDiasEntrega($inicio, $fim)
    {
        $resultado = $inicio->diff($fim);
        return $resultado->days;
    }


}

// stdClass é uma classe genérica
$stdClassVeiculo = new stdClass();
$stdClassVeiculo->anoFabricacao = '2020';
$stdClassVeiculo->placa = 'ABC123';
$stdClassVeiculo->capacidadeTanque = 800;
$stdClassVeiculo->capacidadeCarga = 4000;
$stdClassVeiculo->idMotoristaResponsavel = 320;
$stdClassVeiculo->ultimaManutencao = new DateTime();
$stdClassVeiculo->ativo = true;
$stdClassVeiculo->cacamba = true;

// Objeto da Classe CaminhaoCacamba que herda de AbstractVeiculo
$caminhaoCacamba = new CaminhaoCacamba(
    $stdClassVeiculo->anoFabricacao,
    $stdClassVeiculo->placa,
    $stdClassVeiculo->capacidadeTanque,
    $stdClassVeiculo->ativo,
    $stdClassVeiculo->cacamba,
    $stdClassVeiculo->capacidadeCarga,
    $stdClassVeiculo->idMotoristaResponsavel,
    $stdClassVeiculo->ultimaManutencao
);

$caminhaoCacamba->iniciarViagem();
$caminhaoCacamba->encerrarViagem();

$caminhaoCacamba->teste;
$caminhaoCacamba->kilometragem();
echo $caminhaoCacamba;
$caminhaoCacamba();

$cacamba = clone $caminhaoCacamba;
echo "Nova carga máxima do clone {$cacamba->getCapacidadeCarga()}" . PHP_EOL;

// Comparação de objetos

class Produto {
    public string $nome;
    public function __construct(string $nome) {
        $this->nome = $nome;
    }
}

$p1 = new Produto("Cimento");
$p2 = new Produto("Cimento");
$p3 = $p1;

var_dump($p1 == $p2);  // true  mesmo valores
var_dump($p1 === $p2); // false ocupam lugares diferentes na memória
var_dump($p1 === $p3); // true ocupam o mesmo lugar na memória

echo "Início - {$caminhaoCacamba->getDataInicioViagem()->format('d-m-Y')} - Fim {$caminhaoCacamba->getDataTerminoViagem()->format('d-m-Y')}" . PHP_EOL;
// Método static
var_dump(CaminhaoCacamba::calculaDiasEntrega($caminhaoCacamba->getDataInicioViagem(), $caminhaoCacamba->getDataTerminoViagem())) . PHP_EOL;;