<?php
class ElasticSearchUtility {

    protected static $params = array();
    protected static $client;

    function __construct($params = array())
    {
        if (isset($params)) {
            if (isset($params['hosts'])) {
                self::$params['hosts'] = $params['hosts'];
            }

            if (isset($params['index'])) {
                self::$params['index'] = $params['index'];
            }

            if (isset($params['body'])) {
                self::$params['body'] = $params['body'];
            }

            if (isset($params['type'])) {
                self::$params['type'] = $params['type'];
            }

            if (isset($params['id'])) {
                self::$params['id'] = $params['id'];
            }
        }
    }

    /**
     * Checking index is exists or not
     * @param array $params
     *
     * @author ThangNV
     */
    public static function exists($params = array())
    {
        if (!isset($params)) {
            throw Exception('The index does not exist.');
        }

        if (isset($params['index'])) {
            self::$params['index'] = $params['index'];
        } else {
            throw Exception('The index does not exist.');
        }

        //Get hosts array from config file
        $host['hosts'] = Configure::read('hosts');

        // Alternatively you can use dsn string
        self::$client = new Elasticsearch\Client($host);

        return self::$client->indices()->exists(self::$params);
    }

    /**
     * indexing data
     * @param array $params
     *
     * @author ThangNV
     */
    public static function index($params = array())
    {
        if (!isset($params)) {
            throw Exception('The index does not exist.');
        }

        if (!isset($params['index'])) {
            throw Exception('The index does not exist.');
        }

        //Get hosts array from config file
        $host['hosts'] = Configure::read('hosts');

        // Alternatively you can use dsn string
        self::$client = new Elasticsearch\Client($host);

        return self::$client->indices()->index($params);
    }
}
