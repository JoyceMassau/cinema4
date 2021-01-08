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
            $this->request->getSession()->write('nome', $nome);
        } else {
            $nome = $this->request->getSession()->read('nome');
        }
        if (!empty($nome)) {
            $this->paginate['conditions']['nome LIKE'] = '%' . trim($nome) . '%';
        }
    }

    public function getEditEntity($id) {
        $fields = ['id', 'nome'];
        $contain = [];
      
        return $this->Generos->get($id, compact('fields', 'contain'));
    }
}
