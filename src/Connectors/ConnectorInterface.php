<?php
namespace ESSWBasic\UtilMQ\Connectors;

interface ConnectorInterface
{
    /**
     * @param array $config
     * @return  \ESSWBasic\UtilMQ\Driver\Queue
     */
    public function connect(array $config);
}
