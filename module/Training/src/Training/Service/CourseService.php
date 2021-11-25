<?php
namespace Training\Service;

/**
 *
 * @author otaba
 *        
 */
class CourseService
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public static function generateCourseUid(){
        return uniqid(time());
    }
}

