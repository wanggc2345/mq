<?php
namespace Illuminate\Queue\Connectors;

use ESSWBasic\UtilMQ\Driver\RedisDriver;

class RedisConnector implements ConnectorInterface
{
    protected $connections;

    public function __construct()
    {
    }

    public function connect(array $config)
    {
        return new RedisDriver();
    }
}
