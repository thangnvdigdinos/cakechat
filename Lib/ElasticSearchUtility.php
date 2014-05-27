<?php

interface ElasticSeachInterface {

    function exists($params = array());
    function index($params = array());
    function delete($params = array());
    function search($params = array());
    function update($params = array());
}

class ElasticSearchBase {

    protected $client = null;

    protected function __construct($client = null)
    {
        if (null === $client) {
            //Get hosts array from config file
            $host['hosts'] = Configure::read('hosts');

            // Alternatively you can use dsn string
            $this->client = new Elasticsearch\Client($host);
        } else {
            $this->client = $client;
        }
    }
    
    protected function getClient()
    {
        return $this->client;
    }
}

class ElasticSearchUtility extends ElasticSearchBase implements ElasticSeachInterface {

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
    protected function __construct($client = null)
    {
        if (null === $client) {
            // Alternatively you can use dsn string
            parent::__construct();
            //$this->client = parent::$client;
        } else {
            parent::__construct($client);
            //$this->client = parent::$client;
        }
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
        if (!$params) {
            throw NotFoundException('The index does not exist.');
        }

        if (!$params['index']) {
            throw NotFoundException('The index does not exist.');
        }

        return $this->client->indices()->exists($params['index']);
    }

    /**
     * indexing data
     * @param array $params
     * @example params['index'], params['type'], params['id'], params['body']
     *
     * @author ThangNV
     */
    public function index($params = array())
    {
        if (!$params) {
            throw NotFoundException('The index does not exist.');
        }

        if (!$params['index']) {
            throw NotFoundException('The index does not exist.');
        }

        $this->client->index($params);
    }

    /**
     * indexing data via call to ElasticSearch server
     * @param array $params
     * @example params['index'], params['type'], params['id']
     *
     * @author ThangNV
     */
    public function delete($params = array())
    {
        if (!$params) {
            throw NotFoundException('The index does not exist.');
        }

        if (!$params['index']) {
            throw NotFoundException('The index does not exist.');
        }

        $this->client->delete($params);
    }

    /**
     * Search data from ES server
     * @param array $params
     * @example
     * $params['index'] = 'my_index';
     * $params['type']  = 'my_type';
     * $params['body']['query']['match']['testField'] = 'abc';
     * 
     * @author ThangNV
     */
    public function search($params = array())
    {
        if (!$params) {
            throw NotFoundException('The index does not exist.');
        }

        if (!$params['index']) {
            throw NotFoundException('The index does not exist.');
        }

        if (!$params['type']) {
            throw NotFoundException('The type does not exist.');
        }

        if (!$params['body']) {
            throw NotFoundException('The type does not exist.');
        }

        return $this->client->search($params);
    }

    public function update($params = array())
    {

    }
}
