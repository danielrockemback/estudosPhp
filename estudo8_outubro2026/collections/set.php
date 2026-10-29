<?php


/**
 * COLLECTIONS: SET (CONJUNTO)
 *
 * Coleção de valores ÚNICOS: não aceita repetidos.
 * A pergunta principal é "esse valor está aqui?", respondida em O(1).
 * Igual um álbum de figurinhas: cada uma só cola uma vez.
 *
 * O PHP não tem uma classe Set nativa. A forma mais comum é usar as CHAVES do array,
 * que já são únicas e têm busca O(1).
 *
 * Operações de conjunto:
 * - União: $a + $b
 * - Interseção: array_intersect_key($a, $b)
 * - Diferença: array_diff_key($a, $b)
 */

function titulo(string $texto): void
{
    echo "\n" . str_repeat('=', 60) . "\n";
    echo $texto . "\n";
    echo str_repeat('=', 60) . "\n";
}


// ------------------------------------------------------------
titulo('1. Set com as chaves do array');
// ------------------------------------------------------------

$emails = [];

$emails['ana@email.com'] = true;
$emails['bruno@email.com'] = true;
$emails['ana@email.com'] = true; // repetido: só sobrescreve, não duplica

echo 'Quantidade: ' . count($emails) . "\n"; // 2

// Verificar se existe: O(1)
echo 'Tem ana? ' . (isset($emails['ana@email.com']) ? 'sim' : 'não') . "\n";     // sim
echo 'Tem carla? ' . (isset($emails['carla@email.com']) ? 'sim' : 'não') . "\n"; // não

// Remover
unset($emails['bruno@email.com']);

// Pegar os valores como lista
print_r(array_keys($emails)); // ['ana@email.com']


// ------------------------------------------------------------
titulo('2. Removendo repetidos de uma lista');
// ------------------------------------------------------------

$cpfsImportados = ['111', '222', '111', '333', '222'];

// Opção A: array_unique (bom para limpar de uma vez)
$unicos = array_unique($cpfsImportados);
print_r($unicos);                  // mantém as chaves originais: [0 => '111', 1 => '222', 3 => '333']
print_r(array_values($unicos));    // renumera: [0 => '111', 1 => '222', 2 => '333']

// Opção B: chaves (bom quando vai continuar adicionando e consultando)
$set = [];
foreach ($cpfsImportados as $cpf) {
    if (isset($set[$cpf])) {
        echo "CPF {$cpf} duplicado, ignorando\n";
        continue;
    }
    $set[$cpf] = true;
}
print_r(array_keys($set)); // ['111', '222', '333']


// ------------------------------------------------------------
titulo('3. União, interseção e diferença');
// ------------------------------------------------------------

$novembro = array_flip(['Ana', 'Bruno', 'Carla']);
$dezembro = array_flip(['Bruno', 'Carla', 'Diego']);

$uniao = $novembro + $dezembro;
$intersecao = array_intersect_key($novembro, $dezembro);
$sumiram = array_diff_key($novembro, $dezembro);
$novos = array_diff_key($dezembro, $novembro);

echo 'Compraram em algum mês: ' . implode(', ', array_keys($uniao)) . "\n";        // Ana, Bruno, Carla, Diego
echo 'Compraram nos dois:     ' . implode(', ', array_keys($intersecao)) . "\n";   // Bruno, Carla
echo 'Sumiram em dezembro:    ' . implode(', ', array_keys($sumiram)) . "\n";      // Ana
echo 'Novos em dezembro:      ' . implode(', ', array_keys($novos)) . "\n";        // Diego


// ------------------------------------------------------------
titulo('4. Uma classe Conjunto (encapsulando as chaves)');

// ------------------------------------------------------------

final class Conjunto implements Countable
{
    private array $itens = [];

    public function __construct(array $valores = [])
    {
        foreach ($valores as $valor) {
            $this->adicionar($valor);
        }
    }

    public function adicionar(string|int $valor): void
    {
        $this->itens[$valor] = true;
    }

    public function remover(string|int $valor): void
    {
        unset($this->itens[$valor]);
    }

    public function contem(string|int $valor): bool
    {
        return isset($this->itens[$valor]);
    }

    public function uniao(Conjunto $outro): Conjunto
    {
        return new Conjunto(array_keys($this->itens + $outro->itens));
    }

    public function intersecao(Conjunto $outro): Conjunto
    {
        return new Conjunto(array_keys(array_intersect_key($this->itens, $outro->itens)));
    }

    public function diferenca(Conjunto $outro): Conjunto
    {
        return new Conjunto(array_keys(array_diff_key($this->itens, $outro->itens)));
    }

    public function valores(): array
    {
        return array_keys($this->itens);
    }

    public function count(): int
    {
        return count($this->itens);
    }
}

// Exemplo: permissões de perfis
$gerente = new Conjunto(['ver_relatorio', 'emitir_boleto', 'cancelar_venda', 'aprovar_desconto']);
$vendedor = new Conjunto(['ver_relatorio', 'emitir_boleto', 'criar_venda']);

echo 'Vendedor pode cancelar venda? ' . ($vendedor->contem('cancelar_venda') ? 'sim' : 'não') . "\n"; // não
echo 'Permissões em comum: ' . implode(', ', $gerente->intersecao($vendedor)->valores()) . "\n";
echo 'Só o gerente tem: ' . implode(', ', $gerente->diferenca($vendedor)->valores()) . "\n";
echo 'Todas as permissões: ' . count($gerente->uniao($vendedor)) . "\n"; // 5


// ------------------------------------------------------------
titulo('5. SplObjectStorage: um Set de OBJETOS');
// ------------------------------------------------------------

// Objetos não podem ser chaves de array. O SplObjectStorage resolve isso:
// ele usa a identidade do objeto (o mesmo spl_object_id que vimos no Prototype).
final class Cliente
{
    public function __construct(public string $nome)
    {
    }
}

$daniel = new Cliente('Daniel');
$maria = new Cliente('Maria');
$outroDaniel = new Cliente('Daniel'); // mesmos dados, mas é OUTRO objeto

$clientes = new SplObjectStorage();
$clientes->attach($daniel);
$clientes->attach($maria);
$clientes->attach($daniel);      // o mesmo objeto: não duplica
$clientes->attach($outroDaniel); // outro objeto: entra

echo 'Quantidade: ' . count($clientes) . "\n";                                     // 3
echo 'Contém $daniel? ' . ($clientes->contains($daniel) ? 'sim' : 'não') . "\n";   // sim

$clientes->detach($maria); // remover
echo 'Depois de remover Maria: ' . count($clientes) . "\n"; // 2


// ------------------------------------------------------------
titulo('6. Armadilha: o PHP converte as chaves');
// ------------------------------------------------------------

$set = [];
$set['1'] = true;  // a string '1' vira a chave int 1
$set[1] = true;    // mesma chave
$set[true] = true; // true vira 1: mesma chave de novo!

echo 'Quantidade: ' . count($set) . "\n"; // 1 (e não 3)
var_dump(array_keys($set));               // [1]