<?php

/**
 * This file contains the CustomMessageTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2021 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: BSD-2-Clause
 */

namespace ApnsPHP\Message\Tests;

use ApnsPHP\Message\CustomMessage;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the CustomMessage class.
 *
 * @covers \ApnsPHP\Message\CustomMessage
 */
abstract class CustomMessageTest extends LunrBaseTest
{
    /**
     * TestCase constructor
     */
    public function setUp(): void
    {
        $this->reflection = new ReflectionClass('ApnsPHP\Message\CustomMessage');
        $this->class      = new CustomMessage();
    }

    /**
     * TestCase destructor
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
    }
}
