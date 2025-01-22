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

# Array associativo, vai ser equivalente a dict em python
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

# Instância de objeto
$cliente = new Cliente('João', '22/11/1956', 'M', '02012214221', 'Paranoá', '9999-5555');
$funcionario = new Funcionario('Daniel', '14/07/1995', 'M', '05462176', 1111, '14:00-22:00');

# Acessando/Setando atributos dos objetos
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

# Função anônima
$listaPrecoProduto = [30, 20 , 14 , 36];

# Função anônima para calcular o aumento de 15%
$funcao = function($preco) {
	return $preco + ($preco * 0.15);
};

# a função array_map vai aplicar a função anônima ou pode ser outra função em cada item da lista
$novoPreco = array_map($funcao, $listaPrecoProduto);

print_r($novoPreco);

echo $quebraLinha;

# Classe Anônima

class Saudacao {
    public function dizerOla($nome) {
        return "Olá, $nome!";
    }
}

$objeto = new Saudacao();

# Callable usando o método de classe
$callable = [$objeto, 'dizerOla'];
# passando o $callable(parâmetro), ele vai se portar como se estivesse chamando a classe->método $objeto->dizerOla($nome)
echo $callable("Daniel");

echo $quebraLinha;

# Special (Resource, Null);

# Resource representa uma referência a um recurso externo (como uma conexão com banco de dados ou um arquivo aberto).

$arquivo = fopen('/opt/apps/estudoPhp/Objetivos.txt', 'r');

# Verifica se o arquivo foi aberto com sucesso
if ($arquivo) {
    while (($linha = fgets($arquivo)) !== false) {
        echo $linha;
    }
    fclose($arquivo);
}

echo $quebraLinha;

#                                 NULL
// O tipo Null é um valor especial que indica que uma variável não tem valor ou não foi inicializada.
// Pode ser atribuído explicitamente ou indicado quando uma variável não contém nenhum valor.

$variavel = $num ?? null;

if (is_null($variavel)) {
    echo "A variável é null!";
} else {
    echo "A variável tem valor.";
}

echo $quebraLinha;
