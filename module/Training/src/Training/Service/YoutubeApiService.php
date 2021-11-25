<?php
namespace Training\Service;

use Doctrine\Common\Collections\Collection;
use Training\Entity\UserCourseActivity;
use Doctrine\ORM\Query;
use Training\Entity\UserTraining;
use Doctrine\ORM\EntityManager;
use Training\Entity\TrainingActivation;

/**
 *
 * @author mac
 *        
 */
class YoutubeApiService implements YoutubeProcessInterface
{

    private $videoUrl;

    private $googleApi;

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var boolean
     */
    private $hasMilestone = false;

    private $processingUserTraining;

    /**
     *
     * @var SubmitMilestoneService
     */
    private $submitMilestoneService;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     *
     * {@inheritdoc}
     *
     * @param UserTraining $userTraining            
     * @see \Training\Service\YoutubeProcessInterface::process()
     */
    public function process($userTraining)
    {
        $training = $userTraining->getTraining();
        $hasMilestone = (count($training->getTrainingMilestone()) == NULL ? FALSE : TRUE);
        
        if ($hasMilestone) {
            return $this->processMilestone($userTraining);
        } else {
            return $this->processNoMilestone($userTraining);
        }
    }

    /**
     * Evalutes if there Training is stil active and if the maximum amunt of awarded personel is withtin range
     *
     * @param UserTraining $userTraining            
     * @return boolean
     */
    private function evaluteTrainingActivation(UserTraining $userTraining)
    {
        $isEligible = false;
        $message = "Ohhhh No !!!, Our system detects you have not conformed to the activity requirements of this course, you are not eligible";
        $em = $this->entityManager;
        $trainingEntity = $userTraining->getTraining();
        $user = $userTraining->getUser();
        // check if training is still active;
        /**
         *
         * @var TrainingActivation $trainingActivationEntity
         */
        $trainingActivationEntity = $em->getRepository(TrainingActivation::class)->findOneBy([
            "training" => $trainingEntity->getId(),
            "isActive" => TRUE
        ], [
            'id' => "DESC"
        ]);
        if ($trainingActivationEntity == NULL) {
            
            $message = "Training is no longer active please we will notify when we have reactivated thid training";
            return [
                "isEligible" => $isEligible,
                "messages" => $message
            ];
        } else {
            $maximumCount = $trainingActivationEntity->getMaximumCount();
            $userTrainingCount = $trainingActivationEntity->getUsersAwardedCount();
            if (($userTrainingCount + 1) <= $maximumCount) {
                $isEligible = TRUE;
                
                
                $trainingActivationEntity->setUsersAwardedCount($userTrainingCount +1);
                $em->persist($trainingActivationEntity);
                $em->flush();
                return [
                    "isEligible" => $isEligible,
                    "messages" => $message
                ];
            }
        }
        
        /*
         * if so get the maximumamount of awardee on this prorammes
         * if not return not-eligile and throw an message
         */
        return [
            "isEligible" => $isEligible,
            "messages" => $message
        ];
    }

    private function getVideoIdFromUrl($url)
    {
        $id = str_replace("https://www.youtube.com/embed/", "", $url);
        return $id;
    }

    /**
     *
     * @param unknown $userTraining            
     * @return string[]|boolean[]
     */
    private function processMilestone($userTraining)
    {
        $userActivitySeconds = $this->totalTimeUsedByUserOnTraining($userTraining);
        
        $youtubeTotalTime = $this->totalVideoUrlTime($userTraining);
        $isEligible = false;
        $message = "";
        $userActivitySeconds = $this->totalTimeUsedByUserOnTraining($userTraining);
        
        $youtubeTotalTime = $this->totalVideoUrlTime($userTraining);
        if ($userActivitySeconds < $youtubeTotalTime) {
            return [
                "isEligible" => $isEligible,
                "messages" => $message
            ];
        } else {
            return $this->evaluteTrainingActivation($userTraining);
        }
        return [
            "isEligible" => $isEligible,
            "messages" => $message
        ];
    }

    /**
     * This process the training that has no milestone
     *
     * @return boolean
     */
    private function processNoMilestone($userTraining)
    {
        $isEligible = false;
        $message = "";
        $userActivitySeconds = $this->totalTimeUsedByUserOnTraining($userTraining);
        
        $youtubeTotalTime = $this->totalVideoUrlTime($userTraining);
        if ($userActivitySeconds < $youtubeTotalTime) {
            $isEligible = false;
        } else {
            $isEligible = true;
        }
        return [
            "isEligible" => $isEligible,
            "messages" => $message
        ];
    }

    /**
     * This calculates total time used by the user in going through the training
     *
     * @param UserTraining $userTraining            
     * @return number
     */
    private function totalTimeUsedByUserOnTraining($userTraining)
    {
        $em = $this->entityManager;
        
        $lowestDate = "";
        $highestDate = "";
        // $courseActivity = $userTraining->getCourseActivity();
        
        $repo = $em->getRepository(UserCourseActivity::class);
        $takenCourses = $repo->createQueryBuilder("c")
            ->select([
            "c",
            "co"
        ])
            ->where("c.userTraining = :training")
            ->leftJoin("c.course", "co")
            ->setParameters([
            "training" => $userTraining->getId()
        ])
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        
        $list = array_column($takenCourses, "createdOn");
        $lowestDate = min($list);
        $highestDate = max($list);
        
        $datetimeDifference = $lowestDate->diff($highestDate);
        
        $daysInSecs = $datetimeDifference->format('%r%a') * 24 * 60 * 60;
        $hoursInSecs = $datetimeDifference->h * 60 * 60;
        $minsInSecs = $datetimeDifference->i * 60;
        $seconds = $daysInSecs + $hoursInSecs + $minsInSecs + $datetimeDifference->s;
        return $seconds;
    }

    /**
     * This calculates the training Video total url time from youtube
     *
     * @param UserTraining $userTraining            
     * @return number
     */
    private function totalVideoUrlTime($userTraining)
    {
        $total = 0;
        $trainingEntity = $userTraining->getTraining();
        foreach ($trainingEntity->getProgrammes() as $programes) {
            for ($i = 0; $i < (count($programes->getCourse()) - 1); $i ++) {
                
                $total += $this->getYoutubeVideoSeconds(($programes->getCourse())[$i]->getVideo());
            }
        }
        return $total;
    }

    /**
     * Returns the number of seconds a video runs
     *
     * @return number
     */
    private function getYoutubeVideoSeconds($videoUrl)
    {
        $videoId = $this->getVideoIdFromUrl($videoUrl);
        $videoDetails = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=" . $videoId . "&part=contentDetails%2Cstatistics&key=" . $this->googleApi . "");
        $videoDetailsArray = json_decode($videoDetails, true);
        
        // foreach ($VidDuration['items'] as $vidTime)
        // {
        // $VidDuration= $vidTime['contentDetails']['duration'];
        // }
        
        $videoItem = $videoDetailsArray['items'][0];
        $VidDuration = $videoItem['contentDetails']['duration'];
        $pattern = '/PT(\d+)M(\d+)S/';
        preg_match($pattern, $VidDuration, $matches);
        $seconds = $matches[1] * 60 + $matches[2];
        return $seconds;
    }

    /**
     *
     * @return the $videoUrl
     */
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /**
     *
     * @return the $googleApi
     */
    public function getGoogleApi()
    {
        return $this->googleApi;
    }

    /**
     *
     * @param field_type $videoUrl            
     */
    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;
        return $this;
    }

    /**
     *
     * @param field_type $googleApi            
     */
    public function setGoogleApi($googleApi)
    {
        $this->googleApi = $googleApi;
        return $this;
    }

    /**
     *
     * @return the $hasMilestone
     */
    public function getHasMilestone()
    {
        return $this->hasMilestone;
    }

    /**
     *
     * @param boolean $hasMilestone            
     */
    public function setHasMilestone($hasMilestone)
    {
        $this->hasMilestone = $hasMilestone;
        return $this;
    }

    /**
     *
     * @param field_type $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }
}

