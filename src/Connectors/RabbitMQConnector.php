<?php
namespace ESSWBasic\UtilMQ\Connectors;


use ESSWBasic\UtilMQ\Driver\RabbitMQDriver;


class RabbitMQConnector implements ConnectorInterface
{
    protected $connections;

    public function __construct()
    {

    }

    public function connect(array $config)
    {
        return new RabbitMQDriver(

        );
    }
}
