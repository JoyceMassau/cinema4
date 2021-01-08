# Pdf

Plugin do Make Pdf para Cakephp Apps

## Instalação

Clone o projeto na pasta /[APP_DIR]/plugins e faça o checkout do branch `Cake4`:

```
git clone git@github.com:aelian-repo/Pdf.git Pdf
git checkout Cake4
```

Adicione o Pdf Plugin e o MakePdf no `composer.json` do app:

```
"require": {
    "aelian/make-pdf": "dev-master"
},
"autoload": {
    "psr-4": {
        "Pdf\\": "plugins/Pdf/src/",
        "Pdf\\MakePdf\\": "vendor/aelian/make-pdf/lib/"
    }
},
"autoload-dev": {
    "psr-4": {
        "Pdf\\Test\\": "plugins/Pdf/tests/"
    }
}
```

Execute o composer na pasta do app:

```
php composer.phar dump-autoload
```

Carregue o plugin no método `bootstrap()` do `Application.php` do app:

```
$this->addPlugin('Pdf');
```

## Como funciona

Declare o Report e o Document no `initialize()` do `AppController`:

```
$this->viewBuilder()->setHelpers(['Pdf.Report']);        
$this->viewBuilder()->setHelpers(['Pdf.Document']);        
```

Execute a impressão no arquivo de template:

```
//exemplo:
$settings = [
    'orientation' => 'P',
    'templateFile' => 'template.xml',
    'records' => $records
];

$this->Report->create($settings);
```
