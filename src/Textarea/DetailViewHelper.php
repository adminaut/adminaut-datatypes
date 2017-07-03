<?php

namespace Adminaut\Datatype\Textarea;

use Adminaut\Datatype\Textarea;
use Zend\Form\ElementInterface;
use Zend\Form\Exception\InvalidArgumentException;
use Zend\Form\View\Helper\AbstractHelper;

/**
 * Class DetailViewHelper
 * @package Adminaut\Datatype\Textarea
 */
class DetailViewHelper extends AbstractHelper
{
    /**
     * @var array
     */
    protected $allowedTags = [
        '<p>',
        '<b>',
        '<strong>',
        '<u>',
        '<i>',
        '<em>',
        '<ul>',
        '<ol>',
        '<li>',
        '<a>',
    ];

    /**
     * @param ElementInterface|null $element
     * @return DetailViewHelper|string
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (null === $element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * @param $element
     * @return string
     */
    public function render($element)
    {
        if (!$element instanceof Textarea) {
            throw new InvalidArgumentException(sprintf(
                '%s requires that the element is of type ' . Textarea::class,
                __METHOD__
            ));
        }

        $value = $element->getValue();

        if (empty($value)) {
            return '';
        }

        // http://php.net/strip_tags
        $value = strip_tags($value, implode($this->allowedTags));

        // todo: change code above to something like code below, for security reasons

        //$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        //foreach ($this->allowedTags as $tag) {
        //    $value = str_replace("&lt;" . $tag . "&gt;", "<" . $tag . ">", $value);
        //    $value = str_replace("&lt;/" . $tag . "&gt;", "</" . $tag . ">", $value);
        //}

        return '<div class="textarea-detail">' . $value . '</div>';
    }
}