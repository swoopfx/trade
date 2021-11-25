<?php
namespace Bbmin\Paginator;

use Laminas\Paginator\Adapter\AdapterInterface;
use Training\Entity\Repository\TrainingRepository;

class TrainingAdminPaginator implements AdapterInterface
{
    /**
     * 
     * @var TrainingRepository
     */
   private  $trainingRepository;
    /**
     * {@inheritDoc}
     * @see \Laminas\Paginator\Adapter\AdapterInterface::getItems()
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return $this->trainingRepository->getAdminItems($offset, $itemCountPerPage);
        
    }

    /**
     * {@inheritDoc}
     * @see Countable::count()
     */
    public function count()
    {
        return $this->trainingRepository->countAdmin();
        
    }
    /**
     * @return the $trainingRepository
     */
    public function getTrainingRepository()
    {
        return $this->trainingRepository;
    }

    /**
     * @param field_type $trainingRepository
     */
    public function setTrainingRepository($trainingRepository)
    {
        $this->trainingRepository = $trainingRepository;
        return $this;
    }


}

