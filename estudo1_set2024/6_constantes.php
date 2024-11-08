<?php

namespace estudoConstantes;

$quebraLinha = str_repeat("=", 50) . PHP_EOL;



//CONSTANTES    Constantes em PHP são identificadores para valores que não podem ser alterados após a sua definição podem ser criadas a partir de const ou define

// const é usada no escopo global ou dentro de classes.
// define() pode ser usada no meio da compilação e funções, mas não dentro de classes.

class Empresa
{
    const NOME = "COQUEIRO";
    const ENDERECO = "JARDIM BOTâNICO";
}

echo Empresa::NOME . " " . Empresa::ENDERECO . PHP_EOL; // As constantes de classe são acessadas com o operador de resolução de escopo ::

function exibirConfiguracaoProsoft(){
    define('PROGRAMA', 'PROSOFT');
    define('VERSAO', '6.10.1');
    echo "Definindo constante pelo define dentro de uma função." . PHP_EOL;
    echo PROGRAMA . " " . VERSAO . PHP_EOL;
}

exibirConfiguracaoProsoft();

echo $quebraLinha;

//Constantes built-in: __DIR__; __FILE__; __FUNCTION__; __CLASS__; __LINE__; __METHOD__; __TRAIT__; __NAMESPACE__

echo '__LINE__ ' . __LINE__ . PHP_EOL; //  retorna o número da linha do arquivo
echo '__FILE__ ' . __FILE__ . PHP_EOL; //  retorna o caminho completo e o nome do arquivo
echo '__DIR__ ' . __DIR__ . PHP_EOL; //  retorna o diretório do arquivo
echo '__NAMESPACE__ ' . __NAMESPACE__ . PHP_EOL; // Retorna o nome do namespace atual. Se o arquivo não estiver dentro de um namespace, retorna uma string vazia

$quebraLinha = str_repeat("=", 50) . PHP_EOL;

function consultaSaldo(){
    echo '__FUNCTION__ ' . __FUNCTION__ . PHP_EOL; // __FUNCTION__ retorna o nome do namespace se tiver e da função ou {closure} para funções anônimas.
}

consultaSaldo();

class Usuario{

    public function logar(){
        echo '__CLASS__ ' . __CLASS__ . PHP_EOL;    // __CLASS__ retorna o nome da classe. O nome da classe inclui o namespace em que foi declarada
    }
}

(new Usuario)->logar();

echo $quebraLinha;
trait carroFuncionalidades {    // TRAIT é similar a uma classe, mas destina-se apenas a agrupar funcionalidade de uma forma refinada e consistente.
    public function acelerarCarro() {
        echo '__TRAIT__' . __TRAIT__ . PHP_EOL;   // __TRAIT__ retorna o nome do trait. O nome do trait inclui o namespace em que foi declarado
        echo 'Acelerando o carro' . PHP_EOL;
        $this->mostrarVelocidadeAtual();    // $this você pode acessar métodos dentro da mesma classe ou trait
    }

    public function mostrarVelocidadeAtual(){
        echo '__METHOD__ ' . __METHOD__ . PHP_EOL;  // __METHOD__ retorna o nome da classe::nome do método
        echo "Velocidade: " . rand(0, 150) . "Km/h" . PHP_EOL;

    }
}

class Carro {
    use carroFuncionalidades;   // Ao usar o USE carroFuncionalidas, a class carro vai 'herdar' os métodos da trait carroFuncionalidade
}

$carro = new Carro();
$carro -> acelerarCarro();

