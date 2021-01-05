<?php
$this->extend('/Common/form');

$this->assign('title', 'Visualizar Gênero');

$formFields = $this->element('formCreate');
$formFields .= $this->Form->input('Genero.nome', array(
    'type' => 'text',
    'label' => array('text' => 'Gênero'),
    'div' => array('class' => 'form-group col-md-6'),
    'class' => 'form-control',
));

$this->assign('formFields', $formFields);