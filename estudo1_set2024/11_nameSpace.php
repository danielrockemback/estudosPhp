<?php
//                                         NameSpace
//Um namespace no PHP é uma forma de encapsular classes, interfaces, funções e constantes para evitar colisões de nomes
//entre diferentes partes do código. Isso é especialmente útil em projetos grandes, onde bibliotecas ou componentes
//diferentes podem ter classes com o mesmo nome.

//                                           Use
//A palavra-chave use no PHP é usada para importar classes, interfaces, funções e constantes de um namespace específico
//para o escopo atual, permitindo que você não precise sempre digitar o caminho completo do namespace.

require_once 'classes/produto.php';     // IMPORTANDO O ARQUIVO PRODUTO.PHP DA PASTA CLASSES
require_once 'models/produto.php';      // IMPORTANDO O ARQUIVO PRODUTO.PHP DA PASTA MODELS

//  PASTA\CLASSE   as APELIDO
use models\Produto as modeloProduto;

//  PASTA \CLASSE   as APELIDO
use classes\Produto as classeProduto;

$produto = new modeloProduto(); // Foi estanciado a partir do nome colocado no ALIAS

$produto2 = new classeProduto();


echo $produto->mostrarDetalhes();
echo PHP_EOL;
echo $produto2->mostrarDetalhes();

phpinfo();