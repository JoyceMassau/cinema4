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
- Copiar o arquivo **View > Layouts > bootstrap.ctp** do projeto antigo para **templates > layout** do projeto novo e alterar a extensão do arquivo, como mencionado anteriormente
> Repetir o procedimento para o arquivo **View > Layouts > login.ctp** do projeto antigo

----

### Migrando Views do CRUD

- Copiar os arquivos de view de cada CRUD, por exemplo, copiar o **View > Generos > add.ctp** do projeto antigo para **templates > Generos** do projeto novo e alterar a extensão do arquivo, como mencionado anteriormente

> Vamos copiar o elemento abstrato em **View > Elements > formCreate.ctp** do projeto antigo para **templates > element** do projeto novo

> **ANTES,** No create do formulário do arquivo **formCreate** passávamos o primeiro parâmetro do create como False ou o nome do Model

```php
$formCreate = $this->Form->create(false, array('inputDefaults' => $inputDefaults));
```

> Agora, devemos passar uma entidade ou null. Criaremos uma variável chamada Entidade e em cima dela verificaremos que se existir uma informação dentro da entidade, ele vai mandar a entidade, senão, manda como null

```php
$entity = !isset($entity) ? null : $entity;
$formCreate = $this->Form->create($entity, array('inputDefaults' => $inputDefaults));
```

> Na nova versão do CakePHP, a propriedade inputDefault que utilizávamos no formCreate não existe mais. Na documentação, em https://book.cakephp.org/4/en/views/helpers/form.html#customizing-the-templates-formhelper-uses podemos visualizar formas de customizar esse template. Para este caso, utilizaremos um modelo pronto que vai manter as configurações utilizadas antes, com o novo padrão que o CakePHP espera

> Em lugar do parâmetro **array('inputDefaults' => $inputDefaults)** colocaremos algumas options e se houver alguma configuração extra, ele sobrepõe, senão ele mantém as do formulário formCreate.php

```php
$options = !isset($options) ? compact('template') : array_merge(compact('templates'), $options);
$formCreate = $this->Form->create($entity,$options);
```

> Como todos as views de add do CRUD anterior extendiam de uma view padrão, o **common/form** e as do index extendiam de uma view padrão, o **common/index**, precisamos migrá-lo também. Para isto, vamos copiar os dois arquivos em **View > Common** do projeto antigo para **templates > Common** do projeto novo. No projeto novo não há um diretório Common, precisando ser criado

#### Arquivo templates > Common > form.php

> No add, edit e view abstraímos através do form
> Nesta versão do CakePHP não existe mais o **this->request->params** e para substituí-lo é usado **this->request->getParams**, porém não precisamos mais pegar o nome do parâmetro, vamos somente pegar o nome do controller

```php
$actionName = $this->request->getparam('action');
```

> Não existe mais o Helper **this->js**, precisando ser substituído. Abaixo, um exemplo de substituíção de como ficou o submit do botão

antes

```php
$form .= $this->Js->submit('Gravar', array('class' => 'btn btn-success mr-3', 'div' => false, 'update' => '#content'));
```

agora

```php
$form .= $this->Form->submit('Gravar', array('class' => 'btn btn-success mr-3', 'div' => false, 'update' => '#content'));
```

> Um exemplo de substituíção de como ficou o link do botão antes e depois do Helper **this->js** e uma refatoração para não precisar mais concatenar o botão com o nome do controller. Antes os links estavam como Js para poder utilizar o Ajax, porém isso mudou nessa nova versão do CakePHP e será abordado posteriormente

antes

```php
$form .= $this->Js->link('Voltar', '/' . $controllerName, array('class' => 'btn btn-secondary', 'update' => '#content'));
```

agora

```php
$form .= $this->Html->link('Voltar', ['action' => 'index'], array('class' => 'btn btn-secondary', 'update' => '#content'));
```

#### Arquivo templates > Common > index.php

> O elemento de criação do formulário irá mudar com a reformulação do código, conforme abaixo

antes

```php
$filtro = $this->Form->create(false, array('class' => 'form-inline'));
```

agora

```php
$filtro = $this->element('formCreate', ['options' => ['class' => 'form-inline']]);
```

> Para alterar o botão de submit devemos substituir o *Js* pelo *Form*

antes

```php
$filtro .= $this->Js->submit('Filtrar', array('class' => 'btn btn-primary mb-2', 'div' => false, 'update' => '#content'));
```

agora
```php
$filtro .= $this->Form->submit('Filtrar', array('class' => 'btn btn-primary mb-2', 'div' => false, 'update' => '#content'));
```

> Para alterar o controle de paginação

antes

```php
$this->Paginator->options(array('update' => '#content'));
$links = array(
    $this->Paginator->first('Primeira', array('class' => 'page-link')),
    $this->Paginator->prev('Anterior', array('class' => 'page-link')),
    $this->Paginator->next('Próxima', array('class' => 'page-link')),
    $this->Paginator->last('Última', array('class' => 'page-link'))
);
```

agora

```php
$this->Paginator->setTemplates([
    'first' => '<a href="{{url}}" class="page-link" update="#content">{{text}}</a>',
	'last' => '<a href="{{url}}" class="page-link" update="#content">{{text}}</a>',
    'nextActive' => '<a rel="next" href="{{url}}" class="page-link" update="#content">{{text}}</a>',
	'nextDisabled' => '<a href="" onclick="return false;" class="page-link disabled">{{text}}</a>',
	'prevActive' => '<a rel="prev" href="{{url}}" class="page-link" update="#content">{{text}}</a>',
    'prevDisabled' => '<a href="" onclick="return false;" class="page-link disabled">{{text}}</a>'
]);
$links = array(
    $this->Paginator->first('Primeira'),
    $this->Paginator->prev('Anterior'),
    $this->Paginator->next('Próxima'),
    $this->Paginator->last('Última')
);
```

> Para passar o Counter para o novo padrão, em lugar de dois pontos, passamos mais uma chave

antes

```php
$paginateCount = $this->Paginator->counter(
    '{:page} de {:pages}, mostrando {:current} registros de {:count}, começando em {:start} até {:end}'
);
```

agora

```php
$paginateCount = $this->Paginator->counter(
    '{{page}} de {{pages}}, mostrando {{current}} registros de {{count}}, começando em {{start}} até {{end}}'
);
```

> Para alterar a forma como ele pegava a URL e marcava como ativa no menu

antes

```php
$this->Js->buffer('$(".nav-item").removeClass("active");');
$this->Js->buffer('$(".nav-item a[href$=\'' . $controllerName . '\']").addClass("active");');

```

agora

```php
$controllerName = \Cake\Utility\Inflector::underscore($this->request->getParam('controller'));
$this->Js->buffer('$(".nav-item").removeClass("active");');
$this->Js->buffer('$(".nav-item a[href$=\'' . $controllerName . '\']").addClass("active");');
```

#### Exemplo de migração de arquivo Add, do CRUD de Gêneros

> Onde está **form->input** substituir por **form->controll** e não é mais necessário informar o nome da entidade, apenas o nome do campo, pois o elemento do formCreate já carrega o nome da entidade

antes

```php
$formFields .= $this->Form->input('Genero.nome');
```

depois

```php
$formFields .= $this->Form->control('nome');
```

#### Exemplo de migração de arquivo index, do CRUD de Gêneros

> Na nova versão do cake, os parâmetros de class e de div dos inputs não vão mais funcionar, sendo necessário passar um parâmetro de templates no array

antes

```php
$searchFields = $this->Form->input('Genero.nome', array(
    'required' => false,
    'label' => array('text' => 'Nome', 'class' => 'sr-only'),
    'class' => 'form-control mb-2 mr-sm-2',
    'div' => false,
    'placeholder' => 'Nome...'
));
```

depois

```php
$searchFields = $this->Form->control('nome', array(
    'required' => false,
    'label' => array('text' => 'Nome', 'class' => 'sr-only'),
    'templates' => [
        'input' => '<input type="{{type}}" name="{{name}}" class="form-control mb-2 mr-sm-2"{{attrs}}/>',
    ],
    'placeholder' => 'Nome...'
));
```

> Alteração no link

antes 

```php
$editLink = $this->Js->link('Alterar', '/generos/edit/' . $genero['Genero']['id'], array('update' => '#content'));
```

agora

```php
$editLink = $this->Html->link('Alterar', ['action' => 'edit', $genero->id], array('update' => '#content'));
```

#### Como usar javascript no CakePHP 4 

> Sem o JS Helper nessa nova versão do CakePHP a solução escolhida foi copiar o JS Helper da versão antiga e adaptar o código para poder funcionar com o CakePHP 4.
> Funcionamento: Basicamente, o arquivo em **src > View > Helper > JsHelper.php** joga todas as chamadas Javascript para um buffer e escreve o buffer dentro de um template

----

### Migrando Controllers do CRUD

> Vamos comparar o arquivo **Controller > AppController.php** do projeto antigo com o **src > Controller > AppController.php** do projeto novo. Antes, alé, do Flash e do RequestHandler, que também estão disponíveis na nova versão do CakePHP, carregávamos também o Session, o Auth e o Acl, porém estes três últimos não são mais componentes básicos do framework, eles agora são plugins
> Para setar o layout e os helpers

```php
$this->viewBuilder()->setLayout('bootstrap');
$this->viewBuilder()->setHelpers(['Js', 'Pdf.Report']);
```

> Para carregar um plugin, seguimos a documentação https://book.cakephp.org/4/en/plugins.html#loading-a-plugin, damos git clone do repositório Pdf dentro do diretório **plugin** do projeto e o repositório Make-Pdf dentro do diretório **Make-Pdf**
> Com o composer, adicionaremos o caminho completo para o plugin na seção do autoload. Iremos alterar o composer.json, adicionando uma nova nova dependência

```json
"autoload": {
        "psr-4": {
            "App\\": "src/",
            "Pdf\\": "./plugins/Pdf/scr",            
            "Pdf\\MakePdf\\": "Vendor/make-pdf/lib"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "App\\Test\\": "tests/",
            "Cake\\Test\\": "vendor/cakephp/cakephp/tests/",
            "Pdf\\": "./plugins/Pdf/scr",            
            "Pdf\\MakePdf\\": "Vendor/make-pdf/lib"
        }
    },
```

> Para dar restart no Composer, estando na raiz do diretório do projeto, dê 
php7 C:\xampp\php7\composer.phar dumpautoload, no PowerShell

> Precisamos agora carregar o plugin, para isso, no PowerShell, digitar

```bat
.\bin\cake plugin load Pdf
```

> Ao fazer isso, dentro do arquivo **src > Application.php** ele irá adicionar uma linha. Isso também pode ser feito manualmente 

```php
$this->addPlugin('Pdf');
```

> Copiaremos os demais métodos do AppController antigo e colaremos no novo projeto e iremos refatorar

> Atualmente só existe o método getData, Não existe mais a propriedade resquest->data e isso deverá ser substituído em todos os controllers da aplicação

> Vamos começar. Dentro do **src > Controller > AppController.php** criaremos uma entidade vazia e a armazenaremos dentro da variável $entity

```php
$entity = $this->{$this->getModelName()}->newEmptyEntity();
```

> Em seguida, iremos setar para que ela seja visível no formulário

```php
$this->set(compact('entity'));
```

> Antes utilizávamos o modelClass para pegar o nome do model. Atualmente não fazemos mais isso

antes

```php
public function getModelName() {
    return $this->modelClass;
}
```

agora

```php
public function getModelName() {
    return $this->request->params['controller'];
}
```

> Temos que alterar a função que utilizávamos antes para informar endereços de url, para isso utilizamos o nome do controle em underscore

antes

```php
public function getControllerName() {
    return \Cake\Utility\Inflector::underscore($this->request->params['controller']);
}
```

agora

```php
public function getControllerName() {
    return \Cake\Utility\Inflector::underscore($this->request->params['controller']);
}
```

> Para guardar a Sessão

antes

```php
$this->Session->write('Genero.nome', $nome);
```

agora

```php
$this->request->getSession()->write('nome', $nome);
```

----

### Migrando Models e Tests do CRUD

> Na nova versão do Cake não existe mais um AppModel e nem é possível rodar o teste via browser
> Table é onde você vai manipular as coleções de registros do banco de dados
> Entity é onde você vai manipular um único registro
> Para poder rodar os testes se o ambiente de desenvolvimento utiliza mais de uma versão do php é preciso alterar o arquivo em **vendor > bin > phpunit.bat** e alterar o executável, inserindo o numeral 7 após o nome do executável, da seguinte forma

```php
@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phpunit/phpunit/phpunit
php7 "%BIN_TARGET%" %*
``` 

> Como não temos mais os testes via browser, no PowerShell, digitamos

```bat
.\vendor\bin\phpunit .\tests\TestCase\Model\Table\UsuariosTableTest.php
```

É passível de [dar erro](https://github.com/JoyceMassau/cinema4#1 "dar erro") ao tentar executar o script caso não tenha o PHPUnit instalado ou confugurado as variáveis de ambiente.

Irá [dar erro](https://github.com/JoyceMassau/cinema4#2 "dar erro") também caso não tenha configurado o ambiente de testes no banco de dados ou [não tenha criado o banco de dados de teste no PHP MyAdmin](https://github.com/JoyceMassau/cinema4#3 "não tenha criado o banco de dados de teste no PHP MyAdmin")

#### Validação em Duas Etapas
> Na nova versão do Cake a validação [se dá em duas etapas](http://https://book.cakephp.org/4/en/orm/validation.html "se dá em duas etapas")
> Agora não é mais preciso dar o save no registro, substituindo por uma nova entidade

antes

```php
public function testEmptyNome() {
    $data = array('nome' => null);
    $saved = $this->Genero->save($data);
    $this->assertFalse($saved);
}
```

agora

```php
public function testEmptyNome() {
    $data = array('nome' => null);
        $genero = $this->Generos->newEntity($data);
        $this->assertNotEmpty($generos->getErros()['nome']);
}
```

> O testNotUniqueNome não é um *validation* é um *rule.* Após criar a entidade, precisamos forçar o save

antes

```php
public function testNotUniqueNome() {
    $data = array('nome' => 'Aventura');
    $saved = $this->Genero->save($data);
    $this->assertFalse($saved);
}
```

agora

```php
public function testNotUniqueNome() {
    $data = array('nome' => 'Aventura');
    $genero = $this->Generos->newEntity($data);
    $saved = $this->Generos->save($genero);
    $this->assertNotEmpty($genero->getErrors()['nome']);
}
```

Podemos fazer outro test também verificando se é false e rodar o teste novamente, que irá falhar, pois não aplicamos as regras de negócio

```php
public function testNotUniqueNome() {
    $data = array('nome' => 'Aventura');
    $genero = $this->Generos->newEntity($data);
    $saved = $this->Generos->save($genero);
    $this->assertNotEmpty($genero->getErrors()['nome']);
}
```

> Devemos alterar o **tests > Fixture > GenerosFixture.php** sobrescrevendo o disponível 
> Apaga os fields do schema fixo que ele utiliza em **tests > Fixture > GenerosFixture.php** para que ele sempre utilize o do banco de dados. Para isso, colocar no lugar dos fields, o *import* que utilizávamos no sistema na versão antiga sem a parte do *records => false*

antes

```php
public $fields = [
    'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
    'nome' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
    '_constraints' => [
        'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
    ],
    '_options' => [
        'engine' => 'InnoDB',
        'collation' => 'utf8_general_ci'
    ],
];
```

agora

```php
public $import = array('model' => 'generos');
```    

> Para aplicar as validações no model, no novo projeto vamos em **src > Model > Table > GenerosTable.php** e verificamos as *validator* que o cake bake criou. Neste caso estaremos mantendo as outras validações e alterando apenas a *allowEmptyString*

antes

```php
->allowEmptyString('nome');
```

agora

```php
->notBlank('nome', __('Informe o nome'))
->minLength('nome', 3, __('Informe um nome com mais de 2 dígitos'));
```

> Após a inserção da validação e rodar os testes novamente, só irá falhar no testNotUniqueNome, e como agora o [isUnique é uma rule e não mais uma validation, precisamos fazer alteração](http://https://book.cakephp.org/4/en/orm/validation.html#creating-a-rules-checker "isUnique é uma rule e não mais uma validation, precisamos fazer alteração")
> Para isso é necessário criar um método builRules, e todas as rules que criarmos no modelo adicionaremos nele

```php
public function buildRules(RulesChecker $rules): RulesChecker
{
    $rules->add($rules->isUnique(['nome'], __('Nome já existe')));

    return $rules;
}
```

> Na documentação há outros exemplos de rule além do isUnique, mas é possível criar também outras regras de negócio próprias. Ao rodar os testes agora *( .\vendor\bin\phpunit .\tests\TestCase\Model\Table\GenerosTableTest.php )*, deverá dar certo.

## Possíveis erros

#### 1
> C:\xampp\htdocs\cinema4> .\vendor\phpunit\ .\tests\TestCase\Model\ .\vendor\phpunit\ : O termo '\vendor\phpunit\' não é reconhecido como nome de cmdlet, função, arquivo de script ou programa operável. Verifique a grafia do nome ou, se um caminho tiver sido incluído, veja se o caminho está correto e tente novamente.

**Correção:** 
- instalar phpunit pelo link https://book.cakephp.org/4/pt/development/testing.html#instalando-o-phpunit utilizando o composer: *php7 C:\xampp\php7\composer.phar require --dev phpunit/phpunit*
- Comando no PowerShell para executar os testes: *.\vendor\bin\phpunit .\tests\TestCase\Model\*


#### 2
> Connection to Mysql could not be established: SQLSTATE[HY000] [1045] Access denied for user 'my_app'@'localhost' (using password: YES)

**Correção:** 
- Para configurar o ambiente de testes, iremos alterar o arquivo **config > app_local.php**, alterando o username e password conforme consta em nosso banco de dados, e o nome do database para *'test_cinema'*

#### 3
> Connection to Mysql could not be established: SQLSTATE[HY000] [1049] Unknown database 'test_cinema'

**Correção:** 
- Criar banco de dados chamado 'test_cinema' no PHPMyAdmin. Não é necessário criar nenhuma tabela, ao executar os testes o framework se encarregará da criação


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
