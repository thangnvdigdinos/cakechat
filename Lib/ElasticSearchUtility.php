<?php
class ElasticSearchUtility {

    protected static $instance = null;
    protected $client = null;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @staticvar Singleton $instance The *Singleton* instances of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
        //Get hosts array from config file
        $host['hosts'] = Configure::read('hosts');

        // Alternatively you can use dsn string
        $this->client = new Elasticsearch\Client($host);
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

    /**
     * Checking index is exists or not
     * @param array $params
     *
     * @author ThangNV
     */
    public function exists($params = array())
    {
        if (!isset($params)) {
            throw Exception('The index does not exist.');
        }

        if (!isset($params['index'])) {
            throw Exception('The index does not exist.');
        }

        //        //Get hosts array from config file
        //        $host['hosts'] = Configure::read('hosts');
        //
        //        // Alternatively you can use dsn string
        //        $client = new Elasticsearch\Client($host);

        return $this->client->indices()->exists($params['index']);
    }

    /**
     * indexing data
     * @param array $params
     *
     * @author ThangNV
     */
    public function index($params = array())
    {
        if (!isset($params)) {
            throw Exception('The index does not exist.');
        }

        if (!isset($params['index'])) {
            throw Exception('The index does not exist.');
        }

        //        //Get hosts array from config file
        //        $host['hosts'] = Configure::read('hosts');
        //
        //        // Alternatively you can use dsn string
        //        $client = new Elasticsearch\Client($host);

        $this->client->index($params);
    }

    /**
     * indexing data via call to ElasticSearch server
     * @param array $params
     *
     * @author ThangNV
     */
    public function delete($params = array())
    {
        if (!isset($params)) {
            throw Exception('The index does not exist.');
        }

        if (!isset($params['index'])) {
            throw Exception('The index does not exist.');
        }

        //        //Get hosts array from config file
        //        $host['hosts'] = Configure::read('hosts');
        //
        //        // Alternatively you can use dsn string
        //        $client = new Elasticsearch\Client($host);

        $this->client->delete($params);
    }
}
