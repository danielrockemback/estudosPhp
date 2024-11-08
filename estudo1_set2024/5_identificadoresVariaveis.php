<?php

// Identificadores: Variáveis em PHP
$quebraLinha = str_repeat("=", 50) . PHP_EOL;

$nome = "João";    // string
$id = 30;          // inteiro
$altura = 1.79;    // float
$ativo = true;     // boolean
$array = [];       // array

//  Acesso por valor

$a = 10;
$b = $a;
$b += 10;

echo "a = $a b = $b" . PHP_EOL;   // b recebe a, mas não faz referência e não altera o valor da variável a

echo $quebraLinha;

// Acesso por referência (&)

$kamisama = 'Vivo';
$piccolo = & $kamisama;  // Aqui o & indica que $piccolo está referenciando ao $kamisama e ambas as variáveis compartilham o mesmo valor na memória.

echo "Kamisama: $kamisama" . PHP_EOL;
echo "Piccolo: $piccolo" . PHP_EOL;

// Piccolo morreu para o Freeza
$piccolo = 'Morto';

echo "Kamisama: $kamisama" . PHP_EOL;
echo "Piccolo: $piccolo" . PHP_EOL;

echo $quebraLinha;

// Tipagem Dinâmica: o php é uma linguagem de tipagem dinâmica

$num = 10;
var_dump($num);

$num = '10';
var_dump($num);

$num = 10.0;
var_dump($num);

$num = true;
var_dump($num);

echo $quebraLinha;

// Funções de checagem: isset() e empty()
// isset() verifica se uma variável está definida e não é null. Se a variável existir e tiver algum valor (incluindo false, mas não null), retorna true. Caso contrário, retorna false.
// unset() Destrói uma variável, tornando-a indefinida. Após o uso de unset(), a variável não estará mais disponível no escopo.
// empty() verifica se a variável existe e está vazia, retorna true se existir e estiver vazia. ("", 0, null, false, array vazio)
// list() serve para fazer o unpacking da lista

$idade = 25;

if(isset($idade)){
    echo "A idade é: $idade" . PHP_EOL;
}else{
    echo "A variável \$idade não está definida" . PHP_EOL;

}

$nome = 'Daniel';
echo $nome.PHP_EOL;
unset($nome);
echo $nome.PHP_EOL; // vai disparar um erro de variavel não está definida

$telefone = '';

if (empty($telefone)){
    echo 'O telefone está vázio' . PHP_EOL;

}else{
    echo "Telefone: $telefone" . PHP_EOL;
}

echo $quebraLinha;

$array = ['PHP', 'SQL Server', 'Coqueiro'];
list($linguagem, $bancoDados, $loja) = $array;

var_dump($array);
echo $linguagem . PHP_EOL;
echo $bancoDados . PHP_EOL;
echo $loja . PHP_EOL;

echo $quebraLinha;

// usando o list() de uma forma mais simples ainda usando o []

class HomeController {
    public function index() {
        return 'index';
    }
}

$arr = ['HomeController', 'index'];
[$controller, $metodo] = $arr;  // unpacking usando o []

$controller = new $controller();
echo $controller->$metodo();