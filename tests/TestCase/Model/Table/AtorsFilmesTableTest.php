<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AtorsFilmesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AtorsFilmesTable Test Case
 */
class AtorsFilmesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AtorsFilmesTable
     */
    protected $AtorsFilmes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.AtorsFilmes',
        'app.Filmes',
        'app.Ators',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AtorsFilmes') ? [] : ['className' => AtorsFilmesTable::class];
        $this->AtorsFilmes = $this->getTableLocator()->get('AtorsFilmes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AtorsFilmes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
