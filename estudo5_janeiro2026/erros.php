<?php

//                                  Tipos de Erros em PHP

//      Erros de Sintaxe (Parse Errors)
// faltou ponto e vírgula -> Parse error: Ocorrem quando o código está escrito de forma incorreta.

//echo "Olá mundo"


//      Erros de Execução (Runtime Errors): Acontecem durante a execução, mesmo que a sintaxe esteja correta, ele dispara
// um WARNING, mas ainda, sim, continua a rodar o ‘script’

//$conteudo = file_get_contents("arquivo_inexistente.txt");
//echo 'continua rodando...' . PHP_EOL;


//      Fatal Error: Ocorre quando o PHP encontra algo que não pode continuar.

//naoExiste(); // chamando função inexistente


//      Erro de Configuração, por exemplo: Problemas no php_ini

//  memory_limit baixo -> scripts grandes quebram. Fatal error: Allowed memory size of 134217728 bytes exhausted
//  file_uploads = Off -> não consegue subir arquivos.  Nada acontece, porque o PHP nem aceita upload.
//  display_errors = Off -> erros não aparecem no navegador.


// Fatal Error: Quando acontece ele para o script imediatamente PHP Fatal error:  Uncaught DivisionByZeroError:

// echo 10 / 0;


//      Erros lógicos que podem implementar um ‘bug’. O código roda sem travar, mas o resultado está errado.

// Exemplo: usar + em vez de *. Resultado esperado 6 * 3 = 18
// $resultado = 2 + 3; // Erro na lógica 2 + 3 = 5


//                          Tratamento de Erros em PHP

//  Error Functions (Funções de Erro em PHP)

//  error_reporting(): Define quais tipos de erros devem ser exibidos.

error_reporting(E_ALL); // mostra todos os erros
error_reporting(0);     // não mostra nenhum erro


// set_error_handler(): Permite criar uma função personalizada para lidar com erros.

function meuErro($errno, $errstr, $errfile, $errline) {
    echo "Erro [$errno]: $errstr em $errfile na linha $errline" . PHP_EOL;
}

// Todos os erros vão passar pela minha função porque passamos ela como callback abaixo, exceto (parse errors, erro fatal php)
// o set_error_handler captura Notices, Warning, User errors, etc ...
set_error_handler("meuErro");

file_get_contents("arquivo_inexistente.txt"); // dispara Notice, tratado pela função

echo $variavelNaoDefinida; // dispara Notice/Warning, tratado pela função

trigger_error("Algo deu errado!", E_USER_WARNING); // Gera um erro manualmente e vai ser capturado pelo função


//              User-defined Errors (Erros Definidos pelo Usuário)

$idade = -5;

if ($idade < 0) {
    trigger_error("Idade inválida: não pode ser negativa", E_USER_ERROR); // Isso gera um erro fatal definido pelo usuário
}


//  Com Exceções (throw e try/catch/finally) é mais flexível do que a forma utilizada a cima

function dividir($a, $b) {
    if ($b == 0) {
        throw new Exception("Divisão por zero não permitida!");
    }
    return $a / $b;
}

try {
    echo dividir(10, 0);

} catch (Exception $e) {
    echo "Erro capturado: " . $e->getMessage() . PHP_EOL;

} finally { // Finally ele executa após o try ou catch
    echo 'Salvando no log do SACI.' . PHP_EOL;
}


//      Podemos também criar uma classe para lidar com as excessões que é a uma das formas mais usada por nós

class IdadeInvalidaException extends Exception {}

function validarIdade($idade) {
    if ($idade < 0) {
        throw new IdadeInvalidaException("Idade não pode ser negativa!");
    }
}

try {
    validarIdade(-10);

} catch (IdadeInvalidaException $e) {
    echo "Erro de idade: " . $e->getMessage() . PHP_EOL;
}


//                        Exception Handling (Tratamento de Exceções)

try {
    // Código que pode gerar erro
    if (rand(0,1)) {
        throw new Exception("Algo deu errado!");
    }
    echo "Tudo certo e não deu erro, vai chamar o finally" . PHP_EOL;
} catch (Exception $e) {
    // Tratamento do erro
    echo "Erro capturado: " . $e->getMessage() . PHP_EOL;
} finally {
    // Sempre executa, com ou sem erro
    echo "Finalizando..." . PHP_EOL;
}


//  try:     bloco onde você coloca código “arriscado” que possívelmente pode disparar um erro.
//  throw:   dispara uma exceção que vai ser capturada no catch.
//  catch:   captura e trata a exceção.
//  finally: executa sempre (útil para liberar recursos, fechar conexões, etc.).



//                             Error Class (Classe de Erro)

// Exception: usada para erros de lógica ou regras de negócio.
// Error: usada para erros fatais do motor PHP (ex.: chamar função inexistente, falta de memória).

// Capturando multiplos erros no catch usando o Throwable, Error e Exception. O Throwable é o mais genérico que vai
// capturar todos os erros porque o Throwable é uma interface e todos os erros implementam ele. Se por algum motivo
// o erro não for capturado pelo Error ou Exception, o Throwable vai capturar.

try {
    naoExiste();
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . PHP_EOL;

} catch (Error $e) {
    echo "Erro fatal: " . $e->getMessage() . PHP_EOL;

} catch (Throwable $e) {
    echo "Throwable: " . $e->getMessage() . PHP_EOL;
}
