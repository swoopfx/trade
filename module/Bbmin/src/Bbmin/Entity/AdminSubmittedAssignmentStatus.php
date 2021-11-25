<?php
namespace Bbmin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="admin_submitted_assignment_status")
 * @author mac
 * INITIATED / Submmited
 * PROCESSING
 * COMPLETED
 * DISBURSED FUNDS;
 *        
 */
class AdminSubmittedAssignmentStatus
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\Column(name="status", type="string", nullable=false)
     * @var string
     */
    private $status;
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    public function getStatus(){
        return $this->status;
    }
}

