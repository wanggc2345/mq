<?php
namespace ESSWBasic\UtilMQ\Driver;


interface Queue
{

    public function size($queue = null);

    public function push($job, $data = '', $queue = null);

    public function pushOn($queue, $job, $data = '');

    public function pushRaw($payload, $queue = null, array $options = []);

    public function bulk($jobs, $data = '', $queue = null);


    public function pop($queue = null);

    public function getConnectionName();


    public function setConnectionName($name);
}