<?php

class Produto {

    private $nome;
    private $preco;
    public function vender() {}
    private function calcularLucro() {}
}

// Biblioteca de Reflexão (Reflection)
// Serve para inspecionar e manipular classes, métodos, propriedades e parâmetros em tempo de execução.
$ref = new ReflectionClass('Produto');

foreach ($ref->getMethods() as $metodo) {
    echo $metodo->getName() . " - " . ($metodo->isPublic() ? "public" : "private") . PHP_EOL;
}

foreach ($ref->getProperties() as $prop) {
    echo $prop->getName() . " - " . ($prop->isPublic() ? "public" : ($prop->isPrivate() ? "private" : "protected")) . PHP_EOL;
}

// instacinado a partir do ReflectionClass
$produto = $ref->newInstance();

// Acessar e modificar propriedades privadas
$aux = $ref->getProperty('nome');
$aux->setValue($produto, 'Cimento 50 KG');

$aux = $ref->getProperty('preco');
$aux->setValue($produto, 29.99);

var_dump($produto) . PHP_EOL;


// Classes anônimas

// DiP
function executarServico($servico) {
    echo $servico->executar();
}

executarServico(new class {
    public function executar() {
        return "Serviço executado!" . PHP_EOL;
    }
});

// Com interface é útil que você não precisar criar a classe
interface Exportavel {
    public function exportar(): string;
}

$exportador = new class implements Exportavel {
    public function exportar(): string {
        return "Exportando dados...";
    }
};

echo $exportador->exportar();

// Exemplo mais básico transformando uma variável em uma classe sem nome
$logger = new class {
    public function log(string $mensagem) {
        echo "[LOG] $mensagem" . PHP_EOL;
    }

    public function erro(string $mensagem) {
        echo "[ERROR] $mensagem" . PHP_EOL;
    }
};

$logger->log("Sistema iniciado");
$logger->erro("Sistema deu erro na linha 321");