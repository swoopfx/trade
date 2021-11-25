<?php
namespace General\Event;

use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;
use Doctrine\Common\EventManager;

/**
 *
 * @author mac
 *        
 */
class SendEmailEvent implements EventManagerAwareInterface
{

    protected $eventManager;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\EventManager\EventManagerAwareInterface::setEventManager()
     *
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(
            __CLASS__,
            get_called_class()
        ));
        $this->eventManager = $eventManager;
        return $this;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\EventManager\EventsCapableInterface::getEventManager()
     *
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager());
        }
        return $this->eventManager;
    }
    
   
    
    public function sendemailToCustomer(?array $params){
        $this->getEventManager()->trigger(__FUNCTION__, $this, $params);
    }
}

