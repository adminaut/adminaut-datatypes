<?php
namespace Adminaut\Datatype;

use Adminaut\Datatype\View\Helper\Factory\DatatypeFactory;
use Adminaut\Datatype\View\Helper\FormRow;

class ConfigProvider
{
    /**
     * Return general-purpose zend-i18n configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
            'view_helpers' => $this->getViewHelperConfig(),
        ];
    }

    /**
     * Return application-level dependency configuration.
     *
     * @return array
     */
    public function getDependencyConfig()
    {
        return [
            'factories' => [
                'FormElementManager' => DatatypeManagerFactory::class,
            ],
        ];
    }

    /**
     * Return zend-form helper configuration.
     *
     * Obsoletes View\HelperConfig.
     *
     * @return array
     */
    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'datatypeFormCheckbox'           => \Adminaut\Datatype\Checkbox\FormViewHelper::class,
                'datatypeFormReference'          => \Adminaut\Datatype\Reference\FormViewHelper::class,
            ],
            'aliases' => [
                'formrow'                    => FormRow::class,
                'form_row'                   => FormRow::class,
                'formRow'                    => FormRow::class,
                'FormRow'                    => FormRow::class,
                'datatype'                   => \Adminaut\Datatype\View\Helper\Datatype::class,
            ],
            'factories' => [
                FormRow::class               => View\Helper\Factory\FormRowFactory::class,
                \Adminaut\Datatype\View\Helper\Datatype::class  => DatatypeFactory::class
            ]
        ];
    }
}
