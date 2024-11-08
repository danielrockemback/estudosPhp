<?php

//                                  include
//Descrição: Inclui e avalia o arquivo especificado durante a execução do script. Se o arquivo não
//for encontrado, o PHP gera um warning (aviso) mas continua a execução do script.
//
//                                  include_once
//Descrição: Similar ao include, mas garante que o arquivo seja incluído apenas uma vez durante a
//execução do script. Se o arquivo já foi incluído antes, ele será ignorado na próxima vez.
//
//                                  require
//Descrição: Funciona de maneira semelhante ao include, mas se o arquivo não forencontrado,
//gera um erro fatale interrompe a execução do script.
//
//                                 require_once
//Descrição: Funciona como require, mas garante que o arquivo seja incluído e avaliado apenas uma vez,
//mesmo se chamado várias vezes.

    include_once "10_2_header.php";
?>

<?php
    require_once "10_4_script.php";
?>

<?php
    include_once "10_3_footer.php";
?>