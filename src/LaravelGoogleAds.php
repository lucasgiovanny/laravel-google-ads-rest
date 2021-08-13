<?php

namespace lucasgiovanny\LaravelGoogleAds;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;
use lucasgiovanny\LaravelGoogleAds\Models\LaravelGoogleAdsModel;

class LaravelGoogleAds
{
    /**
     * @var string
     */
    protected string $apiURL = "https://googleads.googleapis.com/";

    /**
     * @var string
     */
    protected string $apiVersion = "v8";

    /**
     * @var string
     */
    protected string $account;

    /**
     * @var
     */
    protected $fields;

    /**
     * @var
     */
    protected $wheres;

    /**
     * Resource that will be called
     *
     * @var string
     */
    public $resource;

    /**
     * Possible where operations from Google Ads syntax.
     */
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

    /**
     *
     */
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
    protected array $headers = [
        'Content-Type' => 'application/json',
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
    public function select(string | array $fields): self
    {
        $this->fields = is_array($fields) ? $fields : [$fields];

        return $this;
    }

    /**
     * Set the resource to be used
     *
     * @param string $account
     *
     * @return $this
     */
    public function account(string $account): self
    {
        $this->account = \Illuminate\Support\Str::remove("-", $account);

        return $this;
    }

    /**
     * Set the resource to be used
     *
     * @param string $resource
     *
     * @return $this
     */
    public function from(string $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Add a filter to the web service call
     *
     * @param  string  $field
     * @param  string  $operatorOrValue
     * @param  mixed  $value
     *
     * @return $this
     *
     * @throws Exception
     */
    public function where(string $field, string $operatorOrValue, mixed $value = null): self
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

    /**
     * @return string
     */
    protected function query(): string
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

    /**
     * @return string|null
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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
                        'developer-token' => config('google-ads.developer-token'),
                        'login-customer-id' => config('google-ads.default-account'),
                        'Authorization' => "Bearer ".$this->token(),
                    ]
                ),
                RequestOptions::BODY => json_encode(['query' => $this->query()]),
            ]
        );

        $results = $res->getBody() ? json_decode($res->getBody(), true)[0]['results'] : null;

        foreach ($results as $result) {
            $return[] = new LaravelGoogleAdsModel($this->resource, array_merge($result[$this->resource], ['metrics' => $result['metrics'] ?? null]));
        }

        return collect($return ?? []);
    }
}
