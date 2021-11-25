<?php
namespace General\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use General\Service\RedisService;

/**
 *
 * @author otaba
 *        
 */
class RedisServiceFactory implements FactoryInterface
{

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\ServiceManager\FactoryInterface::createService()
     *
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        
        $redisService = new RedisService();
//         $redisCache = $serviceLocator->get("General\Cache\Redis");
//         $redisService->setRedisCache($redisCache);
        return $redisService;
    }
}

