<?php

/**
 *  OOP: Construtor de classe, Objeto, Autoload, Visibilidade, Construtor/Destrutor, Class Inheritance, Final, Classes e Métodos abstratos,
 */

namespace estudo4_setembro2025;


// Uma classe abstrata não pode ser instanciada diretamente apenas herdada
abstract class AbstractVeiculo
{
    protected int $anoFabricacao;
    protected string $placa;
    protected float $capacidadeTanque;
    protected bool $ativo;
    protected bool $cacamba;
    protected float $capacidadeCarga;
    protected int $idMotoristaResponsavel;

    public function __construct(
        string $anoFabricacao,
        string $placa,
        float $capacidadeTanque,
        bool $ativo,
        bool $cacamba,
        float $capacidadeCarga,
        int $idMotoristaResponsavel
    )
    {
        $this->anoFabricacao = $anoFabricacao;
        $this->placa = $placa;
        $this->capacidadeTanque = $capacidadeTanque;
        $this->ativo = $ativo;
        $this->cacamba = $cacamba;
        $this->capacidadeCarga = $capacidadeCarga;
        $this->idMotoristaResponsavel = $idMotoristaResponsavel;
    }

    // Métodos abstratos devem ser implementados pelas subclasses contendo a mesma assinatura.
    abstract public function iniciarViagem(): void;
    abstract public function encerrarViagem(): void;

    // executa código quando o objeto não é mais utilizado no script
//    public function __destruct() {
//        echo "Destruindo a classe " . get_class($this) . "\n";
//    }

    /**
     * @return string
     */
    public function getPlaca(): string
    {
        return $this->placa;
    }

    /**
     * @param string $placa
     */
    public function setPlaca(string $placa): void
    {
        $this->placa = $placa;
    }

    /**
     * @return int
     */
    public function getAnoFabricacao(): int
    {
        return $this->anoFabricacao;
    }

    /**
     * @param int $anoFabricacao
     */
    public function setAnoFabricacao(int $anoFabricacao): void
    {
        $this->anoFabricacao = $anoFabricacao;
    }

    /**
     * @return float
     */
    public function getCapacidadeTanque(): float
    {
        return $this->capacidadeTanque;
    }

    /**
     * @param float $capacidadeTanque
     */
    public function setCapacidadeTanque(float $capacidadeTanque): void
    {
        $this->capacidadeTanque = $capacidadeTanque;
    }

    /**
     * @return bool
     */
    public function isAtivo(): bool
    {
        return $this->ativo;
    }

    /**
     * @param bool $ativo
     */
    public function setAtivo(bool $ativo): void
    {
        $this->ativo = $ativo;
    }

    /**
     * @return bool
     */
    public function isCacamba(): bool
    {
        return $this->cacamba;
    }

    /**
     * @param bool $cacamba
     */
    public function setCacamba(bool $cacamba): void
    {
        $this->cacamba = $cacamba;
    }

    /**
     * @return float
     */
    public function getCapacidadeCarga(): float
    {
        return $this->capacidadeCarga;
    }

    /**
     * @param float $capacidadeCarga
     */
    public function setCapacidadeCarga(float $capacidadeCarga): void
    {
        $this->capacidadeCarga = $capacidadeCarga;
    }

    /**
     * @return int
     */
    public function getIdMotoristaResponsavel(): int
    {
        return $this->idMotoristaResponsavel;
    }

    /**
     * @param int $idMotoristaResponsavel
     */
    public function setIdMotoristaResponsavel(int $idMotoristaResponsavel): void
    {
        $this->idMotoristaResponsavel = $idMotoristaResponsavel;
    }
}