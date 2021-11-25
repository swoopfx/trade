<?php
namespace General\View\Helper;

use Laminas\View\Helper\AbstractHelper;

class FieldsetViewHelper extends AbstractHelper
{

    public function __construct()
    {

        // TODO - Insert your code here
    }

    /**
     * 
     * @param string $label
     * @param string $input
     * @param string $divLabelClass
     * @param string $divInputClass
     * @return string
     */
    public function __invoke(string $label, $input, string $divLabelClass="col-5 col-sm-4", string $divInputClass = "col-7 col-sm-8"){
        return "<div class='row no-gutters'>
              <div class='{$divLabelClass}'>
               {$label}
              </div><!-- col-4 -->
              <div class='{$divInputClass}'>
                {$input}
              </div><!-- col-8 -->
            </div><!-- row -->";
    }
}

