<?php

/*
 *
 * (c) Muhideen Mujeeb Adeoye <mujeeb.muhideen@gmail.com>
 *
 */

namespace Mujhtech\Lazerpay;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Mujhtech\Lazerpay\Exceptions\LazerpayException;

class Lazerpay
{

    /**
     * @var string
     */

    protected $publicKey;

    /**
     * @var string
     */

    protected $secretKey;

    /**
     * @var string
     */

    protected $client;

    /**
     * Response from lazerpay api
     * @var mixed
     */

    protected $response;

    /**
     * @var string
     */

    protected $baseUrl;

    /**
     * @var array
     */

    private $coins = ['USDT', 'DAI', 'BUSD', 'USDC'];

    /**
     * @var array
     */

    private $currencies = ['USD', 'AED', 'NGN', 'GBP', 'EUR'];

    public function __construct()
    {
        $this->getKey();
        $this->getBaseUrl();
        $this->setRequestOptions();
    }

    /**
     * Get base url from lazerpay config
     */

    public function getBaseUrl()
    {
        $this->baseUrl = Config::get('lazerpay.baseUrl');
    }

    /**
     * Get secret key from lazerpay cofig
     */

    public function getKey()
    {
        $this->publicKey = Config::get('lazerpay.publicKey');
        $this->secretKey = Config::get('lazerpay.secretKey');
    }

    /**
     * Set request options
     * @return client
     */

    private function setRequestOptions()
    {
        $authBearer = 'Bearer ' . $this->secretKey;

        $this->client = new Client(
            [
                'base_uri' => $this->baseUrl,
                'headers' => [
                    'Authorization' => $authBearer,
                    'X-api-key' => $this->publicKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]
        );

        return $this;
    }

    /**
     * Set http response
     * @param string $url
     * @param string $method
     * @param array $data
     * @return Lazerpay
     */

    private function setHttpResponse($url, $method = null, $body = [])
    {
        if (is_null($method)) {
            throw new LazerpayException("Empty method not allowed");
        }

        $this->response = $this->client->{strtolower($method)}(
            $this->baseUrl . $url,
            ["body" => json_encode($body)]
        );

        return $this;
    }

    /**
     * Decode json response into an array
     * @return array
     */

    private function getResponse()
    {
        return json_decode($this->response->getBody(), true);
    }

    /**
     * Get the data response from a get operation
     * @return array
     */
    private function getData()
    {
        return $this->getResponse()['data'];
    }

    /**
     * Verify transaction
     * Verify transactions after payments
     * @return array
     */

    public function verifyTransaction(string $reference)
    {

        return $this->setRequestOptions()->setHttpResponse('/transaction/verify/' . $reference, 'GET', [])->getData();

    }

    /**
     * Get all coins
     * @return array
     */

    public function getAllCoins()
    {

        return $this->setRequestOptions()->setHttpResponse('/coins', 'GET', [])->getData();

    }

    /**
     * Get coin rate
     * @query string $coin, string $currency
     * @return array
     */

    public function getCoinRate(string $coin, string $currency)
    {

        if (!in_array($coin, $this->coins)) {

            throw new LazerpayException("Invalid coin");

        }

        if (!in_array($currency, $this->currencies)) {

            throw new LazerpayException("Invalid coin");

        }

        return $this->setRequestOptions()->setHttpResponse('/rate?coin=' . $coin . '&currency=' . $currency, 'GET', [])->getData();

    }

    /**
     * Get wallet balance
     * @query string $coin
     * @return array
     */

    public function getWalletBalance(string $coin)
    {

        if (!in_array($coin, $this->coins)) {

            throw new LazerpayException("Invalid coin");

        }

        return $this->setRequestOptions()->setHttpResponse('/wallet/balance?coin=' . $coin, 'GET', [])->getData();

    }

    /**
     * Crypto Transfer
     * @param string $reference
     * Unique case sensitive transaction reference. If you do not pass this parameter, Lazerpay will generate a unique reference for you.
     * @param string $amount
     * The amount you want to send out
     * @param string $fromCoin
     * Crypto you want to swap from
     * @param string $toCoin
     * Crypto you want to swap to
     * @param string $blockchain
     * The blockchain network you are sending to
     * @param array $metadata e.g ['type' => "Crypto swap"]
     * @return array
     */

    public function cryptoTransfer(string $reference, string $coin, string $recipient, string $amount, array $metadata, string $blockchain)
    {

        if (!in_array($coin, $this->coins)) {

            throw new LazerpayException("Invalid coin");

        }

        if ($blockchain != 'Binance Smart Chain') {

            throw new LazerpayException("We only support the Binance smart chain for swaps");

        }

        $data = [
            'reference' => $reference,
            'amount' => $amount,
            'recipient' => $recipient,
            'coin' => $coin,
            'metadata' => $metadata,
            'blockchain' => $blockchain,
        ];

        return $this->setRequestOptions()->setHttpResponse('/transfer', 'POST', $data)->getData();

    }

    /**
     * Crypto Swap
     * @param string $reference
     * Unique case sensitive transaction reference. If you do not pass this parameter, Lazerpay will generate a unique reference for you.
     * @param string $amount
     * The amount you want to send out
     * @param string $fromCoin
     * Crypto you want to swap from
     * @param string $toCoin
     * Crypto you want to swap to
     * @param string $blockchain
     * The blockchain network you are sending to
     * @param array $metadata e.g ['type' => "Crypto swap"]
     * @return array
     */

    public function cryptoSwap(string $reference, string $fromCoin, string $toCoin, integer $amount, array $metadata, string $blockchain)
    {

        if (!in_array($fromCoin, $this->coins)) {

            throw new LazerpayException("Invalid from coin");

        }

        if (!in_array($toCoin, $this->coins)) {

            throw new LazerpayException("Invalid to coin");

        }

        if ($toCoin == $fromCoin) {

            throw new LazerpayException("toCoin and fromCoin cannot be the same");

        }

        if ($blockchain != 'Binance Smart Chain') {

            throw new LazerpayException("We only support the Binance smart chain for swaps");

        }

        $data = [
            'reference' => $reference,
            'amount' => $amount,
            'fromCoin' => $fromCoin,
            'toCoin' => $toCoin,
            'metadata' => $metadata,
            'blockchain' => $blockchain,
        ];

        return $this->setRequestOptions()->setHttpResponse('/swap/crypto', 'POST', $data)->getData();

    }

    /**
     * Crypto Swap Amount
     * This endpoint helps you get the amount you will receive on swap even before initiating the swap
     * @param string $amount
     * The amount you want to send out
     * @param string $fromCoin
     * Crypto you want to swap from
     * @param string $toCoin
     * Crypto you want to swap to
     * @param string $blockchain
     * The blockchain network you are sending to
     * @return array
     */

    public function cryptoSwapAmount(string $fromCoin, string $toCoin, string $amount, string $blockchain)
    {

        if (!in_array($fromCoin, $this->coins)) {

            throw new LazerpayException("Invalid from coin");

        }

        if (!in_array($toCoin, $this->coins)) {

            throw new LazerpayException("Invalid to coin");

        }

        if ($toCoin == $fromCoin) {

            throw new LazerpayException("toCoin and fromCoin cannot be the same");

        }

        if ($blockchain != 'Binance Smart Chain') {

            throw new LazerpayException("We only support the Binance smart chain for swaps");

        }

        $data = [
            'amount' => $amount,
            'fromCoin' => $fromCoin,
            'toCoin' => $toCoin,
            'metadata' => $metadata,
        ];

        return $this->setRequestOptions()->setHttpResponse('/swap/crypto/amount-out', 'POST', $data)->getData();

    }

    /**
     * Get all payment links
     * @return array
     */

    public function getPaymentLinks()
    {

        return $this->setRequestOptions()->setHttpResponse('/payment-links', 'GET', [])->getData();

    }

    /**
     * Fetch payment link
     * @return array
     */

    public function fetchPaymentLink(string $reference)
    {

        return $this->setRequestOptions()->setHttpResponse('/payment-links/' . $reference, 'GET', [])->getData();

    }

    /**
     * Create Payment link
     * With payment links, you can share your unique payment link to anyone in the world.
     * @param string $amount
     * Amount the user will pay
     * @param string $currency
     * Payment page currency
     * @param string $title
     * The title of the link
     * @param string $description
     * Description of the payment page
     * @param string $logo
     * Your logo url
     * @param string $type
     * Payment links type default is "standard"
     * @return array
     */

    public function createPaymentLink(string $title, string $description, string $type = 'standard', string $logo, string $amount, string $currency, string $redirect_url)
    {

        $data = [
            'amount' => $amount,
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'logo' => $logo,
            'currency' => $currency,
            'redirect_url' => $redirect_url,
        ];

        return $this->setRequestOptions()->setHttpResponse('/payment-links', 'POST', $data)->getData();

    }

    /**
     * Update Payment link
     * Update a particular payment link with the following endpoint.
     * @param string $reference
     * Id or reference
     * @param string $amount
     * Amount the user will pay
     * @param string $currency
     * Payment page currency
     * @param string $title
     * The title of the link
     * @param string $description
     * Description of the payment page
     * @param string $logo
     * Your logo url
     * @param string $type
     * Payment links type default is "standard"
     * @return array
     */

    public function updatePaymentLink(string $reference, string $title, string $description, string $type = 'standard', string $logo, string $amount, string $currency, string $redirect_url)
    {

        $data = [
            'amount' => $amount,
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'logo' => $logo,
            'currency' => $currency,
            'redirect_url' => $redirect_url,
        ];

        return $this->setRequestOptions()->setHttpResponse('/payment-links/' . $reference, 'PUT', $data)->getData();

    }

}
