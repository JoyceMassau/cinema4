<?php
declare(strict_types=1);

namespace Pdf\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Pdf\View\Helper\DocumentHelper;

/**
 * Pdf\View\Helper\DocumentHelper Test Case
 */
class DocumentHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Pdf\View\Helper\DocumentHelper
     */
    protected $Document;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Document = new DocumentHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Document);

        parent::tearDown();
    }
}
