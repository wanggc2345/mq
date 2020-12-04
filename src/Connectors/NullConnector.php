<?php

namespace ESSWBasic\UtilMQ\Connectors;

use ESSWBasic\UtilMQ\Driver\NullDriver;

class NullConnector implements ConnectorInterface
{
    protected $connections;

    public function __construct()
    {
    }

    public function connect(array $config)
    {
        return new NullDriver(

        );
    }
}
