<?php

//                                            O que é SOAP
//SOAP é um protocolo padrão projetado originalmente para possibilitar a comunicação entre aplicações desenvolvidas
//em diferentes linguagens e plataformas. SOAP usa XML para formatar as mensagens que vão de um sistema a outro.
//A estrutura básica de uma mensagem SOAP tem três partes principais: Envelope, Header e Body

# WSDL: WSDL é um arquivo XML que descreve os serviços oferecidos pelo web service, seus métodos, parâmetros e tipos de dados.

//<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
//    <soap:Header>
//        <Authentication xmlns="http://example.com/auth">
//            <Username>usuario</Username>
//            <Password>senha</Password>
//        </Authentication>
//    </soap:Header>
//    <soap:Body>
//        <GetUserDetails xmlns="http://example.com/user">
//            <UserId>123</UserId>
//        </GetUserDetails>
//    </soap:Body>
//</soap:Envelope>


#                              REST
//REST (Representational State Transfer) é um estilo de arquitetura para criar APIs que permite a comunicação entre
//sistemas via HTTP (o mesmo protocolo usado na web). Com REST, os dados são geralmente trocados no formato JSON ou XML
//(JSON é o mais comum hoje em dia).
//principais métodos
//GET: Pegar dados
//POST: É utilizado para enviar um novo recurso no servidor
//PUT ou PATCH: Para atualizar um recurso existente
//DELETE: Para remover um recurso

#                   GET
$cep = "71680362";
$url = "https://viacep.com.br/ws/$cep/json/";

$response = file_get_contents($url);    # fazendo a requisição pra API

if ($response) {
    $json = json_decode($response, true);     # True significa que queremos um array
    if (isset($json['erro']) && $json['erro'] === true) {       # Verifica se tem erro dentro do array $json se for true é pq o cep não foi encontrado
        echo "CEP não encontrado!";
    } else {
        echo "Logradouro: {$json['logradouro']}" . PHP_EOL;
        echo "Bairro: {$json['bairro']}" . PHP_EOL;
        echo "Estado: {$json['estado']}" . PHP_EOL;
        echo "Região: {$json['regiao']}" . PHP_EOL;
    }
} else {
    echo "Erro ao consultar o CEP.";
}

echo PHP_EOL;

#                   POST
$url = "https://jsonplaceholder.typicode.com/posts";

// Dados a serem enviados no POST
$dados = [
    'title' => 'Exemplo de POST',
    'body' => 'Este é o conteúdo do meu novo post.',
    'userId' => 1
];

// Setando a URL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     # Configura cURL para retornar a resposta como uma string em vez de exibi-la diretamente.
curl_setopt($ch, CURLOPT_POST, true);       #  Indica que estamos fazendo uma requisição POST.
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dados));     # Especifica os dados a serem enviados, que são convertidos em uma string de consulta (query string) usando http_build_query.

// Executa a requisição
$response = curl_exec($ch);

# Fechando a sessão para liberar recursos
curl_close($ch);

// Exibe a resposta
echo "Resposta do POST: {$response}" . PHP_EOL; ;

echo PHP_EOL;

#                           PUT
$url = "https://jsonplaceholder.typicode.com/posts/1"; // ID do post que queremos atualizar

// Dados a serem enviados no PUT
$dados = [
    'id' => 1,
    'title' => 'Meu Post Atualizado',
    'body' => 'Este é o conteúdo do meu post atualizado.',
    'userId' => 1
];

// Inicializa o cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     # Configura cURL para retornar a resposta como uma string.
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');     # Define que estamos fazendo uma requisição PUT.
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));  #  Enviamos os dados convertidos para JSON usando json_encode.
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);   # Define o cabeçalho Content-Type como application/json para informar ao servidor que estamos enviando dados em formato JSON.

// Executa a requisição
$response = curl_exec($ch);
curl_close($ch);

// Exibe a resposta
echo "Resposta do PUT: {$response}";

echo PHP_EOL;

#               DELETE
$id = 1; // ID do post a ser removido
$url = "https://jsonplaceholder.typicode.com/posts/$id";

// Inicia o cURL
$ch = curl_init($url);

// Configura o cURL para usar o método DELETE
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

// Configura o cURL para retornar a resposta em vez de exibir
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa a requisição
$response = curl_exec($ch);

// Fecha o cURL
curl_close($ch);

// A JSONPlaceholder sempre retorna um status 200 mesmo após a remoção
if ($response) {
    echo "Post com ID $id removido com sucesso!";
} else {
    echo "Erro ao executar a requisição.";
}

echo PHP_EOL;


#                                      HTTP Methods
//Os métodos HTTP são fundamentais para a comunicação entre clientes e servidores na web, especialmente ao trabalhar
//com APIs REST. Eles definem o tipo de ação que você quer realizar em um recurso, e os principais métodos
//são: GET, POST, PUT, DELETE, PATCH, OPTIONS, e HEAD.

//                                        GET
//O método GET é usado para recuperar dados de um servidor, sem alterar ou modificar o estado dos dados. Usamos quando vamos
//consultar uma apicação
//
//                                        POST
//O método POST é usado para criar um novo recurso no servidor. Diferente do GET, ele envia dados no corpo da requisição.
//
//                                        PUT
//O método PUT é usado para atualizar um recurso existente. Ao contrário do PATCH, que pode fazer atualizações parciais,
//o PUT geralmente substitui o recurso inteiro.
//
//                                        DELETE
//O método DELETE é usado para excluir um recurso existente no servidor.
//
//                                        PATCH
//O método PATCH é usado para fazer uma atualização parcial de um recurso. Diferente do PUT, ele atualiza apenas os
//campos especificados, sem substituir o recurso inteiro.
//
//                                        OPTIONS
//O método OPTIONS é usado para consultar o servidor sobre os métodos HTTP suportados por um determinado endpoint.
//Esse método é útil em situações de verificação de políticas de CORS (Cross-Origin Resource Sharing). O servidor responde
//com os métodos permitidos, como GET, POST, PUT, DELETE.
//
//                                        HEAD
//O método HEAD é similar ao GET, mas ele só retorna os cabeçalhos da resposta, sem o corpo.

#                                          HTTP STATUS CODE
//                                1xx: Informativos
//Esses códigos indicam que o servidor recebeu a solicitação e o cliente pode continuar com a requisição.
//
//100 Continue: O cliente pode continuar com a requisição.
//101 Switching Protocols: O servidor está mudando o protocolo conforme solicitado pelo cliente.


//                                2xx: Sucesso
//Indicam que a solicitação foi recebida, entendida e processada com sucesso.
//
//200 OK: A solicitação foi bem-sucedida e a resposta contém o recurso solicitado.
//201 Created: Um novo recurso foi criado como resultado da solicitação (normalmente em requisições POST).
//202 Accepted: A solicitação foi aceita, mas ainda não foi processada.
//204 No Content: A requisição foi bem-sucedida, mas não há conteúdo a ser retornado.


//                                3xx: Redirecionamento
//Esses códigos informam que o cliente precisa tomar ações adicionais para completar a solicitação.
//
//301 Moved Permanently: O recurso solicitado foi movido permanentemente para uma nova URL.
//302 Found: O recurso foi temporariamente movido para outra URL.
//304 Not Modified: O recurso não foi modificado desde a última solicitação, então o cliente pode usar a versão em cache.


//                                4xx: Erros do Cliente
//Esses códigos indicam que o erro foi causado pelo cliente (por exemplo, a URL está errada ou há falta de autenticação).

//400 Bad Request: A solicitação não pôde ser processada devido a um erro de sintaxe.
//401 Unauthorized: A solicitação exige autenticação; o cliente deve fornecer credenciais válidas.
//403 Forbidden: O cliente tem a permissão negada para acessar o recurso, mesmo que esteja autenticado.
//404 Not Found: O recurso solicitado não foi encontrado no servidor.
//405 Method Not Allowed: O método HTTP usado não é permitido para esse recurso.
//409 Conflict: Indica que há um conflito no estado do recurso (exemplo: tentativa de duplicação).
//429 Too Many Requests: O cliente enviou muitas requisições em um curto período (rate limit).


//                                5xx: Erros do Servidor
//Esses códigos indicam que o erro foi causado pelo servidor ao tentar processar a requisição.
//
//500 Internal Server Error: O servidor encontrou uma situação inesperada que o impediu de atender à solicitação.
//501 Not Implemented: O servidor não suporta o método HTTP usado.
//502 Bad Gateway: O servidor, ao agir como gateway ou proxy, recebeu uma resposta inválida do servidor upstream.
//503 Service Unavailable: O servidor está temporariamente indisponível (por exemplo, sobrecarga ou manutenção).
//504 Gateway Timeout: O servidor, ao atuar como gateway ou proxy, não recebeu uma resposta a tempo do servidor upstream.


//                        Principais Códigos para APIs REST

//200 OK: Para operações bem-sucedidas de leitura e atualização.
//201 Created: Para criação de novos recursos (POST).
//204 No Content: Para exclusões (DELETE) bem-sucedidas que não retornam conteúdo.
//400 Bad Request: Para erros de validação dos dados enviados.
//401 Unauthorized: Quando o cliente não está autenticado.
//403 Forbidden: Quando o cliente não tem autorização para acessar o recurso.
//404 Not Found: Quando o recurso solicitado não existe.
//409 Conflict: Quando há um problema com o estado do recurso.
//429 Too Many Requests: Para controle de limite de requisições.
//500 Internal Server Error: Para erros inesperados no servidor.