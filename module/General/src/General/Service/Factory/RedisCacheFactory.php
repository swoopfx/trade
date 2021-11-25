<?php
namespace General\Service\Factory;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\Cache\Storage\Adapter\RedisOptions;
use Laminas\Cache\Storage\Adapter\Redis;

/**
 *
 * @author otaba
 *        
 */
class RedisCacheFactory implements FactoryInterface
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
        
       $config = $serviceLocator->get("config");
       $redisConfig = $config["redis"];
       $redisOptions = new RedisOptions();
       $redisOptions->setServer([
           "host"=>(getenv("APP_ENV") == "development" ? $redisConfig["dev"]["host"] : $redisConfig["prod"]["host"]),
           "port"=>(getenv("APP_ENV") == "development" ? $redisConfig["dev"]["port"] : $redisConfig["prod"]["port"]),
       ]);
       
       $redisOptions->setLibOptions([
           \Redis::OPT_SERIALIZER=>\Redis::SERIALIZER_PHP
       ]);
       
       $redis = new Redis($redisOptions);
       
       return $redis;
    }
}

