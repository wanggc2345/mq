<?php


namespace ESSWBasic\UtilMQ\Driver;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;


class RabbitMQDriver extends Driver implements Queue
{
    public static $channel;

    public function __construct(array $config = [])
    {
        $connection = AMQPStreamConnection::create_connection($config['hosts'], $config['options']);
        self::$channel = $connection->channel();
    }

    public function size($queue = null)
    {
        // TODO: Implement size() method.
    }

    public function push($job, $data = '', $queue = null)
    {
        $exchange = 'router';
        $queue = 'msgs';

        self::$channel->queue_declare($queue, false, true, false, false);
        self::$channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);
        self::$channel->queue_bind($queue, $exchange);

        $data = "some text to publish";
        $message = new AMQPMessage($data, array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        self::$channel->basic_publish($message, $exchange);
    }

    public function pushRaw($payload, $queue = null, array $options = [])
    {
        // TODO: Implement pushRaw() method.
    }

    public function pop($queue = null)
    {


    }
}