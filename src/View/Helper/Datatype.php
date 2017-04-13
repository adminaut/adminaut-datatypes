<?php
namespace Adminaut\Datatype\View\Helper;

use TwbBundle\Form\View\Helper\TwbBundleFormElement;
use TwbBundle\Options\ModuleOptions;

class Datatype extends TwbBundleFormElement
{
    public function __construct(ModuleOptions $options)
    {
        $this->addType('datatypeCheckbox', 'datatypeFormCheckbox');
        $this->addType('datatypeMultiCheckbox', 'datatypeFormMultiCheckbox');
        $this->addType('datatypeReference', 'datatypeFormReference');
        $this->addType('datatypeMultiReference', 'datatypeFormMultiReference');

        parent::__construct($options);
    }

}