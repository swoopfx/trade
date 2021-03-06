<?php
namespace DoctrineMongoODMModuleTest\Doctrine;

use DoctrineMongoODMModuleTest\AbstractTest;

class AuthenticationStorageFactoryTest extends AbstractTest
{
    public function testAuthenticationStorageFactory()
    {
        $storage = $this->serviceManager->get('doctrine.authenticationstorage.odm_default');
        $this->assertInstanceOf('Laminas\Authentication\Storage\StorageInterface', $storage);
    }
}
