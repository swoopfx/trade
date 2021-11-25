<?php
namespace Training\Service;

use Doctrine\ORM\EntityManager;
use Training\Entity\Programmes;

/**
 *
 * @author otaba
 *        
 */
class ProgrammesService
{

    /**
     * 
     * @var EntityManager
     */
    private $entityManager;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public static function generateProgrammesUid(){
        return uniqid("prg");
    }
    
    public function getProgrammesByTrainingId(Int $id){
        $em = $this->entityManager;
        /**
         * 
         * @var array $programmesArray
         */
        $programmesArray = $em->getRepository(Programmes::class)->findProgrammesByTrainingid($id);
        return $programmesArray;
    }
    

    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    
    
}

