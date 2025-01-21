<?php

/**
 * DTD: É um conjunto de regras que vai definir a estrutura do documento XML. No caso aqui está definido que biblioteca terá um ou mais livros (livro+)
 * E cada livro contém elementos titulo, autor, ano e genero. (#PCDATA) indica que permite texto dentro dos elementos em XML
 *
 * <!DOCTYPE biblioteca [
 * <!ELEMENT biblioteca (livro+)>
 * <!ELEMENT livro (titulo, autor, ano, genero)>
 * <!ELEMENT titulo (#PCDATA)>
 * <!ELEMENT autor (#PCDATA)>
 * <!ELEMENT ano (#PCDATA)>
 * <!ELEMENT genero (#PCDATA)>
 * ]>
 **/

$xml = simplexml_load_file('biblioteca.xml');

#              livro é classe filho de root (biblioteca), acessamos a classe filho e nela conseguimos acessar os elementos de dentro [titulo, autor, ano, genero]
foreach ($xml->livro as $livro) {
    echo "Título: {$livro->titulo}" . PHP_EOL;
    echo "Autor: {$livro->autor}" . PHP_EOL;
    echo "Ano: {$livro->ano}" . PHP_EOL;
    echo "Gênero: {$livro->genero}" . PHP_EOL;
    echo PHP_EOL;
}

# UTF-8:  é a codificação de caracteres que pode representar qualquer caractere Unicode. É a segunda codificação mais usada por permitir caracteres especiais,
# ele geralmente é um dos mais leves usando 1 Byte para caractere normal e até 6 Bytes para caractere complex. (bom para inglês e línguas latinas).

# UTF-16: Codificação que usa 2 ou 4 bytes por caractere. O consumo de byte é 2 Bytes para caractere normal e 4 Bytes para caractere complex.
# Ele usa mais Bytes com a ASCII e menos com as línguas menos comuns. É útil para representar caracteres de idiomas asiáticos.

# US-ASCII: Uma codificação que representa os primeiros 128 caracteres Unicode (ou seja, os caracteres padrão do inglês).  O seu uso é limitado e geralmente é usado em arquivos de texto simples.

#ISO-8859-1: é Uma codificação que pode representar os caracteres de muitos idiomas da Europa Ocidental, mas não suporta todos os caracteres Unicode.


#  DOM (Document Object Model)

$dom = new DOMDocument('1.0', 'utf-8');     # Cria um objeto DOM
$dom->load('biblioteca.xml');   # Carrega o xml
$dom->formatOutput = true;  # Isso instrui o DOM a formatar o XML de forma legível ao salvá-lo.

function adicionarLivro(DOMDocument $dom, string $titulo, string $autor, string $ano, string $genero) {
    $livro = $dom->createElement('livro');  # Criar elemento livro do xml biblioteca

    # criando elementos filhos                      CHAVE     VALOR
    $elementoTitulo = $dom->createElement('titulo', $titulo);
    $elementoAutor = $dom->createElement('autor', $autor);
    $elementoAno = $dom->createElement('ano', $ano);
    $elementoGenero = $dom->createElement('genero', $genero);

    # adicionando os elementos para dentro de livro
    $livro->appendChild($elementoTitulo);
    $livro->appendChild($elementoAutor);
    $livro->appendChild($elementoAno);
    $livro->appendChild($elementoGenero);

    # Adicionando o livro ao bibliotca.xml
    $dom->documentElement->appendChild($livro);
}

adicionarLivro($dom, 'Dom Casmurro', 'Machado de Assis','1899', 'Romance');

$dom->formatOutput = true;
#$dom->save('biblioteca.xml');

echo 'Livro adicionado com sucesso!' . PHP_EOL;
echo PHP_EOL;

foreach ($dom->getElementsByTagName('livro') as $livro) {
    #Acesso o livro   pegando o valor da chave      pegando o primeiro elemento
    $titulo = $livro->getElementsByTagName('titulo')->item(0)->nodeValue;
    $autor = $livro->getElementsByTagName('autor')->item(0)->nodeValue;
    $ano = $livro->getElementsByTagName('ano')->item(0)->nodeValue;
    $genero = $livro->getElementsByTagName('genero')->item(0)->nodeValue;

    echo "Titulo: {$titulo}" . PHP_EOL;
    echo "Autor: {$autor}" . PHP_EOL;
    echo "Ano: {$ano}" . PHP_EOL;
    echo "Genero: {$genero}" . PHP_EOL;
    echo PHP_EOL;

};

/**
                                    * LIBXML
 * Ele é uma biblioteca subjacente que oferece suporte a diversas funcionalidades de manipulação e validação de XML,
 * e muitas das extensões de PHP que trabalham com XML (como DOM, SimpleXML e XMLReader) utilizam o libxml por trás dos
 * panos para fazer parsing, validação, navegação, modificação, e até geração de documentos XML.
 */
