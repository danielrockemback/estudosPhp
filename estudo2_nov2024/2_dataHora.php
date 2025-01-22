<?php
# Aqui definimos o fuso horário padrão do script para America/Sao_Paulo
date_default_timezone_set('America/Sao_Paulo');

# Pega a hora de agora e formata a data no padrão brasileiro
$data = new DateTime('now');
echo $data->format('d/m/Y H:i:s') . PHP_EOL;

 # Adicionar 10 anos(P10Y), 5 meses(5M) e 30 dias (30D) a partir da data escolhida
$data->add(new DateInterval('P10Y5M30D'));    
echo $data->format('d/m/Y H:i:s') . PHP_EOL;

echo PHP_EOL;

$ultimaCompraCliente = new DateTime('2024-01-03');
$diaAtual = new DateTime();

$diferenca = $diaAtual->diff($ultimaCompraCliente);
echo "Já tem $diferenca->days dias da última compra do cliente, entre em contato com ele." . PHP_EOL;

echo PHP_EOL;

$dataCompra = new DateTime('2024-10-22');
$dataBaixa = new DateTime('2024-10-28');
$dataEntrega = new DateTime('2024-10-30');

$flag = $dataEntrega->diff($dataCompra)->days;
$faltaQuantosDias = $dataCompra;

#                            DateInterval Class
# A classe DateInterval é usada para representar uma diferença entre datas. Ela permite que você adicione ou subtraia períodos de tempo a um objeto DateTime

echo "A Entrega vai ser feita até o dia {$dataEntrega->format('d/m/Y')} entre 9:00 horas até ás 18:00 horas" . PHP_EOL;
for ($dia = $flag; $dia >= 1; $dia--) {
    $faltaQuantosDias->add(new DateInterval('P1D'));

    if ($dia != 1) {
        echo "Data de hoje: {$faltaQuantosDias->format('d/m/Y')} faltam $dia dias para a sua compra ser entregue." . PHP_EOL;
        continue;
    }
    echo "Data de hoje: {$faltaQuantosDias->format('d/m/Y')} a sua compra vai ser entregue hoje." . PHP_EOL;

};

#                 Comparando Datas com DateTime
var_dump($dataBaixa > $dataEntrega);    # Entregou no prazo
var_dump($dataBaixa < $dataEntrega);    # Entrega realizada antes do prazo
echo PHP_EOL;

# Date Time Constants
echo date('Y-m-d H:i:s', PHP_INT_MAX) . PHP_EOL;    # PHP_INT_MAX pode ser usado para representar a data máxima que pode ser manipulada.
echo date(DATE_ATOM) . PHP_EOL;     # Exibe data no formato ATOM
echo date(DATE_RFC822) . PHP_EOL;   # Exibe data no formato RFC822
echo date(DATE_COOKIE) . PHP_EOL;   # Exibe data no formato DATE_COOKIE
echo date(DATE_RSS) . PHP_EOL;      # Exibe data no formato DATE_RSS
