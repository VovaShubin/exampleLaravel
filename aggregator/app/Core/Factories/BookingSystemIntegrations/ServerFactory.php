<?php

namespace App\Core\Factories\BookingSystemIntegrations;

use InvalidArgumentException;
use Throwable;

class ServerFactory extends Factory
{

    /**
     * @var array
     */
    protected static array $map = [
        "test" => \App\Modules\test\Server::class,
    ];

    /**
     * @param int $testSystemId
     * @return ServerCommunication
     * @throws Throwable
     */
    public static function make(int $testSystemId): ServerCommunication
    {
        if (!isset(self::$map[$test])) {
            throw new InvalidArgumentException();
        }
        return new self::$map[$test]($test);
    }
}
