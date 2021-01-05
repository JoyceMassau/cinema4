# Cinema4

Roteiro de migração do CakePHP 2 para o CakePHP 4 utilizando CRUD de projeto cinema.

----

### Correção de Erros na Instalação do Cake Versão 4

PS: Para utilizar esta versão do cake é necessário versão igual ou superior a 7.2.0 do PHP

Se ocorrer erro na instalação com composer: "[Composer\Exception\NoSslException] The openssl extension is required for SSL/TLS protection but is not available. If you can not enable the openssl ex tension, you can disable this error, at your own risk, by setting the 'disable-tls' option to true."

> Abra o diretório em que se instalou o php7
- Exemplo: H:\xampp\php7

> Descomentar essas linhas no php.ini
- extension_dir = "ext"
- extension=openssl

> Salvar arquivos
> Criar uma cópia do arquivo php.ini-development, e alterar o nome do arquivo cópia para "php.ini"
> Fechar xampp e abrir novamente
> Rodar novamente no terminal o comando para criar o projeto
- Exemplo: php7 H:\xampp\php7\composer.phar create-project --prefer-dist cakephp/app:~4.0 cinema4

> No php.ini, descomentar todas essas extensões
- mbstring
- mysqi
- openssl
- pdo_sqlite
- pdo_mysql
- intl

----

### Configurações Iniciais do Projeto

> No arquivo **config > app.php** alterar as configurações de local e timezone
- 'defaultLocale' => env('APP_DEFAULT_LOCALE', 'pt_BR')
- 'defaultTimezone' => env('APP_DEFAULT_TIMEZONE', 'America/Sao_Paulo')

> No arquivo **config > app_local.php** alterar configurações de banco de dados, definindo host, username, password e database

> No arquivo **config > bootstrap.php** incluir configuração para formatação de datas e valores numéricos

```php
use Cake\Database\TypeFactory;
```

> Mais para o final do arquivo **config > bootstrap.php**, insira as linhas

```php
TypeFactory::build('date')->useLocaleParser()->setLocaleFormat('dd/MM/yyyy');
TypeFactory::build('datetime')->useLocaleParser()->setLocaleFormat('dd/MM/yyyy hh:mm:ss');
TypeFactory::build('float')->useLocaleParser();
TypeFactory::build('decimal')->useLocaleParser();
```

> Para garantir que o framework utilizará a localização corretamente, abaixo da linha que é definido o default_locale, inseriremos o seguinte

```php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
```

----

### Utilizando o CakePHP Bake

> Caso utilize mais de uma versão do php na mesma máquina, é preciso alterar o arquivo **bin > cake.bat** mudando o nome do executavél de "php" para "php7", por exemplo, conforme abaixo

```php
php7 "%lib%cake.php" %*
```

> No PowerShell, teste se o cake está funcionando via CLI, indo no diretório de seu projeto e digitando
- .\bin\cake

> Para testar se CakePHP Bake está funcionando, digitar no PowerShell. Ao fazer isso ele já vai listar todas as entidades que ele localizar do Banco de Dados
- .\bin\cake bake all

> Para que o CakePHP Bake crie os arquivos de CRUD de cada entidade, digitar no PowerShell
- .\bin\cake bake all Ators
- .\bin\cake bake all AtorsFilmes
- .\bin\cake bake all Criticas
- .\bin\cake bake all Filmes
- .\bin\cake bake all Generos
- .\bin\cake bake all Usuarios

----

## Migração do CakePHP 2 Para o CakePHP 4

### Migrando Layouts

> O procedimento basicamente é pegar os arquivos .CTP do projeto na versão antiga e renomear para .PHP
- Copiar o arquivo **View > Layouts > bootstrap.ctp** do projeto antigo para do novo projeto **templates > layout** do projeto novo e alterar a extensão do arquivo, como mencionado anteriormente
> Repetir o procedimento para o arquivo **View > Layouts > login.ctp** do projeto antigo


----

# CakePHP Application Skeleton

[![Build Status](https://img.shields.io/github/workflow/status/cakephp/app/CakePHP%20App%20CI/master?style=flat-square)](https://github.com/cakephp/app/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%207-brightgreen.svg?style=flat-square)](https://github.com/phpstan/phpstan)

A skeleton for creating applications with [CakePHP](https://cakephp.org) 4.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephp/app
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist cakephp/app myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Update

Since this skeleton is a starting point for your application and various files
would have been modified as per your needs, there isn't a way to provide
automated upgrades, so you have to do any updates manually.

## Configuration

Read and edit the environment specific `config/app_local.php` and setup the 
`'Datasources'` and any other configuration relevant for your application.
Other environment agnostic settings can be changed in `config/app.php`.

## Layout

The app skeleton uses [Milligram](https://milligram.io/) (v1.3) minimalist CSS
framework by default. You can, however, replace it with any other library or
custom styles.
