<?php
namespace ESSWBasic\UtilMQ;


use ESSWBasic\UtilMQ\Connectors\ConnectorInterface;
use ESSWBasic\UtilMQ\Connectors\KafkaConnector;
use ESSWBasic\UtilMQ\Connectors\NullConnector;
use ESSWBasic\UtilMQ\Connectors\RabbitMQConnector;
use ESSWBasic\UtilMQ\Driver\RedisDriver;
use ESSWBasic\UtilMQ\Driver\Queue;
use InvalidArgumentException;
use Closure;


/**
 * Class QueueManager
 *
 * @package ESSWBase\UtilMQ
 * @method pop()
 */
class QueueManager
{
    protected $connections = [];
    protected $connectors = [];
    protected $config = [];

    public function __construct()
    {
        $config = include __DIR__. "/config/config.php";
        $this->config = $config;
        $driver = $this->config['driver'];

    }





    // 判断是否已创建连接
    public function connected($name)
    {
        return isset($this->connections[$name]);
    }


    // 返回config.php 定义的数组变量
    public function getConfig()
    {
        return include __DIR__ . "/config/config.php";
    }

    /**
     * @param $driver
     * @return ConnectorInterface
     */
    protected function getConnector($driver)
    {
        if (! isset($this->connectors[$driver])) {
            throw new InvalidArgumentException("No connector for [$driver].");
        }

        return call_user_func($this->connectors[$driver]);
    }

    public function addConnector($driver, Closure $resolver)
    {
        $this->connectors[$driver] = $resolver;
    }

    /**
     * @return Queue
     */
    protected function resolve()
    {
        $config = $this->getConfig();

        $obj = $this->getConnector($config['driver']);
        $connect = $obj->connect($config);
        $set = $connect->setConnectionName($config['driver']);

        return $set;
    }

    // access
    /**
     * @return Queue
     */
    public function connection()
    {
        $config = $this->getConfig();
        $name = $config['driver'];

        if (! isset($this->connections[$name])) {

            var_dump($this->connections[$name]);
            $this->connections[$name] = $this->resolve();
        }

        return $this->connections[$name];
    }

    //
    public function __call($method, $parameters)
    {
        return $this->connection()->$method(...$parameters);
    }
}