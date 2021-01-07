<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GenerosFixture
 */
class GenerosFixture extends TestFixture
{
    public $import = array('model' => 'generos');
    
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1, 
                'nome' => 'Aventura'
            ],
        ];
        parent::init();
    }
}
