<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->viewBuilder()->setLayout('bootstrap');
        $this->viewBuilder()->setHelpers(['Js', 'Pdf.Report']);

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');

    }
    
    public function beforeFilter() {
        // $this->Auth->mapActions(['read' => ['report']]);
    }

    public function index() {
        $entity = $this->{getModelName()}->newEmptyEntity();
        $this->set(compact('entity'));
        $this->setPaginateConditions();
        try {
            $this->set($this->getControllerName(), $this->paginate());        
        } catch (NotFoundException $e) {
            $this->redirect('/' . $this->getControllerName());
        }        
    }

    public function add() {
        $entity = $this->{getModelName()}->newEmptyEntity();
        if ($this->request->is('post')) {
            $entity = $this->{$this->getModelName()}->patchEntity($entity, $this->getData());
            if ($this->{$this->getModelName()}->save($entity)) {
                $this->Flash->bootstrap('Gravado com sucesso!', array('key' => 'success'));
                $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('entity'));
    }

    public function edit($id = null) {
        $entity = $this->getEditEntity($id);
        if ($this-request->is(['post', 'patch', 'put'])) {
            $entity = $this->{$this->getModelName()}->patchEntity($entity, $this->request->getData());
            if ($this->{$this->getModelName()}->save($entity)) {
                $this->Flash->bootstrap('Alterado com sucesso!', array('key' => 'success'));
                $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('entity'));
    }

    public function view($id = null) {
        $entity = $this->getEditEntity($id);
        $this->set(compact('entity'));
    }

    public function delete($id) {
        $entity = $this->getEditEntity($entity);
        $this->Flash->bootstrap('Excluído com sucesso!', array('key' => 'warning'));
        $this->redirect(['action' => 'index']);
    }

    public function report() {
        $this->layout = false;
        $this->response->type('pdf');
        $this->set($this->getControllerName(), $this->paginate());        
    }

    public function getControllerName() {
        return \Cake\Utility\Inflector::underscore($this->request->params['controller']);
    }

    public function getModelName() {
        return $this->request->params['controller'];
    }

    public function setFilmes() {
        $filme = ClassRegistry::init('Filme');
        $this->set('filmes', $filme->find('list', array('fields' => array('Filme.id', 'Filme.nome'))));
    }
}
