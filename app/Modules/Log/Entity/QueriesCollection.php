<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/7/5 16:32
 */

namespace App\Modules\Log\Entity;


use Illuminate\Database\Connection;
use Illuminate\Database\Events\QueryExecuted;

/**
 * Notes: 监听每次请求执行的SQL
 *
 * Class QueriesCollection
 * @package App\Modules\Log\Entity
 */
class QueriesCollection
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var array
     */
    protected $queries = [];

    /**
     * QueriesCollection constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

        $this->listen();
    }

    /**
     * Notes: 获取执行的SQL
     * User: admin
     * Date: 2020/7/7 16:44
     *
     * @return array
     */
    public function getQueries()
    {
        return $this->queries;
    }

    /**
     * Notes: 清理缓存
     * User: admin
     * Date: 2020/7/7 16:44
     *
     * @return array
     */
    public function clear()
    {
        return $this->queries = [];
    }

    /**
     * Notes: 开启监听
     * User: admin
     * Date: 2020/7/7 16:48
     *
     */
    public function listen()
    {
        $this->connection->enableQueryLog();

        $this->connection->listen(function (QueryExecuted $event) {
            $this->logQuery($event->connectionName, $event->sql, $event->bindings, $event->time);
        });
    }

    /**
     * Log DB query.
     *
     * @param string $connection
     * @param string $query
     * @param array $bindings
     * @param float $time
     */
    public function logQuery($connection, $query, array $bindings, $time)
    {
        if (! empty($bindings)) {
            $query = vsprintf(
            // Replace pdo bindings to printf string bindings escaping % char.
                str_replace(['%', '?'], ['%%', "'%s'"], $query),

                // Convert all query attributes to strings.
                $this->normalizeQueryAttributes($bindings)
            );
        }

        // Finish query with semicolon.
        $query = rtrim($query, ';') . ';';

        $this->queries[] = compact('connection', 'query', 'time');
    }

    /**
     * Be sure that all attributes sent to DB layer are strings.
     *
     * @param  array $attributes
     * @return array
     */
    protected function normalizeQueryAttributes(array $attributes)
    {
        $result = [];

        foreach ($attributes as $attribute) {
            $result[] = $this->convertAttribute($attribute);
        }

        return $result;
    }

    /**
     * Convert attribute to string.
     *
     * @param  mixed $attribute
     * @return string
     */
    protected function convertAttribute($attribute)
    {
        try {
            return (string) $attribute;
        } catch (\Exception $e) {
            switch (true) {
                // Handle DateTime attribute pass.
                case $attribute instanceof \DateTime:
                    return $attribute->format('Y-m-d H:i:s');

                // Handle callables.
                case $attribute instanceof \Closure:
                    return $this->convertAttribute($attribute());

                // Handle arrays using json by default or print_r if error occurred.
                case is_array($attribute):
                    $json = json_encode($attribute);

                    return json_last_error() === JSON_ERROR_NONE
                        ? $json
                        : print_r($attribute);

                // Handle all other object.
                case is_object($attribute):
                    return get_class($attribute);

                // For all unknown.
                default:
                    return '?';
            }
        }
    }
}
