<?php

/**
 * O objetivo desse padrão é desacoplar a lógica de negócio da criação de objetos. A classe base declara um método
 * abstrato de criação (factory method) e as subclasses decidem qual classe concreta instanciar. É comum a classe base
 * usar um template method para ditar o fluxo, chamando o factory method em uma das etapas.
 */

// Esse padrão é usado no projeto saci ao fazer leitura de planilha. E aqui a gente aplica o O do SOLID que seria
// aberto para extender de outras classes, mas fechado para modificar abstract class ExportadorRelatorio

interface FormatadorInterface
{
    public function formatar(array $dados): string;
    public function extensao(): string;
}


final class FormatadorCsv implements FormatadorInterface
{
    public function formatar(array $dados): string
    {
        $linhas = array_map(fn($linha) => implode(';', $linha), $dados);

        return implode("\n", $linhas);
    }

    public function extensao(): string
    {
        return 'csv';
    }
}

final class FormatadorJson implements FormatadorInterface
{
    public function formatar(array $dados): string
    {
        return json_encode($dados, JSON_PRETTY_PRINT);
    }

    public function extensao(): string
    {
        return 'json';
    }
}


abstract class ExportadorRelatorio  // Classe abstrata que cria e dita o fluxo do processo
{
    // Aqui está o pulo do gato, quem herdar essa classe vai ter que implementar o criarFormatador que vai retornar uma classe
    // que implementa a nossa interface FormatadorInterface. Como vai ser feito isso não interessa, cada classe sabe como
    // que deve ser feito o processo, o csv vai ser de um jeito, o json vai ser de outro. Ao chamar o método exportar
    // ele vai chamar o criarFormatador da classe que foi instanciada, por exemplo o ExportadorCsv, então o próprio
    // ExportadorCsv sabe como é o processo de criarFormatador e o exportar vai ser igual para todos os tipos de arquivos
    // que implementar essa classe abstrata. Essa classe Abstrata é quem vai ditar o fluxo do processo.
    abstract protected function criarFormatador(): FormatadorInterface; // Factory method que vai retornar um objeto

    // A lógica de negócio, igual para todos
    public function exportar(array $dados, string $nomeArquivo): string // Template Method
    {
        $formatador = $this->criarFormatador();
        $caminho = "{$nomeArquivo}.{$formatador->extensao()}";

        file_put_contents($caminho, $formatador->formatar($dados));

        return $caminho;
    }
}


final class ExportadorCsv extends ExportadorRelatorio // Classe concreta que sabe qual classe criar
{
    protected function criarFormatador(): FormatadorInterface
    {
        return new FormatadorCsv();
    }
}

final class ExportadorJson extends ExportadorRelatorio  // Classe concreta que sabe qual classe criar
{
    protected function criarFormatador(): FormatadorInterface
    {
        return new FormatadorJson();
    }
}


// Código cliente

$dados = [
    ['P001', 'Caneta azul', 10],
    ['P002', 'Caderno', 5],
];

$exportador = new ExportadorCsv();
echo $exportador->exportar($dados, 'vendas'); // vendas.csv