<?php

require_once 'classes.php';

#   NameSpace\Nome da Classe
use classeNameSpace\Cliente;
use classeNameSpace\Funcionario;

#use classes\Produto as classeProduto;

$quebraLinha = str_repeat("=", 50) . PHP_EOL;

$bool1 = true;      # true representa verdadeiro
$bool2 = false;     # false representa falso

$n1 = 10;       # número inteiro positivo ou negativo
$n2 = -5.5;     # número float/double positivo ou negativo
$nome = 'Maria';    # string é uma sequência de caracteres

$lista_composta = [1, 5.5, -10, 'PHP', true, false, null, []];  # array composto por vários tipos de dados

$dataNascimento = '1995-07-14';

# Array composta
$cadastro = [
    'nome' => 'Daniel',
    'numeroRegistro' => ['rg' => '931548365', 'cpf' => '023952105874'],
    'idade' => idade($dataNascimento),
];

function idade($dataNascimento) {
    $dataAtual = new DateTime();
    $nascimento = new DateTime($dataNascimento);
    $idade = $dataAtual->diff($nascimento);

    return $idade->y;
}

echo "Nome: {$cadastro['nome']}\nIdade: {$cadastro['idade']} anos\nRG: {$cadastro['numeroRegistro']['rg']}\nCPF: {$cadastro['numeroRegistro']['cpf']}" . PHP_EOL;

echo $quebraLinha;


$cliente = new Cliente('João', '22/11/1956', 'M', '02012214221', 'Paranoá', '9999-5555');
$funcionario = new Funcionario('Daniel', '14/07/1995', 'M', '05462176', 1111, '14:00-22:00');

echo $cliente->getTelefone() . PHP_EOL;
echo $funcionario->getHorarioFuncionario() . PHP_EOL;
echo $funcionario->setHorarioFuncionario('10:00-18:00');
echo $funcionario->getHorarioFuncionario() . PHP_EOL;

echo $quebraLinha;

#  Callable (Anonymous function/class/methods)); Special (Resource, Null);

# Função anônima
function ativaFuncao(callable $callback, $num) {
    return $callback($num);
}

function dobraValor($num){
    return $num * 2;
}
#            Callback             Callable
$resultado = ativaFuncao('dobraValor', 150);

var_dump($resultado);

# Classe Anônima

$triplicaValor = new class
{
    function triplicaValor($num)
    {
        return $num * 3;
    }
};

var_dump($triplicaValor->triplicaValor(15));

echo $quebraLinha;

# Special (Resource, Null);

# Resource abrindo o arquivo em modo leitura

$arquivo = fopen('/opt/apps/estudoPhp/Objetivos.txt', 'r');

if ($arquivo) {
    while (($linha = fgets($arquivo)) !== false) {
        echo $linha;
    }
    fclose($arquivo);
}

