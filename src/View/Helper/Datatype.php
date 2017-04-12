<?php
namespace Adminaut\Datatype\View\Helper;

use TwbBundle\Form\View\Helper\TwbBundleFormElement;
use TwbBundle\Options\ModuleOptions;

class Datatype extends TwbBundleFormElement
{
    public function __construct(ModuleOptions $options)
    {
        $this->addType('single_checkbox', 'datatypeFormCheckbox');
        $this->addType('datatypeReference', 'datatypeFormReference');

        parent::__construct($options);
    }

}