<?php

/**
 * This file contains the PushConnectTest class.
 *
 * @package ApnsPHP
 * @author  Martijn van Berkum <m.vanberkum@m2mobi.com>
 */

namespace ApnsPHP\Tests;

use ApnsPHP\Exception;
use stdClass;

/**
 * This class contains tests for the connect function
 *
 * @covers \ApnsPHP\Push
 */
class PushConnectTest extends PushTest
{
    /**
     * Test that connect() connects successfully
     *
     * @covers \ApnsPHP\Push::connect
     */
    public function testConnectSuccess()
    {
        $this->set_reflection_property_value('logger', $this->logger);

        $this->mock_function('curl_init', function () {
            return new stdClass();
        });
        $this->mock_function('curl_setopt_array', function () {
            return true;
        });

        $this->logger->expects($this->exactly(3))
                     ->method('info')
                     ->withConsecutive(
                         [ 'Trying to initialize HTTP/2 backend...' ],
                         [ 'Initializing HTTP/2 backend with certificate.' ],
                         [ 'Initialized HTTP/2 backend.' ],
                     );

        $this->class->connect();

        $this->unmock_function('curl_init');
        $this->unmock_function('curl_setopt_array');
    }

    /**
     * Test that connect() throws an exception when failing to connect
     *
     * @covers \ApnsPHP\Push::connect
     */
    public function testConnectThrowsExceptionOnHttpInitFail()
    {
        $this->set_reflection_property_value('connectRetryInterval', 0);
        $this->set_reflection_property_value('logger', $this->logger);

        $this->mock_function('curl_init', function () {
            return false;
        });

        $message = [
        ];

        $this->logger->expects($this->exactly(4))
                     ->method('error')
                     ->with('Unable to initialize HTTP/2 backend.');

        $this->logger->expects($this->exactly(7))
                     ->method('info')
                     ->withConsecutive(
                         [ 'Trying to initialize HTTP/2 backend...' ],
                         [ 'Retry to connect (1/3)...' ],
                         [ 'Trying to initialize HTTP/2 backend...' ],
                         [ 'Retry to connect (2/3)...' ],
                         [ 'Trying to initialize HTTP/2 backend...' ],
                         [ 'Retry to connect (3/3)...' ],
                         [ 'Trying to initialize HTTP/2 backend...' ],
                     );

        $this->expectException('ApnsPHP\Exception');
        $this->expectExceptionMessage('Unable to initialize HTTP/2 backend.');

        $this->class->connect();
    }
}
