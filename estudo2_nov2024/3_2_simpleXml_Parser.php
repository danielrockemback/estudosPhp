<?php

#   Lendo, adicionando e removendo com o SIMPLEXML
$xml = simplexml_load_file('produtos.xml') or die();     # lendo arquivo

#           Adicionando um novo produto
$novoProduto = $xml->addChild('produto');
$novoProduto->addChild('nome', 'Tablet');
$novoProduto->addChild('preco', '1250.00');
$novoProduto->addChild('quantidade', '25');

#       Modificando o preço de um produto
foreach ($xml->produto as $produto) {
    if (strtolower($produto->nome) == strtolower('Notebook')) {
        $produto->preco = '3500';
        break;
    };
};

#       Removendo um produto
$indice = 0;

foreach ($xml->produto as $produto) {
    if (strtolower($produto->nome) == strtolower('Smartphone')) {
        unset($xml->produto[$indice]);
        break;
    };
    $indice++;
};

#$xml->asXML('produtos.xml');    # Salvando o arquivo

#       XML PARSER
# O xml parser usa funções de callback para analisar o arquivo em pedaços a medida que vai lendo ele e isso acaba economizando memória se for ler arquivos xmls grandes,
#diferente do DOM e SIMPLEXML que lêem o arquivo como árvore que é mais indicado para arquivos pequenos.

$xml = 'biblioteca.xml';

# Iniciando uma função start de callback
function inicioElemento($parser, $nome, $atributos) {
    echo "Iniciando elemento: {$nome}\n" . PHP_EOL;
}

# Finalizando o elemento
function finalElemento($parser, $nome) {
    echo "Finalizando elemento: {$nome}\n" . PHP_EOL;
}

function removeEspacoEQuebraDeLinhas($parser, $dado) {
    $dado = trim($dado);
    if (!empty($dado)) {
        echo "Conteúdo: {$dado}" . PHP_EOL;
    }
}

# Criando um parser

// Definir as funções de callback para lidar com o início e fim dos elementos
function startElement($parser, $name) {
    echo "Iniciando elemento: $name\n";
}

function endElement($parser, $name) {
    echo "Finalizando elemento: $name\n";
}

function characterData($parser, $data) {        # Função que processa o contéudo de texto dos elementos XML e imprime o conteúdo
    // Remover espaços e quebras de linha extras
    $data = trim($data);
    if (!empty($data)) {
        echo "Conteúdo: $data\n";
    }
}

// Criar um novo parser
$parser = xml_parser_create();

// Definir as funções de callback
xml_set_element_handler($parser, "startElement", "endElement");     # Define as funções de callback para o inicio e o fim
xml_set_character_data_handler($parser, "characterData");       # Define a função de callback para os dados de texto.


// Abrir o arquivo XML
$xmlFile = 'produtos.xml';
if (!($fileOpen = fopen($xmlFile, "r"))) {
    die("Não foi possível abrir o arquivo XML");
}

// Ler o arquivo e passar para o parser
while ($data = fread($fileOpen, 4096)) {        # fread é usado para ler o conteúdo de um arquivo aberto e o 4096 é especifica quantos bytes vão ser lido por vez
    if (!xml_parse($parser, $data, feof($fileOpen))) {
        die(sprintf("Erro de análise: %s na linha %d",
            xml_error_string(xml_get_error_code($parser)),      # Essa parte obtém a descrição do erro usando o código de erro retornado por xml_get_error_code($parser)
            xml_get_current_line_number($parser)));     #  Isso retorna o número da linha atual no arquivo XML onde o erro ocorreu.
    }
}

// Liberar o parser
xml_parser_free($parser);
