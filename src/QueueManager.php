<?php
namespace ESSWBasic\UtilMQ;


use ESSWBasic\UtilMQ\Connectors\ConnectorInterface;
use ESSWBasic\UtilMQ\Connectors\KafkaConnector;
use ESSWBasic\UtilMQ\Connectors\NullConnector;
use ESSWBasic\UtilMQ\Connectors\RabbitMQConnector;
use ESSWBasic\UtilMQ\Driver\Queue;
use Illuminate\Queue\Connectors\RedisConnector;
use InvalidArgumentException;
use Closure;


/**
 * Class QueueManager
 *
 * @package ESSWBase\UtilMQ
 * @method pop()
 * @method push()
 */
class QueueManager
{
    private static $connections = [];
    private static $connectors = [];
    private static $config = [];
    private static $instance;

    private function __construct()
    {
        self::$config = include __DIR__. "/config/config.php";
        $driver = self::$config['driver'];

        self::addConnector($driver, function () use($driver){
            switch ($driver) {
                case 'rabbitmq':
                    return new RabbitMQConnector();
                case 'kafka':
                    return new KafkaConnector();
                case 'redis':
                    return new RedisConnector();
                default:
                    return new NullConnector();
            }
        });
    }

    public static function getInstance(){
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // 判断是否已创建连接
    public static function connected($name)
    {
        return isset($self::connections[$name]);
    }

    /**
     * @param $driver
     * @return ConnectorInterface
     */
    private function getConnector($driver)
    {
        if (! isset(self::$connectors[$driver])) {
            throw new InvalidArgumentException("No connector for [$driver].");
        }

        return call_user_func(self::$connectors[$driver]);
    }

    public static function addConnector($driver, Closure $resolver)
    {
        self::$connectors[$driver] = $resolver;
    }

    /**
     * @return Queue
     */
    protected function resolve()
    {
        $config = self::$config;

        $obj = $this->getConnector($config['driver']);
        $connect = $obj->connect($config);
        $set = $connect->setConnectionName($config['driver']);

        return $set;
    }

    /**
     * @return Queue
     */
    public function connection()
    {
        $name = self::$config['driver'];
        if (! isset(self::$connections[$name])) {
           self::$connections[$name] = $this->resolve();
        }

        return self::$connections[$name];
    }

    public function __call($method, $parameters)
    {
        return $this->connection()->$method(...$parameters);
    }
}