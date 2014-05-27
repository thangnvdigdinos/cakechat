<?php

interface ElasticSeachInterface {

    function exists($params);
    function index($params);
    function delete($params);
    function search($params = array());
    function update($params);
}

class ElasticSearchBase {

    /**
     * Define client so that creating new instance of ElasticSearch for reuse in children classese.
     */
    protected $client = null;

    protected function __construct($client = null)
    {
        if (null === $client) {
            /**
             * Get hosts array from config file
             */
            $host['hosts'] = Configure::read('hosts');

            /**
             * Create ElasticSearch instance for searching data
             */
            $this->client = new Elasticsearch\Client($host);
        } else {
            $this->client = $client;
        }
    }
}

class ElasticSearchUtility extends ElasticSearchBase implements ElasticSeachInterface {

    protected static $instance = null;

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
        parent::__construct($client);
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
     * $params['id']         = (string) The document ID (Required)
     *        ['index']      = (string) The name of the index (Required)
     *        ['type']       = (string) The type of the document (use `_all` to fetch the first document matching the ID across all types) (Required)
     *        ['parent']     = (string) The ID of the parent document
     *        ['preference'] = (string) Specify the node or shard the operation should be performed on (default: random)
     *        ['realtime']   = (boolean) Specify whether to perform the operation in realtime or search mode
     *        ['refresh']    = (boolean) Refresh the shard containing the document before performing the operation
     *        ['routing']    = (string) Specific routing value
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function exists($params)
    {
        return $this->client->exists($params);
    }

    /**
     * $params['index']        = (string) The name of the index (Required)
     *        ['type']         = (string) The type of the document (Required)
     *        ['id']           = (string) Specific document ID (when the POST method is used)
     *        ['consistency']  = (enum) Explicit write consistency setting for the operation
     *        ['op_type']      = (enum) Explicit operation type
     *        ['parent']       = (string) ID of the parent document
     *        ['percolate']    = (string) Percolator queries to execute while indexing the document
     *        ['refresh']      = (boolean) Refresh the index after performing the operation
     *        ['replication']  = (enum) Specific replication type
     *        ['routing']      = (string) Specific routing value
     *        ['timeout']      = (time) Explicit operation timeout
     *        ['timestamp']    = (time) Explicit timestamp for the document
     *        ['ttl']          = (duration) Expiration time for the document
     *        ['version']      = (number) Explicit version number for concurrency control
     *        ['version_type'] = (enum) Specific version type
     *        ['body']         = (array) The document
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function index($params)
    {
        return $this->client->index($params);
    }

    /**
     * $params['id']           = (string) The document ID (Required)
     *        ['index']        = (string) The name of the index (Required)
     *        ['type']         = (string) The type of the document (Required)
     *        ['consistency']  = (enum) Specific write consistency setting for the operation
     *        ['parent']       = (string) ID of parent document
     *        ['refresh']      = (boolean) Refresh the index after performing the operation
     *        ['replication']  = (enum) Specific replication type
     *        ['routing']      = (string) Specific routing value
     *        ['timeout']      = (time) Explicit operation timeout
     *        ['version_type'] = (enum) Specific version type
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function delete($params)
    {
        return $this->client->delete($params);
    }

    /**
     *
     * $params[''] @todo finish the rest of these params
     *        ['ignore_unavailable'] = (bool) Whether specified concrete indices should be ignored when unavailable (missing or closed)
     *        ['allow_no_indices']   = (bool) Whether to ignore if a wildcard indices expression resolves into no concrete indices. (This includes `_all` string or when no indices have been specified)
     *        ['expand_wildcards']   = (enum) Whether to expand wildcard expression to concrete indices that are open, closed or both.
     *
     * @param array $params
     *
     * @return array
     */
    public function deleteByQuery($params = array())
    {
        return $this->client->deleteByQuery($params);
    }

    /**
     * $params['index']                    = (list) A comma-separated list of index names to search; use `_all` or empty string to perform the operation on all indices
     *        ['type']                     = (list) A comma-separated list of document types to search; leave empty to perform the operation on all types
     *        ['analyzer']                 = (string) The analyzer to use for the query string
     *        ['analyze_wildcard']         = (boolean) Specify whether wildcard and prefix queries should be analyzed (default: false)
     *        ['default_operator']         = (enum) The default operator for query string query (AND or OR)
     *        ['df']                       = (string) The field to use as default where no field prefix is given in the query string
     *        ['explain']                  = (boolean) Specify whether to return detailed information about score computation as part of a hit
     *        ['fields']                   = (list) A comma-separated list of fields to return as part of a hit
     *        ['from']                     = (number) Starting offset (default: 0)
     *        ['ignore_indices']           = (enum) When performed on multiple indices, allows to ignore `missing` ones
     *        ['indices_boost']            = (list) Comma-separated list of index boosts
     *        ['lenient']                  = (boolean) Specify whether format-based query failures (such as providing text to a numeric field) should be ignored
     *        ['lowercase_expanded_terms'] = (boolean) Specify whether query terms should be lowercased
     *        ['preference']               = (string) Specify the node or shard the operation should be performed on (default: random)
     *        ['q']                        = (string) Query in the Lucene query string syntax
     *        ['routing']                  = (list) A comma-separated list of specific routing values
     *        ['scroll']                   = (duration) Specify how long a consistent view of the index should be maintained for scrolled search
     *        ['search_type']              = (enum) Search operation type
     *        ['size']                     = (number) Number of hits to return (default: 10)
     *        ['sort']                     = (list) A comma-separated list of <field>:<direction> pairs
     *        ['source']                   = (string) The URL-encoded request definition using the Query DSL (instead of using request body)
     *        ['_source']                  = (list) True or false to return the _source field or not, or a list of fields to return
     *        ['_source_exclude']          = (list) A list of fields to exclude from the returned _source field
     *        ['_source_include']          = (list) A list of fields to extract and return from the _source field
     *        ['stats']                    = (list) Specific 'tag' of the request for logging and statistical purposes
     *        ['suggest_field']            = (string) Specify which field to use for suggestions
     *        ['suggest_mode']             = (enum) Specify suggest mode
     *        ['suggest_size']             = (number) How many suggestions to return in response
     *        ['suggest_text']             = (text) The source text for which the suggestions should be returned
     *        ['timeout']                  = (time) Explicit operation timeout
     *        ['version']                  = (boolean) Specify whether to return document version as part of a hit
     *        ['body']                     = (array|string) The search definition using the Query DSL
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function search($params = array())
    {
        return $this->client->search($params);
    }

    /**
     * $params['id']                = (string) Document ID (Required)
     *        ['index']             = (string) The name of the index (Required)
     *        ['type']              = (string) The type of the document (Required)
     *        ['consistency']       = (enum) Explicit write consistency setting for the operation
     *        ['fields']            = (list) A comma-separated list of fields to return in the response
     *        ['lang']              = (string) The script language (default: mvel)
     *        ['parent']            = (string) ID of the parent document
     *        ['percolate']         = (string) Perform percolation during the operation; use specific registered query name, attribute, or wildcard
     *        ['refresh']           = (boolean) Refresh the index after performing the operation
     *        ['replication']       = (enum) Specific replication type
     *        ['retry_on_conflict'] = (number) Specify how many times should the operation be retried when a conflict occurs (default: 0)
     *        ['routing']           = (string) Specific routing value
     *        ['script']            = () The URL-encoded script definition (instead of using request body)
     *        ['timeout']           = (time) Explicit operation timeout
     *        ['timestamp']         = (time) Explicit timestamp for the document
     *        ['ttl']               = (duration) Expiration time for the document
     *        ['version_type']      = (number) Explicit version number for concurrency control
     *        ['body']              = (array) The request definition using either `script` or partial `doc`
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function update($params)
    {
        return $this->client->update($params);
    }

    /**
     * $params['index']              = (list) A comma-separated list of indices to restrict the results
     *        ['type']               = (list) A comma-separated list of types to restrict the results
     *        ['min_score']          = (number) Include only documents with a specific `_score` value in the result
     *        ['preference']         = (string) Specify the node or shard the operation should be performed on (default: random)
     *        ['routing']            = (string) Specific routing value
     *        ['source']             = (string) The URL-encoded query definition (instead of using the request body)
     *        ['body']               = (array) A query to restrict the results (optional)
     *        ['ignore_unavailable'] = (bool) Whether specified concrete indices should be ignored when unavailable (missing or closed)
     *        ['allow_no_indices']   = (bool) Whether to ignore if a wildcard indices expression resolves into no concrete indices. (This includes `_all` string or when no indices have been specified)
     *        ['expand_wildcards']   = (enum) Whether to expand wildcard expression to concrete indices that are open, closed or both.
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function count($params = array())
    {
        return $this->client->count($params);
    }

    /**
     * $params['index']        = (string) The name of the index (Required)
     *        ['type']         = (string) The type of the document (Required)
     *        ['id']           = (string) Specific document ID (when the POST method is used)
     *        ['consistency']  = (enum) Explicit write consistency setting for the operation
     *        ['parent']       = (string) ID of the parent document
     *        ['percolate']    = (string) Percolator queries to execute while indexing the document
     *        ['refresh']      = (boolean) Refresh the index after performing the operation
     *        ['replication']  = (enum) Specific replication type
     *        ['routing']      = (string) Specific routing value
     *        ['timeout']      = (time) Explicit operation timeout
     *        ['timestamp']    = (time) Explicit timestamp for the document
     *        ['ttl']          = (duration) Expiration time for the document
     *        ['version']      = (number) Explicit version number for concurrency control
     *        ['version_type'] = (enum) Specific version type
     *        ['body']         = (array) The document
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function create($params)
    {
        return $this->client->create($params);
    }

    /**
     * $params['index']       = (string) Default index for items which don't provide one
     *        ['type']        = (string) Default document type for items which don't provide one
     *        ['consistency'] = (enum) Explicit write consistency setting for the operation
     *        ['refresh']     = (boolean) Refresh the index after performing the operation
     *        ['replication'] = (enum) Explicitly set the replication type
     *        ['body']        = (string) Default document type for items which don't provide one
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function bulk($params = array())
    {
        return $this->client->bulk($params);
    }

    /**
     * $params['index']          = (list) A comma-separated list of index names to restrict the operation; use `_all` or empty string to perform the operation on all indices
     *        ['ignore_indices'] = (enum) When performed on multiple indices, allows to ignore `missing` ones
     *        ['preference']     = (string) Specify the node or shard the operation should be performed on (default: random)
     *        ['routing']        = (string) Specific routing value
     *        ['source']         = (string) The URL-encoded request definition (instead of using request body)
     *        ['body']           = (array) The request definition
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function suggest($params = array())
    {
        return $this->client->suggest($params);
    }

    /**
     * $params['id']                       = (string) The document ID (Required)
     *        ['index']                    = (string) The name of the index (Required)
     *        ['type']                     = (string) The type of the document (Required)
     *        ['analyze_wildcard']         = (boolean) Specify whether wildcards and prefix queries in the query string query should be analyzed (default: false)
     *        ['analyzer']                 = (string) The analyzer for the query string query
     *        ['default_operator']         = (enum) The default operator for query string query (AND or OR)
     *        ['df']                       = (string) The default field for query string query (default: _all)
     *        ['fields']                   = (list) A comma-separated list of fields to return in the response
     *        ['lenient']                  = (boolean) Specify whether format-based query failures (such as providing text to a numeric field) should be ignored
     *        ['lowercase_expanded_terms'] = (boolean) Specify whether query terms should be lowercased
     *        ['parent']                   = (string) The ID of the parent document
     *        ['preference']               = (string) Specify the node or shard the operation should be performed on (default: random)
     *        ['q']                        = (string) Query in the Lucene query string syntax
     *        ['routing']                  = (string) Specific routing value
     *        ['source']                   = (string) The URL-encoded query definition (instead of using the request body)
     *        ['_source']                  = (list) True or false to return the _source field or not, or a list of fields to return
     *        ['_source_exclude']          = (list) A list of fields to exclude from the returned _source field
     *        ['_source_include']          = (list) A list of fields to extract and return from the _source field
     *        ['body']                     = (string) The URL-encoded query definition (instead of using the request body)
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function explain($params)
    {
        return $this->client->explain($params);
    }

    /**
     * $params['index']              = (list) A comma-separated list of index names to search; use `_all` or empty string to perform the operation on all indices
     *        ['type']               = (list) A comma-separated list of document types to search; leave empty to perform the operation on all types
     *        ['preference']         = (string) Specify the node or shard the operation should be performed on (default: random)
     *        ['routing']            = (string) Specific routing value
     *        ['local']              = (bool) Return local information, do not retrieve the state from master node (default: false)
     *        ['ignore_unavailable'] = (bool) Whether specified concrete indices should be ignored when unavailable (missing or closed)
     *        ['allow_no_indices']   = (bool) Whether to ignore if a wildcard indices expression resolves into no concrete indices. (This includes `_all` string or when no indices have been specified)
     *        ['expand_wildcards']   = (enum) Whether to expand wildcard expression to concrete indices that are open, closed or both.
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function searchShards($params = array())
    {
        return $this->client->searchShards($params);
    }

    /**
     * $params['index']                    = (list) A comma-separated list of index names to search; use `_all` or empty string to perform the operation on all indices
     *        ['type']                     = (list) A comma-separated list of document types to search; leave empty to perform the operation on all types
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function searchTemplate($params = array())
    {
        return $this->client->searchTemplate($params);
    }

    /**
     * $params['scroll_id'] = (string) The scroll ID for scrolled search
     *        ['scroll']    = (duration) Specify how long a consistent view of the index should be maintained for scrolled search
     *        ['body']      = (string) The scroll ID for scrolled search
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function scroll($params = array())
    {
        return $this->client->scroll($params);
    }

    /**
     * $params['scroll_id'] = (string) The scroll ID for scrolled search
     *        ['scroll']    = (duration) Specify how long a consistent view of the index should be maintained for scrolled search
     *        ['body']      = (string) The scroll ID for scrolled search
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function clearScroll($params = array())
    {
        return $this->client->clearScroll($params);
    }

    /**
     *
     *
     * @return array
     */
    public function info()
    {
        return $this->client->info();
    }

    public function ping()
    {
        return $this->client->ping();
    }

    /**
     * $params['id']              = (string) The document ID (Required)
     *        ['index']           = (string) The name of the index (Required)
     *        ['type']            = (string) The type of the document (use `_all` to fetch the first document matching the ID across all types) (Required)
     *        ['ignore_missing']  = ??
     *        ['fields']          = (list) A comma-separated list of fields to return in the response
     *        ['parent']          = (string) The ID of the parent document
     *        ['preference']      = (string) Specify the node or shard the operation should be performed on (default: random)
     *        ['realtime']        = (boolean) Specify whether to perform the operation in realtime or search mode
     *        ['refresh']         = (boolean) Refresh the shard containing the document before performing the operation
     *        ['routing']         = (string) Specific routing value
     *        ['_source']         = (list) True or false to return the _source field or not, or a list of fields to return
     *        ['_source_exclude'] = (list) A list of fields to exclude from the returned _source field
     *        ['_source_include'] = (list) A list of fields to extract and return from the _source field
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function get($params)
    {
        return $this->client->get($params);
    }

    /**
     * $params['id']             = (string) The document ID (Required)
     *        ['index']          = (string) The name of the index (Required)
     *        ['type']           = (string) The type of the document (use `_all` to fetch the first document matching the ID across all types) (Required)
     *        ['ignore_missing'] = ??
     *        ['parent']         = (string) The ID of the parent document
     *        ['preference']     = (string) Specify the node or shard the operation should be performed on (default: random)
     *        ['realtime']       = (boolean) Specify whether to perform the operation in realtime or search mode
     *        ['refresh']        = (boolean) Refresh the shard containing the document before performing the operation
     *        ['routing']        = (string) Specific routing value
     *
     * @param $params array Associative array of parameters
     *
     * @return array
     */
    public function getSource($params)
    {
        return $this->client->getSource($params);
    }

    /**
     * Operate on the Indices Namespace of commands
     *
     * @return IndicesNamespace
     */
    public function indices()
    {
        return $this->client->indices;
    }

    /**
     * Operate on the Cluster namespace of commands
     *
     * @return ClusterNamespace
     */
    public function cluster()
    {
        return $this->client->cluster;
    }

    /**
     * Operate on the Nodes namespace of commands
     *
     * @return NodesNamespace
     */
    public function nodes()
    {
        return $this->client->nodes;
    }

    /**
     * Operate on the Snapshot namespace of commands
     *
     * @return SnapshotNamespace
     */
    public function snapshot()
    {
        return $this->client->snapshot;
    }

    /**
     * Operate on the Cat namespace of commands
     *
     * @return SnapshotNamespace
     */
    public function cat()
    {
        return $this->client->cat;
    }
}
