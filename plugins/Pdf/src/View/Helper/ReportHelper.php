<?php
declare(strict_types=1);

namespace Pdf\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Pdf\MakePdf\PdfReport;

/**
 * Report helper
 */
class ReportHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function create($settings)
    {
        $this->Pdf = new PdfReport();

        return $this->Pdf->create($settings);
    }    

}
