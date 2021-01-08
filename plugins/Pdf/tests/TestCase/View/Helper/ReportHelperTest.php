<?php
declare(strict_types=1);

namespace Pdf\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Pdf\View\Helper\ReportHelper;

/**
 * Pdf\View\Helper\ReportHelper Test Case
 */
class ReportHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Pdf\View\Helper\ReportHelper
     */
    protected $Report;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Report = new ReportHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Report);

        parent::tearDown();
    }
}
