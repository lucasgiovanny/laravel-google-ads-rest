<?php

namespace lucasgiovanny\LaravelGoogleAds;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;

class LaravelGoogleAds
{
    protected $apiURL = "https://googleads.googleapis.com/";

    protected $apiVersion = "v8";

    protected $account;

    protected $fields;

    protected $wheres;

    /**
     * Resource that will be called
     *
     * @var string
     */
    public $resource;

    public const WHERE_OPERATORS = [
        '=',
        '!=',
        '>',
        '>=',
        '<',
        '<=',
        'IN',
        'NOT IN',
        'LIKE',
        'NOT LIKE',
        'CONTAINS ANY',
        'CONTAINS ALL',
        'CONTAINS NONE',
        'IS NULL',
        'IS NOT NULL',
        'DURING',
        'BETWEEN',
        'REGEXP_MATCH',
        'NOT REGEXP_MATCH',
    ];

    public const FUNCTIONS = [
        'LAST_14_DAYS',
        'LAST_30_DAYS',
        'LAST_7_DAYS',
        'LAST_BUSINESS_WEEK',
        'LAST_MONTH',
        'LAST_WEEK_MON_SUN',
        'LAST_WEEK_SUN_SAT',
        'THIS_MONTH',
        'THIS_WEEK_MON_TODAY',
        'THIS_WEEK_SUN_TODAY',
        'TODAY',
        'YESTERDAY',
    ];

    /**
     * Headers for request
     *
     * @var array
     */
    protected $headers = [
        'Content-Type' => 'application/json',
        'developer-token' => null,
        'login-customer-id' => null,
    ];

    /**
     * Construct the class with dependencies
     *
     * @param HttpClient $http
     *
     * @return void
     */
    public function __construct(protected HttpClient $http)
    {
    }

    /**
     * Set the resource to be used
     *
     * @param string|array $fields
     *
     * @return $this
     */
    public function select(string | array $fields)
    {
        $this->fields = is_array($fields) ? $fields : [$fields];

        return $this;
    }

    /**
     * Set the resource to be used
     *
     * @param string $resource
     *
     * @return $this
     */
    public function account(string $account)
    {
        $this->account = str_replace("-", "", $account);

        return $this;
    }

    /**
     * Set the resource to be used
     *
     * @param string $resource
     *
     * @return $this
     */
    public function from(string $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Add a filter to the web service call
     *
     * @param string       $field
     * @param string       $operatorOrValue
     * @param string|array $value
     *
     * @return $this
     */
    public function where(string $field, string $operatorOrValue, $value = null)
    {
        $operator = $value ? $operatorOrValue : '=';

        if (! in_array(strtoupper($operator), self::WHERE_OPERATORS)) {
            throw new Exception('Invalid filter operator');
        }

        $this->wheres[] = [
            'field' => $field,
            'operator' => strtoupper($operator),
            'value' => $value ?: $operatorOrValue,
        ];

        return $this;
    }

    /**
     * Execute the get request
     *
     * @return \Illuminate\Support\Collection
     *
     * @throws Exception
     */
    public function get()
    {
        if (! $this->resource || ! $this->fields || ! $this->account) {
            throw new Exception("Invalid call");
        }

        return $this->call();
    }

    protected function query()
    {
        $query = "SELECT ";
        $query .= implode(",", $this->fields);
        $query .= " FROM ".$this->resource;

        if ($this->wheres) {
            $query .= " WHERE ";
            foreach ($this->wheres as $where) {
                $query .= $where['field']." ".$where['operator']." ".$where['value'];
                $query .= end($this->wheres) === $where ? "" : "AND";
            }
        }

        return $query;
    }

    protected function token()
    {
        $url = "https://www.googleapis.com/oauth2/v3/token";

        $res = $this->http->request("POST", $url, [
            RequestOptions::FORM_PARAMS => [
                'grant_type' => "refresh_token",
                'client_secret' => config("google-ads.client-secret"),
                'client_id' => config("google-ads.client-id"),
                'refresh_token' => config("google-ads.refresh-token"),
            ],
        ]);

        $json = $res->getBody() ? json_decode($res->getBody(), true) : null;

        return $json['access_token'] ?? null;
    }

    /**
     * Internal method to make the correct request call
     *
     * @return array
     *
     */
    protected function call()
    {
        $url = trim($this->apiURL, "/")."/".trim($this->apiVersion, "/")."/customers/".trim($this->account, "/")."/googleAds:searchStream";

        $res = $this->http->request(
            "POST",
            $url,
            [
                RequestOptions::HEADERS => array_merge(
                    $this->headers,
                    [
                    'Authorization' => "Bearer ".$this->token(),
                    ]
                ),
                RequestOptions::BODY => json_encode(['query' => $this->query()]),
            ]
        );

        return $res->getBody() ? json_decode($res->getBody(), true)[0]['results'] : null;
    }
}
