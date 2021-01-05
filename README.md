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

> No arquivo **config > app_local.php** alterar configurações de banco de dados, definindo host, username, password e database

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
