<?php

namespace ESSWBasic\UtilMQ\Connectors;


use ESSWBasic\UtilMQ\Driver\KafkaDriver;

class KafkaConnector implements ConnectorInterface
{
    protected $connections;

    public function __construct()
    {

    }

    /**
     * @param array $config
     * @return KafkaDriver
     */
    public function connect(array $config)
    {
        return new KafkaDriver(
            //config $host,$port,$user,$sss
        );
    }

}
