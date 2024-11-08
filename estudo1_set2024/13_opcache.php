<?php

/*                                               OPCACHE
O opcache é uma extensão do PHP que melhora a performance da execução de scripts PHP, armazenando o bytecode dos scripts
compilados em memória, evitando que o PHP precise recompilar os scripts a cada requisição. Aqui estão as principais
informações e configurações do opcache que você deve conhecer:

                                        Principais Benefícios do OpCache
1- Aumento de Performance: O opcache reduz o tempo de carregamento de scripts PHP, já que não precisa recompilar o
código em cada execução.

2- Menos Uso de Recursos: Ao armazenar o bytecode em memória, o opcache diminui o uso de CPU e o tempo de execução do
PHP, resultando em um servidor mais eficiente.

3- Cache de Scripts: O opcache mantém o cache de scripts em memória, permitindo que os mesmos scripts sejam executados
mais rapidamente.

Habilitando o OPCACHE

zend_extension=opcache.so
opcache.enable=1
opcache.validate_timestamps=0
opcache.max_accelerated_files=65406
opcache.memory_consumption=256
opcache.interned_strings_buffer=12
opcache.fast_shutdown=1
opcache.enable_file_override=1
opcache.error_log=/var/log/php-opcache-error.log

enable: Ativa o OpCache.

validate_timestamps: Esta definição informa se o php deve ficar reavaliando se o arquivo do script foi atualizado, deve
ser ativado apenas em produção. Ao realizar novos deploys, é necessário reiniciar o webserver(nginx ou apache).
Do contrário o OpCache vai ignorar as alterações de arquivos.

max_accelerated_files: A quantidade de arquivos que o OpCache deve guardar em memória, deve-se tomar cuidado, calcula-se
a quantidade de arquivos, incluindo seus vendor packages.

memory_consumption: A quantidade de memória disponível que o OpCache poderá alocar para guardar os arquivos em memória.

interned_strings_buffer: A quantidade de memória que o OpCache utilizará para bufferizar strings.sua

enable_file_override: Se o opcache não deve validar a existência do arquivo origem do script cacheado.

fast_shutdown: Permite a zend engine memory manager gerenciar a opcache.max_accelerated_files=3000 alocação de
variáveis da requisição.


error_log: Um arquivo de log para erros oriundos da utilização do OpCache.



 */