<?php
namespace General\Service;

/**
 *
 * @author otaba
 *        
 */
class RedisService
{
    
    private $redisCache;

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    /**
     * @return the $redisCache
     */
    public function getRedisCache()
    {
        return $this->redisCache;
    }

    /**
     * @param field_type $redisCache
     */
    public function setRedisCache($redisCache)
    {
        $this->redisCache = $redisCache;
        return $this;
    }

}

