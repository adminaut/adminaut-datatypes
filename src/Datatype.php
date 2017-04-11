<?php
namespace Adminaut\Datatype;


use Zend\Form\Element;

trait Datatype
{
    /**
     * @var bool
     */
    protected $listed = false;

    /**
     * @var bool
     */
    protected $primary = false;



    /**
     * @return bool
     */
    public function isListed()
    {
        return $this->listed;
    }

    /**
     * @param bool $listed
     */
    public function setListed(bool $listed)
    {
        $this->listed = $listed;
    }

    /**
     * @return bool
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * @param bool $primary
     */
    public function setPrimary(bool $primary)
    {
        $this->primary = $primary;
    }



    /**
     * @param  array $options
     * @return Element
     */
    public function setOptions($options)
    {
        if (isset($options['listed'])) {
            $this->setListed($options['listed']);
        } else {
            $options['listed'] = $this->isListed();
        }

        if (isset($options['primary'])) {
            $this->setPrimary($options['primary']);
        } else {
            $options['primary'] = $this->isPrimary();
        }

        parent::setOptions($options);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getListedValue()
    {
        return $this->getValue();
    }

    /**
     * @return mixed
     */
    public function getInsertValue()
    {
        return $this->getValue();
    }

    /**
     * @return mixed
     */
    public function getEditValue()
    {
        return $this->getValue();
    }
}