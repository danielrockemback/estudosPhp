<?php

/*
O PHP.ini é um arquivo de configuração que contém as definições de PHP do seu servidor web. Ele permite que você
controle as regras relacionadas ao PHP do seu site, incluindo definir o limite de tamanho ao fazer upload de arquivos e
ocultar mensagens de erro.

A localização deste arquivo de configuração PHP varia dependendo do servidor web. Para alterar as configurações,
edite o arquivo e altere o valor do parâmetro através de um editor de texto.

Parâmetros Importantes do Arquivo PHP.ini

                                        display_errors

Determina se as mensagens de erro do PHP são exibidas para os usuários durante a execução do script ou não, usando
os valores on (ligadas) e off (desligadas). Por razões de segurança, você deve usar essa diretriz apenas quando estiver
desenvolvendo seu site.

                                        error_reporting

Define qual mensagem de erro é exibida para os usuários quando a diretriz display_errors está ativada.
O parâmetro error_reporting  aceita várias constantes para exibir diferentes erros.
Você pode usar múltiplos valores fixos e excluir erros específicos. Por exemplo, para mostrar todos os erros
exceto o aviso de descontinuidade, use a seguinte constante: E_ALL & ~E_DEPRECATED

                                        file_uploads

Define se os uploads de arquivos HTTP estão habilitados ou não. O valor on (habilitado) permitirá que os usuários
façam upload de arquivos para o seu site, enquanto off (desabilitado) desativa essa função. upload_max_filesize este
parâmetro determina o tamanho máximo que o PHP permitirá para upload de arquivos em seu site. Como o valor padrão é 2 MB,
você pode aumentar o tamanho máximo de upload de arquivo para permitir que os usuários subam de arquivos grandes.

                                        error_log

Especifica o arquivo onde o PHP registrará erros para a solução de problemas do erro. Antes de habilitá-lo,
certifique-se de que os usuários do servidor web têm permissão para escrever sobre o arquivo.

                                        post_max_size

O tamanho máximo de dados POST que o PHP pode coletar dos formulários HTML em seu site. O valor deve ser maior que o
 tamanho máximo do arquivo, pois é manipulado com a função POST

                                       allow_url_fopen

Escreve um script PHP para acessar arquivos remotos de outro servidor. Está desativado por padrão, pois ativá-lo
 pode expor seu servidor a um ataque de injeção de código.

                                        allow_url_include

Esta diretiva tem uma função semelhante à de allow_url_open, mas usa a função include (link em inglês).
 Para habilitá-lo, você precisa antes habilitar a diretriz allow_url_open.

                                        session.name

Esta diretiva define o nome da sessão atual, que é usado em cookies e URLs. Você pode alterar o valor padrão de
PHPSESSID para qualquer nome descritivo com caracteres alfanuméricos.

                                        session.auto_start

Escolhe se uma sessão PHP inicia automaticamente ou sob demanda quando os usuários acessam seu site. Se você definir o
valor para 0, a sessão iniciará manualmente usando o script session_start.

                                        session.cookie_lifetime

Especifica a duração do cookie de sessão nos navegadores dos visitantes do seu site. Por padrão, o valor está
definido para 0 segundos, o que significa que seu site apaga os dados da sessão dos visitantes depois que eles fecham seus navegadores.

                                         memory_limit

Define a quantidade máxima de memória RAM que um script PHP pode usar. Tenha cuidado ao aumentar o limite de memória,
pois configurações erradas podem levar a sites lentos ou a quedas do servidor.

                                        max_execution_time

Determina o tempo máximo de execução de um script. Você pode alterar o tempo máximo padrão de execução de 30 segundos
para qualquer valor, mas configurar uma opção muito alta pode causar problemas de desempenho.

                                        max_input_time

Define por quanto tempo um script pode analisar dados coletados de formulários HTML em seu site usando um metodo POST
ou GET. Quanto mais dados seu site coleta, maior deve ser o valor de max_input_time .

                                        upload_temp_dir

Especifica o diretório temporário para armazenamento dos arquivos subidos para o servidor. Todos os usuários devem poder
escrever sobre e criar arquivos no diretório especificado. Caso contrário, o PHP usará o diretório padrão do sistema.

                                        realpath_cache_ttl

Define o tempo pelo qual seu sistema vai armazenar em cache as informações do realpath (link em inglês). Recomendamos
aumentar o valor para sistemas com arquivos que raramente mudam.

                                        arg_separator.output

Use esta diretiva de manipulação de dados para separar argumentos em URLs gerados pelo PHP. Seu valor padrão é um ampersand (&).

                                        arg_separator.output

Define o separador que o PHP usa para analisar URLs de entrada em variáveis. Por padrão, é um ampersand (&), mas você
pode mudá-lo para outros símbolos como ponto e vírgula (;).














 */