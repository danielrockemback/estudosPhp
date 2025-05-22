<?php

//                      Passo 5 - Entrada/Saída em PHP

// Abrir, Ler e Escrever arquivos e os tipos de arquivos que é possível manipular
// Arquivos de texto (.txt, .csv, .json, .xml, .php, etc)
// Arquivos binários (imagens .jpg, .png, arquivos .pdf, vídeos, arquivos compactados)

// fopen($arquivo, $modo) - abre arquivo para leitura, escrita, etc

$nomeArquivo = 'ultimosPedidos.txt';

if (!file_exists($nomeArquivo)) {
    $arquivo = fopen($nomeArquivo, 'w');
    fclose($arquivo);
}

$arquivo = fopen($nomeArquivo, 'w');
fwrite($arquivo, "idPedido 569515|idTerceiro 10235\n");
fwrite($arquivo, "idPedido 569516|idTerceiro 40221\n");
fclose($arquivo);

$lerArquivo = fopen($nomeArquivo, 'r');

if ($lerArquivo) {
    $conteudo = fread($lerArquivo, filesize($nomeArquivo));
    echo $conteudo;
    fclose($lerArquivo);
}

//                  Modos principais do fopen()

//  Modo	Descrição
//  r	Abrir só para leitura
//  w	Abrir só para escrita, apaga o conteúdo
//  a	Abrir só para escrita, acrescenta no final
//  r+	Abrir para leitura e escrita
//  x	Criar arquivo só para escrita (erro se existir)

//                             Entrada/Saída em PHP

// Verificar se o arquivo existe
if (file_exists('ultimosPedidos.txt')) {
    echo "Arquivo existe\n";
}

// Verificar se é um arquivo
if (is_file('ultimosPedidos.txt')) {
    echo "É um arquivo\n";
}

// Verificar se é um diretório
if (is_dir('public')) {
    echo "É um diretório\n";
}

// Pegar tamanho do arquivo
$tamanho = filesize('ultimosPedidos.txt');
echo "Tamanho: $tamanho bytes\n";

// Apagar arquivo
if (file_exists('ultimosPedidos2.txt')) {
    echo unlink('ultimosPedidos2.txt');
} else {
    echo 'Esse arquivo não existe ...' . PHP_EOL;
}

// Criar diretório
mkdir('nova_pasta');

// Remover diretório (vazio)
rmdir('nova_pasta');

// Ler arquivo inteiro direto (modo rápido)
$conteudo = file_get_contents('ultimosPedidos.txt');
echo $conteudo;

// Gravar conteúdo inteiro no arquivo (modo rápido), flag FILE_APPEND para adicionar e não sobrescrever o que tinha no arquivo
file_put_contents('ultimosPedidos.txt', "idPedido 569517|idTerceiro 77501 \n", FILE_APPEND);
$conteudo = file_get_contents('ultimosPedidos.txt');
echo $conteudo;
echo  PHP_EOL;

// Manipulação de linhas com file()
$linhas = file('ultimosPedidos.txt'); // cada linha vira um elemento do array

foreach ($linhas as $linha) {
    echo trim($linha) . "\n";
}

//                              Streams
// Streams são formas de manipular dados que podem ser arquivos, dados na rede

// pegando o dado de entrada digitado pelo  usuário
echo "Digite seu nome: ";
$nome = trim(fgets(STDIN));
echo "Olá, $nome!\n";

$arquivo = fopen('ultimosPedidos.txt', 'r');

while (($linha = fgets($arquivo)) !== false) {
    echo trim($linha) . "\n";
}

fclose($arquivo);

//| Função                | Descrição                             |
//| --------------------- | ------------------------------------- |
//| `fopen()`             | Abre arquivo                          |
//| `fread()`             | Lê dado do arquivo                    |
//| `fwrite()`            | Escreve dado no arquivo               |
//| `fclose()`            | Fecha arquivo                         |
//| `file_get_contents()` | Lê arquivo inteiro (modo rápido)      |
//| `file_put_contents()` | Escreve arquivo inteiro (modo rápido) |
//| `file()`              | Lê arquivo em array por linha         |
//| `fgets()`             | Lê arquivo linha a linha              |
//| `file_exists()`       | Verifica se arquivo existe            |
//| `unlink()`            | Deleta arquivo                        |
//| `mkdir()`             | Cria diretório                        |
//| `rmdir()`             | Remove diretório (vazio)              |
