<?php
namespace Training\Service;

use General\Service\GeneralService;
use CsnUser\Entity\User;
use Training\Entity\Training;
use Training\Entity\Course;
use Training\Entity\Programmes;

/**
 *
 * @author mac
 *        
 */
class UserValidationService
{

    /**
     *
     * @var EntityManager;
     */
    private $entityManager;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var User
     */
    private $userEntity;

    /**
     *
     * @var Training
     */
    private $trainingEntity;

    /**
     *
     * @var Course
     */
    private $courseEntity;

    /**
     *
     * @var Programmes
     */
    private $programmeEntity;

    /**
     * This determines if the user training is valid
     * @var boolean
     */
    private $isValid;
    
    // TODO - Insert your code here
    
    
    
    /**
     */
    public function __construct()
    {
        
        $this->isValid = false;
    }

    /**
     * This validates if the user took the course based on aggregated timeline of all courses
     */
    public function userCourseActivityValidation()
    {}
}

