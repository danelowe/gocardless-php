<?php

/**
 * GoCardless bill functions
 *
 * @package GoCardless\Bill
 */

/**
 * GoCardless bill class
 *
 */
class GoCardless_Bill {

  /**
   * The API endpoint for bills
   *
   * @var string $endpoint
   */
  public static $endpoint = '/bills';

  /**
   * Instantiate a new instance of the bill object
   *
   * @param object $client The client to use for the bill object
   * @param array $attrs The properties of the bill
   *
   * @return object The bill object
   */
  function __construct($client, $attrs) {

    $this->client = $client;

    foreach ($attrs as $key => $value) {
      $this->$key = $value;
    }

  }

  /**
   * Fetch a bill item from the API
   *
   * @param string $id The id of the bill to fetch
   * @param object $client The client object to use to make the query
   *
   * @return object The bill object
   */
  public static function find($id, $client = null) {

    $endpoint = self::$endpoint . '/' . $id;
    $client or $client = parent::$client;
    $params['http_bearer'] = $client->account_details['access_token'];

    return new self($client, GoCardless_Request::get($endpoint, $params));

  }

  /**
   * Fetch a bill item from the API
   *
   * @param object $client The client object to use to make the query
   * @param string $id The id of the bill to fetch
   *
   * @return object The bill object
   */
  public function find_with_client($client, $id) {

    $endpoint = $client->$api_path . self::$endpoint . '/' . $id;
    $params['http_bearer'] = $client->account_details['access_token'];

    return new self($client, GoCardless_Request::get($endpoint, $params));

  }

  /**
   * Create a bill under an existing pre-auth
   *
   * @param array $params Parameters to use to create the bill
   *
   * @return object The result of the cancel query
   */
  public function create($params) {

    $endpoint = self::$endpoint;
    $params['http_authorization'] = true;

    return new self($this->client, GoCardless_Request::post($endpoint, $params));

  }

}
