<?php

#           XML WRITER
$xml = new XMLWriter();

$xml->openUri('produtosPromocao.xml');
$xml->setIndent(true);
$xml->startDocument('1.0', 'UTF-8');

# Iniciando o elemento raiz
$xml->startElement('produtos');

$produtos = [
    [
        'nome' => 'Cimento Extra Forte 40KG',
        'precoNormal' => 34.40,
        'precoPromocao' => 28.90,
        'descricao' => 'Cimento 40 KG',
        'categoria' => 'Material Básico'
    ],
    [
        'nome' => 'Telha de Fibrocimento Ondulada (2,44X1,10)',
        'precoNormal' => 52.69,
        'precoPromocao' => 41.81,
        'descricao' => 'Muito conhecidas pelos consumidores, as telhas de fibrocimento são produtos leves, resistentes
                        às variações climáticas e que proporcionam uma boa estética ao ambiente externo.As telhas de
                         fibrocimento são a solução ideal para seu projeto, seja ele residencial, industrial ou
                         comercial. Oferecem um acabamento perfeito para sua obra.Considere comprar telhas de
                         fibrocimento caso queira pouco trabalho na hora da instalação - por ser uma peça leve,
                         a sua montagem é muito fácil e rápida. Outro importante diferencial do produto é que o
                         fibrocimento apresenta um ótimo isolamento térmico e, por isso, o conforto de toda a família
                         estará garantido durante as quatro estações do ano.',
        'categoria' => 'Material Básico'
    ],
    [
        'nome' => 'ARAME RECOZIDO Nº 18 1KG',
        'precoNormal' => 16.01,
        'precoPromocao' => 13.91,
        'descricao' => 'O Arame recozido é amplamente utilizado na construção civil para amarração de elementos
                        estruturais, travamento das fôrmas dos elementos estruturais para concretagem, entre outras
                        funções. São maleáveis e fáceis de usar em aplicações que exigem dobras e/ou torções. Ideais
                        para fixar Vergalhões em armaduras de Concreto Armado',
        'categoria' => 'Material Básico'
    ]
];

foreach ($produtos as $produto) {
    $xml->startElement('produto');      # Adicionando filho

    # Adicionando neto
    $xml->writeElement('nome', $produto['nome']);
    $xml->writeElement('precoNormal', number_format($produto['precoNormal'], 2,'.', ''));
    $xml->writeElement('precoPromocao', number_format($produto['precoPromocao'], 2,'.', ''));
    $xml->writeElement('descricao', ($produto['descricao']));
    $xml->writeElement('categoria', $produto['categoria']);

    # fechando o elemento produto
    $xml->endElement();
}

# fechando o elemento raiz
$xml->endElement();

# encerrando o documento
$xml->endDocument();

# Fechando o manipulador
$xml->flush();

//                                          WDDX (Removido no php 7.4)
//O WDDX é um formato de serialização de dados que pode ser usado para converter variáveis complexas de PHP em uma
//representação XML e vice-versa. Ele é útil para compartilhar dados entre diferentes plataformas e linguagens de programação.

//wddx_serialize_value(): Serializa um valor PHP em WDDX.
//wddx_serialize_vars(): Serializa múltiplas variáveis em WDDX.
//wddx_deserialize(): Desserializa uma string WDDX de volta em variáveis PHP.

//// 1. Criar um array de dados
//$data = array(
//    "nome" => "João",
//    "idade" => 25,
//    "profissao" => "Desenvolvedor"
//);

//// 2. Serializar o array em WDDX
//$wddxPacket = wddx_serialize_value($data);
//echo "Dados serializados em WDDX:\n";
//echo $wddxPacket . "\n\n";

//// 3. Desserializar os dados WDDX de volta para PHP
//$deserializedData = wddx_deserialize($wddxPacket);
//echo "Dados desserializados de WDDX:\n";

//                              Dados serializados em WDDX:
//<wddxPacket version='1.0'><header/><data><struct><var name='nome'><string>João</string></var><var name='idade'>
//<number>30</number></var><var name='profissao'><string>Desenvolvedor</string></var></struct></data></wddxPacket>


#                               XSL (Extensible Stylesheet Language)
#   O PHP pode usar o XSLTProcessor para aplicar transformações XSLT em um documento XML, permitindo que você converta XML em outros formatos, como HTML.
# o XSL vai consumir os dados do XML e lá dentro do XSL você pode tratar os dados e exibir do jeito que você quiser

# Carregando o XML
$xml = new DOMDocument;
$xml->load('livros.xml');

# Carregando o XSL
$xsl = new DOMDocument;
$xsl->load('transformacao.xsl');

# Criando o processador XSLT
$xslt = new XSLTProcessor();
$xslt->importStylesheet($xsl);

# Aplica a transformação
echo $xslt->transformToXML($xml);


