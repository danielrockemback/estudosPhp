<?php
$quebraLinha = str_repeat("=", 50) . PHP_EOL;

// Laços while; do-while; for; foreach; continue; break;

$nomes = ['Daniel', 'João', 'Maria'];
$i = 0;

while ($i < count($nomes)) {
    echo "nome: $nomes[$i]" . PHP_EOL;
    $i++;
}

echo $quebraLinha;

$i = 0;

// Similar ao while, mas a condição é verificada após a execução do bloco, garantindo que ele seja executado pelo menos uma vez.
do {
    echo $nomes[$i] . PHP_EOL;
    $i++;
} while ($i < count($nomes));

echo $quebraLinha;

for ($num = 1; $num < 11; $num++){
    echo "TABUADO DO $num" . PHP_EOL;
    for ($mult = 1; $mult < 11; $mult++){
        echo "$num X $mult = " . ($num * $mult) . PHP_EOL;
    }
    echo $quebraLinha;
}

$numeros = [1, 2, 3, 4, 5, 10];

foreach ($numeros as $numero){      // O foreach é usado para iterar sobre arrays
    echo $numero * 2 . PHP_EOL;
}

echo $quebraLinha;

foreach ($numeros as $chave => $valor){      // index(CHAVE) =>(ATRIBUIR O ÍNDICE AO VALUE) numero(VALUES)
    echo "Chave[$chave] = Valor[$valor]"  . PHP_EOL;
}

echo $quebraLinha;

for ($num = 1; $num < 11; $num++){    // exemplo de for com continue e break
    if ($num % 2 == 0){
        continue;
    }else{
        for ($mul = 1; $mul < 11; $mul++){
            echo "$num X $mul = " . ($num * $mul) . PHP_EOL;
        }
    }
    echo $quebraLinha;
}

foreach ($nomes as $nome){
    if ($nome === 'maria'){
        break;
    }
    echo $nome . PHP_EOL;

}