<?php
declare(strict_types=1);

namespace App\Controller;

class GenerosController extends AppController
{
    public $paginate = array(
        'fields' => array('id', 'nome'),
        'conditions' => array(),
        'limit' => 10,
        'order' => array('nome' => 'asc')    
    );

    public function setPaginateConditions() {
        $nome = '';
        if ($this->request->is('post')) {
            $nome = $this->request->getData('nome');
            $this->Session->write('Genero.nome', $nome);
        } else {
            $nome = $this->Session->read('Genero.nome');
            $this->request->data('Genero.nome', $nome);
        }
        if (!empty($nome)) {
            $this->paginate['conditions']['Genero.nome LIKE'] = '%' . trim($nome) . '%';
        }
    }

    public function getEditData($id) {
        $fields = array('Genero.id', 'Genero.nome');
        $conditions = array('Genero.id' => $id);
      
        return $this->Genero->find('first', compact('fields', 'conditions'));
    }
}
