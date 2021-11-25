<?php
namespace Training\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * This Defines the maximum amount of people that can get reward for each training
 * It also provides some statistics too      
 *  @ORM\Entity
 *  @ORM\Table(name="training_bound_statistics")
 * @author mac
 *        
 */
class TrainingBoundStatistics
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * 
     * @var Training
     */
    private $training;
    
    /**
     * @ORM\Column(name="training_maximum_name", type="text", nullable=true)
     * @var string
     */
    private $trainingMaximumName;
    
    /**
     * A description of the training
     * @ORM\Column(name="training_maximum_desc", type="text", nullable=true)
     * @var string
     */
    private $trainingMaximumDesc; 
    
    /**
     * this is the maximum amount of people that can be reached
     * @ORM\Column(name="maximum_registration", type="string", nullable=true)
     * @var string
     */
    private $maximumRegistration;
    
    /**
     * This is the total 
     * @ORM\Column(name="total_registereed", type="string", nullable=true)
     * @var string
     */
    private $totalRegistered;
    
     /**
     * @ORM\Column(name="created_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $createdOn;

    /**
     * @ORM\Column(name="updated_on", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updated;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
}

