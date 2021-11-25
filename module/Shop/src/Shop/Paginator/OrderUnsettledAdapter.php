<?php


namespace Shop\Paginator;


class OrderUnsettledAdapter implements \Laminas\Paginator\Adapter\AdapterInterface
{
    
    private $respository;

    /**
     * @inheritDoc
     */
    public function getItems($offset, $itemCountPerPage)
    {
        // TODO: Implement getItems() method.
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        // TODO: Implement count() method.
    }
    /**
     * @param field_type $respository
     */
    public function setRespository($respository)
    {
        $this->respository = $respository;
        return $this;
    }

}