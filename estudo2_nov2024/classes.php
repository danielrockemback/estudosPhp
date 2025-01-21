<?php

namespace classeNameSpace;

class Pessoa{

    public $nome;
    public $dataNascimento;
    public $sexo;
    private $cpf;

    public function __construct($nome, $dataNascimento, $sexo, $cpf){

        $this->nome = $nome;
        $this->dataNascimento = $dataNascimento;
        $this->sexo = $sexo;
        $this->cpf = $cpf;
    }
    public function getNome(){
        return $this->nome;
    }

    public function getCpf(){
        return $this->cpf;
    }
}

class Cliente extends Pessoa{
    private $enderecoCliente;
    private $telefone;

    public function __construct($nome, $dataNascimento, $sexo, $cpf, $enderecoCliente, $telefone){
        parent::__construct($nome, $dataNascimento, $sexo, $cpf);
        $this->enderecoCliente = $enderecoCliente;
        $this->telefone = $telefone;
    }

    public function getEnderecoCliente(){
        return $this->enderecoCliente;
    }

    public function getTelefone(){
        return $this->telefone;
    }
}

class Funcionario extends Pessoa{

    private $codigoFuncionario;
    private $horarioFuncionario;
    public function __construct($nome, $dataNascimento, $sexo, $cpf, $codigoFuncionario, $horarioFuncionario){
        parent::__construct($nome, $dataNascimento, $sexo, $cpf);
        $this->codigoFuncionario = $codigoFuncionario;
        $this->horarioFuncionario = $horarioFuncionario;
    }

    public function getHorarioFuncionario(){
        return $this->horarioFuncionario;
    }

    public function setHorarioFuncionario($novoHorarioFuncionario){
        $this->horarioFuncionario = $novoHorarioFuncionario;
    }
}
