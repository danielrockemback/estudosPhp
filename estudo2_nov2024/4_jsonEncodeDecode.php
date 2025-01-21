<?php

#          JSON DECODE E ENCODE

 $array = [
     'nome' => 'Daniel Borges',
     'loja' => 'Coqueiro',
     'html' => '<tittle>DEV</tittle>',
     'caracteres' => '\'Teste\' &  "teste 2"',
     'categoria' => 'programação/desenvolvimento',
     'linguagens' => ['PHP', 'Visual Basic 6', 'HTML'],
     'filtros' => ['php' => 'Linguagem de programação',
                  'phpStorm' => 'Editor PHP',
                  'html' => 'Linguagem de marcação'],
     'numeros' => [10, 20, 30, 40, 50, 71.23],
     'cpf' => '25302781058'
 ];

 # Codificando o array em JSON
$jsom = json_encode($array,
    JSON_PRETTY_PRINT |      # Deixa o print mais bonito
        JSON_UNESCAPED_UNICODE |   # Não deixa escapar os caracteres unicode
        JSON_UNESCAPED_SLASHES |   # Não deixa escapar as barras
        JSON_HEX_TAG |             # Escape para tags
        JSON_HEX_APOS |            # Escapa as aspas dupla
        JSON_HEX_AMP |             # Escapa o E comercial
        JSON_HEX_APOS              # Escapa as aspas simples
);

$decode = json_decode($jsom);       # assim o decode vai retornar uma classe std, se quiser que retorne uma array, você pode true depois do arquivo json

# acessando os elementos do json para usar como quiser

echo $decode->nome . PHP_EOL;
echo $decode->cpf . PHP_EOL;
echo $decode->linguagens[0] . PHP_EOL;
echo $decode->filtros->phpStorm . PHP_EOL;
echo $decode->numeros[count((array) $decode->numeros) -1] . PHP_EOL;