<?php

namespace models;

class Produto {
    public function mostrarDetalhes() {
        echo "Detalhes do produto  da pasta " . __NAMESPACE__ . PHP_EOL;
        echo __FILE__ . PHP_EOL;
    }
}