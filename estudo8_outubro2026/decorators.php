<?php

/**
 * PADRÃO ESTRUTURAL: DECORATORS
 *
 * Esse padrão é muito utilizado quando você quer adiconar um comportamento extra para algo que já funciona, sem
 * mexer na classe orignal. Nossa classe orignal no exemplo é o BuscadorCepApi, mas como nós fazemos várias requisições
 * por dia por exemplo, nós decidimos implementar um classe que faz o cache das consultas e depois implementamos uma
 * classe para monitorar os logs.
 */

// interface comum. Tanto a classe original quanto os decorators implementam ela, por isso um pode
// ser encaixado dentro do outro.
interface BuscadorCepInterface
{
    public function buscar(string $cep): string;
}


// Classe concreta original
final class BuscadorCepApi implements BuscadorCepInterface
{
    public function buscar(string $cep): string
    {
        echo "  (consultando API externa...)\n";

        return "Esplanada dos Ministérios, Brasília/DF"; // simulando a resposta da API
    }
}

// Decorator
final class BuscadorCepComCache implements BuscadorCepInterface
{
    private array $cache = [];

    public function __construct(private BuscadorCepInterface $buscador) {}

    public function buscar(string $cep): string
    {
        // Só chama o objeto embrulhado se ainda não tiver no cache. Verifica se dentro da lista existe alguma chave
        // com o valor do cep, se retornar null a gente faz a requisição no BuscadorCepApi que vai consultar uma api
        // e vamos salvar o resultado no cache. A próxima vez que utilizarmos o mesmo cep, então ele vai pegar direto do
        // cache ao invés de consultar a api novamente
        return $this->cache[$cep] ??= $this->buscador->buscar($cep);
    }
}

// Decorator
final class BuscadorCepComLog implements BuscadorCepInterface
{
    public function __construct(private BuscadorCepInterface $buscador) {}

    public function buscar(string $cep): string
    {
        echo "[LOG] Buscando CEP {$cep}\n";               // ANTES logando

        $resultado = $this->buscador->buscar($cep);       // repassa pro embrulhado BuscadorCepComCache

        echo "[LOG] Resultado: {$resultado}\n";           // DEPOIS logando

        return $resultado;
    }
}

// Código Cliente

// O encadeamento funciona porque todas as classes implementam BuscadorCepInterface, e os decorators recebem no
// construtor um objeto dessa interface. Eles não sabem quem estão embrulhando, só que o objeto tem o método buscar().
$buscador = new BuscadorCepComLog(
    new BuscadorCepComCache(
        new BuscadorCepApi()
    )
);

$buscador->buscar('70040-010');

// vamos utilizar o mesmo cep, porém ele n]ao vai fazer a requisição pela api, mas sim vai pegar o que está no cache
$buscador->buscar('70040-010');