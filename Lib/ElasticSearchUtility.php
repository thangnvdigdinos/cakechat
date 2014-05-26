<?php
class ElasticSearchUtility {

    function __construct($params = array())
    {
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

        if (!isset($params['index'])) {
            throw Exception('The index does not exist.');
        }

        //Get hosts array from config file
        $host['hosts'] = Configure::read('hosts');

        // Alternatively you can use dsn string
        $client = new Elasticsearch\Client($host);

        return $client->indices()->exists($params['index']);
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
        $client = new Elasticsearch\Client($host);

        $client->index($params);
    }

    /**
     * indexing data via call to ElasticSearch server
     * @param array $params
     *
     * @author ThangNV
     */
    public static function delete($params = array())
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
        $client = new Elasticsearch\Client($host);

        $client->delete($params);
    }
}
