<?php


namespace Bbmin\Paginator;

use Settings\Entity\Repository\CountryRepository;

class CountryAdapter implements \Laminas\Paginator\Adapter\AdapterInterface
{
    /**
     * @var CountryRepository;
     */
    private $repository;


    /**
     * @inheritDoc
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return $this->repository->getItems($offset, $itemCountPerPage);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->repository->count();
    }

    public function setRepository($repo){
        $this->repository = $repo;
        return $this;
    }

}