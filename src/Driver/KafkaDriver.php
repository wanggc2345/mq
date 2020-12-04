<?php


namespace ESSWBasic\UtilMQ\Driver;


class KafkaDriver extends Driver implements Queue
{

    public function size($queue = null)
    {
        // TODO: Implement size() method.
        // return kafka.size()
    }

    public function push($job, $data = '', $queue = null)
    {
        // TODO: Implement push() method.
    }

    public function pushRaw($payload, $queue = null, array $options = [])
    {
        // TODO: Implement pushRaw() method.
    }

    public function pop($queue = null)
    {
        // TODO: Implement pop() method.
    }
}