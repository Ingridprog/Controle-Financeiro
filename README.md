# Controle Financeiro


**Requisitos do sistema:** 

    * Laravel ^7.0;
    * PHP ^7.2.5;
    * Composer 2.0.4;
    * MySQL 8.0.22

**Subindo o projeto:** 

    * Rodar o comando: composer install --no-scripts;
    * Criar um arquivo .env e copiar os dados de .env.example(o arquivo pode estar oculto);
    * No diretório backend - gerar a chave da aplicação: php artisan key:generate;
    * Gerar a hash dos tokens: php artisan jwt:secret;
    * Criar o banco de dados e configurar o DB_DATABASE, DB_USER e DB_PASSWORD no arquivo .env;
    * Rodar o comando: php artisan migrate;

**Utilizando o sistema:** 

    * Na página index - clicar em cadastrar um cliente
    * Após o cadastro, fazer o login
    * Em transacoes, adicionar créditos 
    * Realizar operações de débito e transferência





