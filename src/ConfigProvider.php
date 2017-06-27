<?php
namespace Adminaut\Datatype;

use Adminaut\Datatype\View\Helper\Factory\DatatypeFactory;
use Adminaut\Datatype\View\Helper\FormCollection;
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
                // form
                'formCollection'             => FormCollection::class,
                'datatypeFormSelect'           => \Adminaut\Datatype\Select\FormViewHelper::class,
                'datatypeFormCheckbox'           => \Adminaut\Datatype\Checkbox\FormViewHelper::class,
                'datatypeFormMultiCheckbox'           => \Adminaut\Datatype\MultiCheckbox\FormViewHelper::class,
                'datatypeFormMultiReference'          => \Adminaut\Datatype\MultiReference\FormViewHelper::class,
                'datatypeFormLocation'          => \Adminaut\Datatype\Location\FormViewHelper::class,
                'datatypeFormGoogleMap'          => \Adminaut\Datatype\GoogleMap\FormViewHelper::class,
                'datatypeFormGoogleStreetView'          => \Adminaut\Datatype\GoogleStreetView\FormViewHelper::class,
                'datatypeFormGooglePlaceId'          => \Adminaut\Datatype\GooglePlaceId\FormViewHelper::class,
                'datatypeFormDateTime'          => \Adminaut\Datatype\DateTime\FormViewHelper::class,
                'datatypeFormFile'          => \Adminaut\Datatype\File\FormViewHelper::class,
                'datatypeFormWysiwygTextarea' => \Adminaut\Datatype\WysiwygTextarea\WysiwygTextareaFormViewHelper::class,

                // detail
                'datatypeDetail'             => \Adminaut\Datatype\View\Helper\datatypeDetailViewHelper::class,
                'datatypeLocationDetail'    => \Adminaut\Datatype\Location\DetailViewHelper::class,
                'datatypeGoogleMapDetail'    => \Adminaut\Datatype\GoogleMap\DetailViewHelper::class,
                'datatypeGoogleStreetViewDetail'    => \Adminaut\Datatype\GoogleStreetView\DetailViewHelper::class,
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
                \Adminaut\Datatype\View\Helper\Datatype::class  => DatatypeFactory::class,

                //form
                'datatypeFormReference'          => \Adminaut\Datatype\Reference\Factory\FormViewHelperFactory::class,
            ]
        ];
    }
}
