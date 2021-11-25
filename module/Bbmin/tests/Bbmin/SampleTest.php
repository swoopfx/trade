<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Bbmin for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace BbminTest;

class SampleTest extends Framework\TestCase
{

    public function testSample()
    {
        $this->assertInstanceOf('Laminas\Di\LocatorInterface', $this->getLocator());
    }
}