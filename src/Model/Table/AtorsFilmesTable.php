<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AtorsFilmes Model
 *
 * @property \App\Model\Table\FilmesTable&\Cake\ORM\Association\BelongsTo $Filmes
 * @property \App\Model\Table\AtorsTable&\Cake\ORM\Association\BelongsTo $Ators
 *
 * @method \App\Model\Entity\AtorsFilme newEmptyEntity()
 * @method \App\Model\Entity\AtorsFilme newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AtorsFilme[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AtorsFilme get($primaryKey, $options = [])
 * @method \App\Model\Entity\AtorsFilme findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AtorsFilme patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AtorsFilme[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AtorsFilme|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AtorsFilme saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AtorsFilme[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AtorsFilme[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AtorsFilme[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AtorsFilme[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AtorsFilmesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('ators_filmes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Filmes', [
            'foreignKey' => 'filme_id',
        ]);
        $this->belongsTo('Ators', [
            'foreignKey' => 'ator_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['filme_id'], 'Filmes'), ['errorField' => 'filme_id']);
        $rules->add($rules->existsIn(['ator_id'], 'Ators'), ['errorField' => 'ator_id']);

        return $rules;
    }
}
