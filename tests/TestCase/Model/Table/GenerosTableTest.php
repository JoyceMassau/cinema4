<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GenerosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GenerosTable Test Case
 */
class GenerosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GenerosTable
     */
    protected $Generos;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Generos',
        'app.Filmes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Generos') ? [] : ['className' => GenerosTable::class];
        $this->Generos = $this->getTableLocator()->get('Generos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Generos);

        parent::tearDown();
    }

    public function testEmptyNome() {
        $data = array('nome' => null);
        $genero = $this->Generos->newEntity($data);
        $this->assertNotEmpty($genero->getErrors()['nome']);

        $data = array('nome' => '');
        $genero = $this->Generos->newEntity($data);
        $this->assertNotEmpty($genero->getErrors()['nome']);

        $data = array('nome' => '   ');
        $genero = $this->Generos->newEntity($data);
        $this->assertNotEmpty($genero->getErrors()['nome']);

        $data = array('nome' => '12');
        $genero = $this->Generos->newEntity($data);
        $this->assertNotEmpty($genero->getErrors()['nome']);
    }

    public function testNotUniqueNome() {
        $data = array('nome' => 'Aventura');
        $genero = $this->Generos->newEntity($data);
        $saved = $this->Generos->save($genero);
        $this->assertFalse($saved);
        $this->assertNotEmpty($genero->getErrors()['nome']);
    }
}
