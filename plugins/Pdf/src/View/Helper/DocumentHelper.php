<?php
declare(strict_types=1);

namespace Pdf\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Pdf\Vendor\MakePdf;

/**
 * Document helper
 */
class DocumentHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function create($settings)
    {
        $this->Pdf = new PdfDocument();

        return $this->Pdf->create($settings);
    }    

}
