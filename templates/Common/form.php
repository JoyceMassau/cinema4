<?php
$actionName = $this->request->getparam('action');
$form = $this->fetch('formFields');
if ($actionName != 'view') {
    $form .= $this->Form->submit('Gravar', array('class' => 'btn btn-success mr-3', 'div' => false, 'update' => '#content'));
}
$form .= $this->Html->link('Voltar', ['action' => 'index'], array('class' => 'btn btn-secondary', 'update' => '#content'));
$form .= $this->Form->end();

echo $this->Html->tag('h1', $this->fetch('title'));
echo $form;

$this->Js->buffer('$(".form-error").addClass("is-invalid");');

if ($this->request->is('ajax')) {
    echo $this->Js->writeBuffer();
}
