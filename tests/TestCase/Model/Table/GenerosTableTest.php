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
        $saved = $this->Genero->save($data);
        $this->assertFalse($saved);

        $data = array('nome' => '');
        $saved = $this->Genero->save($data);
        $this->assertFalse($saved);

        $data = array('nome' => '   ');
        $saved = $this->Genero->save($data);
        $this->assertFalse($saved);

        $data = array('nome' => '12');
        $saved = $this->Genero->save($data);
        $this->assertFalse($saved);
    }

    public function testNotUniqueNome() {
        $data = array('nome' => 'Aventura');
        $saved = $this->Genero->save($data);
        $this->assertFalse($saved);
    }
}
