<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AtorsFilmes Controller
 *
 * @property \App\Model\Table\AtorsFilmesTable $AtorsFilmes
 * @method \App\Model\Entity\AtorsFilme[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AtorsFilmesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Filmes', 'Ators'],
        ];
        $atorsFilmes = $this->paginate($this->AtorsFilmes);

        $this->set(compact('atorsFilmes'));
    }

    /**
     * View method
     *
     * @param string|null $id Ators Filme id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $atorsFilme = $this->AtorsFilmes->get($id, [
            'contain' => ['Filmes', 'Ators'],
        ]);

        $this->set(compact('atorsFilme'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $atorsFilme = $this->AtorsFilmes->newEmptyEntity();
        if ($this->request->is('post')) {
            $atorsFilme = $this->AtorsFilmes->patchEntity($atorsFilme, $this->request->getData());
            if ($this->AtorsFilmes->save($atorsFilme)) {
                $this->Flash->success(__('The ators filme has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ators filme could not be saved. Please, try again.'));
        }
        $filmes = $this->AtorsFilmes->Filmes->find('list', ['limit' => 200]);
        $ators = $this->AtorsFilmes->Ators->find('list', ['limit' => 200]);
        $this->set(compact('atorsFilme', 'filmes', 'ators'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ators Filme id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $atorsFilme = $this->AtorsFilmes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $atorsFilme = $this->AtorsFilmes->patchEntity($atorsFilme, $this->request->getData());
            if ($this->AtorsFilmes->save($atorsFilme)) {
                $this->Flash->success(__('The ators filme has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ators filme could not be saved. Please, try again.'));
        }
        $filmes = $this->AtorsFilmes->Filmes->find('list', ['limit' => 200]);
        $ators = $this->AtorsFilmes->Ators->find('list', ['limit' => 200]);
        $this->set(compact('atorsFilme', 'filmes', 'ators'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ators Filme id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $atorsFilme = $this->AtorsFilmes->get($id);
        if ($this->AtorsFilmes->delete($atorsFilme)) {
            $this->Flash->success(__('The ators filme has been deleted.'));
        } else {
            $this->Flash->error(__('The ators filme could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
