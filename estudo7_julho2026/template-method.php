<?php

declare(strict_types=1);

/**
 * Padrão de projeto Template Method serve para resolver o problema de duplicidade de código de classes que fazem as mesmas
 * coisas e centralizamos a lógico dentro de uma classe abstrata e dentro do template method que vai ser a função
 * responsável por executar a ordem dos processos e ajuda na hora da manutenção pq se em cada classe tivesse um executar
 * iria demorar muito e possivelmente iria quebrar, como nós centralizamos a lógica dentro da classe abstract, nós precisamos
 * mexer somente nela se precisar algum dia. Se por acaso surgir outro tipo de relátorio com a extensão doc por exemplo,
 * ao invés de criar uma classe com todas esses métodos, nós vamos herdar essa classe abstrata e implementar os métodos que
 * o executar da classe abstrata vai saber como lidar. Cada tipo de classe que herdar a classe abstrata deve saber como
 * abrir o arquivo, extrair os dados, analisar os dados, etc ...
 */
abstract class ExtratorDadosBase {

    // As ordens dentro do template method são fixas e não mudam entre os tipos de arquivos, cada classe que herdar vai
    // decidir como executar tal tarefa, mas não a ordem
    public function executar(string $caminho): bool
    {
        echo $this->logarProcessamento();

        $arquivo = $this->abrirArquivo($caminho);
        $linhas = $this->extrairDados($arquivo);
        $dados = $this->parseData($linhas);
        $analisarDados = $this->analisarDados($dados);

        return $this->enviarRelatorio($analisarDados);

    }
    abstract protected function abrirArquivo(string $caminho): string;
    abstract protected function extrairDados(string $arquivo): array;
    abstract protected function parseData(array $linha): array;
    abstract protected function analisarDados(array $dados): array;

    // Se quisermos personalizar o relatório de acordo com o tipo, nós podemos usar o polimorfismo e deixar do jeito que a gente quiser
    abstract protected function enviarRelatorio(array $resultado): bool;

    protected function logarProcessamento(): string
    {
        return 'Iniciando LOG da Classe Abstrata' .PHP_EOL;
    }
}

final class DadosCsv extends ExtratorDadosBase {

    protected function abrirArquivo(string $caminho): string
    {
        return 'Exemplo 1 CSV';
    }

    protected function extrairDados(string $arquivo): array
    {
        return ['Exemplo 2 CSV'];
    }

    protected function parseData(array $linha): array
    {
        return ['Exemplo 3 CSV'];
    }

    protected function analisarDados(array $dados): array
    {
        return ['Exemplo 4 CSV'];
    }

    protected function enviarRelatorio(array $resultado): bool
    {
        return true;
    }
}


final class DadosPdf extends ExtratorDadosBase {

    protected function abrirArquivo(string $caminho): string
    {
        return 'Exemplo 1 pdf';
    }

    protected function extrairDados(string $arquivo): array
    {
        return ['Exemplo 2 pdf'];
    }

    protected function parseData(array $linha): array
    {
        return ['Exemplo 3 pdf'];
    }

    protected function analisarDados(array $dados): array
    {
        return ['Exemplo 4 pdf'];
    }

    protected function enviarRelatorio(array $resultado): bool
    {
        return false;
    }

    protected function logarProcessamento(): string
    {
        return 'Iniciando LOG da Classe DadosPDF' . PHP_EOL;
    }
}

$csv = new DadosCsv();
$retorno = $csv->executar('/home/danielborges/relatorio.csv');
$msg = $retorno ? 'Relatório CSV enviado com sucesso' : 'Erro ao enviar relatório CSV';

echo $msg . PHP_EOL . PHP_EOL;

$pdf = new DadosPdf();
$retorno = $pdf->executar('/home/danielborges/relatorio.pdf');
$msg = $retorno ? 'Relatório PDF enviado com sucesso' : 'Erro ao enviar relatório em PDF';

echo $msg . PHP_EOL;
