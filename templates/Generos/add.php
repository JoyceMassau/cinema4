<?php
$this->extend('/Common/form');

$this->assign('title', 'Novo Gênero');

$formFields = $this->element('formCreate');
$formFields .= $this->Form->control('nome', array(
    'type' => 'text',
    'label' => array('text' => 'Gênero'),
    'div' => array('class' => 'form-group col-md-6'),
    'class' => 'form-control',
));

$this->assign('formFields', $formFields);