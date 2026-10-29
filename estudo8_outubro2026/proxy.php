<?php

/**
 * PADRÃO ESTRUTURAL: PROXY
 *
 * Serve pra colocar um substituto na frente do objeto real. O substituto tem a mesma interface, então quem usa nem
 * percebe a diferença, mas ele controla o acesso: decide QUANDO criar o objeto real e SE pode acessar.
 *
 * Exemplo 1 (proxy virtual): o relatório só é carregado do banco quando alguém pede. Cada proxy cuida do seu
 * próprio relatório, e na segunda vez reaproveita o que já carregou.
 *
 * Exemplo 2 (proxy de proteção): antes de gerar, verifica se o usuário é gerente. Funciona como um middleware.
 */

interface RelatorioInterface
{
    public function gerar(): string;
}


// O objeto REAL: caro de criar, se usassemos somente essa classe, a gente iria exigir muito do banco de dados
final class RelatorioVendas implements RelatorioInterface
{
    private array $vendas;

    public function __construct(private int $ano)
    {
        echo "Carregando milhares de vendas de {$ano} do banco...\n";
        $this->vendas = array_fill(0, 5000, 'venda'); // simulando muitos registros
    }

    public function gerar(): string
    {
        return "Relatório de {$this->ano}: " . count($this->vendas) . " vendas\n";
    }

    public function __toString(): string
    {
        return "RelatorioVendas {$this->ano}";
    }
}


// O PROXY: barato de criar. Ele só cria o objeto real na primeira vez que alguém pede e guarda no $real.
// Nas próximas chamadas (na mesma execução), reaproveita o objeto em vez de ir ao banco de novo.
final class RelatorioVendasProxy implements RelatorioInterface
{
    private ?RelatorioVendas $real = null;

    public function __construct(private int $ano) {} // não carrega nada aqui

    public function gerar(): string
    {
        echo is_null($this->real) ? "NÃO EXISTE EM CACHE vamos buscar o relatório em RelatorioVendas" . "\n" : "ESTÁ EM CACHE: " . $this->real . "\n";
        // Só cria o objeto real na primeira vez que alguém pedir
        $this->real ??= new RelatorioVendas($this->ano);

        return $this->real->gerar();
    }
}

// Código cliente
$abas = [
    2024 => new RelatorioVendasProxy(2024),
    2025 => new RelatorioVendasProxy(2025),
    2026 => new RelatorioVendasProxy(2026),
];

echo "Tela carregada com 3 abas\n";

// O usuário abriu só a aba de 2026
echo $abas[2026]->gerar();
echo $abas[2026]->gerar();


echo str_repeat('-', 100) . "\n";



// PROXY de proteção: Aqui antes de acessar o relatório a gente aplica uma camada de proteção que só vai liberar o acesso
// para quem for gerente, aqui lembra muito uma middleware
final class RelatorioProtegidoProxy implements RelatorioInterface
{
    public function __construct(
        private RelatorioInterface $relatorio,
        private string $perfilUsuario,
    ) {}

    public function gerar(): string
    {
        if ($this->perfilUsuario !== 'gerente') {
            throw new RuntimeException('Acesso negado ao relatório.');
        }

        return $this->relatorio->gerar();
    }
}


$relatorio = new RelatorioProtegidoProxy(new RelatorioVendasProxy(2026), 'vendedor');

try {
    echo $relatorio->gerar();

} catch (Throwable $e) {
    echo $e->getMessage() . "\n"; // Acesso negado ao relatório.
}