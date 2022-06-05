# mujhtech/laravel-lazerpay

> A Laravel Package for lazerpay api

<p align="center">
    <a href="https://packagist.org/packages/mujhtech/laravel-lazerpay"><img src="http://poser.pugx.org/mujhtech/laravel-lazerpay/v" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/mujhtech/laravel-lazerpay"><img src="http://poser.pugx.org/mujhtech/laravel-lazerpay/v/unstable" alt="Latest Unstable Version"></a>
    <a href="https://scrutinizer-ci.com/g/Mujhtech/laravel-lazerpay/build-status/master"><img src="https://scrutinizer-ci.com/g/Mujhtech/laravel-lazerpay/badges/build.png?b=master" alt="Build Status"></a>
    <a href="https://scrutinizer-ci.com/g/Mujhtech/laravel-lazerpay/?branch=master"><img src="https://scrutinizer-ci.com/g/Mujhtech/laravel-lazerpay/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality"></a>
    <a href="https://scrutinizer-ci.com/g/Mujhtech/laravel-lazerpay/?branch=master"><img src="https://scrutinizer-ci.com/g/Mujhtech/laravel-lazerpay/badges/coverage.png?b=master" alt="Code Coverage"></a>
    <a href="https://packagist.org/packages/mujhtech/laravel-lazerpay"><img src="http://poser.pugx.org/mujhtech/laravel-lazerpay/downloads" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/mujhtech/laravel-lazerpay"><img src="http://poser.pugx.org/mujhtech/laravel-lazerpay/license" alt="License"></a>
</p>

## Installation

To get the latest version of Lazerpay, simply require it

```bash
composer require mujhtech/laravel-lazerpay
```

Or add the following line to the require block of your `composer.json` file.

```
"mujhtech/laravel-lazerpay": "1.0.*"
```

Once Laravel Sendchamp is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

```php
'providers' => [
 ...
 Mujhtech\Lazerpay\LazerpayServiceProvider::class,
 ...
]
```

> If you use **Laravel >= 5.5** you can skip this step and go to [**`configuration`**](https://github.com/mujhtech/laravel-lazerpay#configuration)

- `Mujhtech\Lazerpay\LazerpayServiceProvider::class`

Also, register the Facade like so:

```php
'aliases' => [
 ...
 'Lazerpay' => Mujhtech\Lazerpay\Facades\Lazerpay::class,
 ...
]
```

## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="Mujhtech\Lazerpay\LazerpayServiceProvider"
```

A configuration-file named `lazerpay.php` with some sensible defaults will be placed in your `config` directory:

```php
<?php

return [

   /**
     * Live API url
     *
     */
    'baseUrl' => 'https://api.lazerpay.engineering/api/v1',

    /**
     * Public Key
     *
     */
    'publicKey' => getenv('LAZERPAY_PUBLIC_KEY'),

    /**
     * Secret Key
     *
     */
    'secretKey' => getenv('LAZERPAY_SECRET_KEY'),

];
```

## Usage

Open your .env file and add your api key like so:

```php
LAZERPAY_PUBLIC_KEY=pk_xxxxx
LAZERPAY_SECRET_KEY=sk_xxxxx
```

_If you are using a hosting service like heroku, ensure to add the above details to your configuration variables._

## Use Case

```php
/**
* Verify transaction
* Verify transactions after payments
* @return array
*/
Lazerpay::verifyTransaction(string $reference)

/**
 * Alternatively, use the helper.
 */
lazerpay()->verifyTransaction(string $reference)


/**
* Get all coins
* @return array
*/
Lazerpay::getAllCoins()

/**
 * Alternatively, use the helper.
 */
lazerpay()->getAllCoins()


/**
* Get coin rate
* @query string $coin, string $currency 
* @return array
*/

Lazerpay::getCoinRate(string $coin, string $currency)

/**
 * Alternatively, use the helper.
 */
lazerpay()->getCoinRate(string $coin, string $currency)


/**
* Get wallet balance
* @query string $coin
* @return array
*/

Lazerpay::getWalletBalance(string $coin)

/**
 * Alternatively, use the helper.
 */
lazerpay()->getWalletBalance(string $coin)

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

Lazerpay::cryptoTransfer(string $reference, string $coin, string $recipient, string $amount, array $metadata, string $blockchain)

/**
 * Alternatively, use the helper.
 */
lazerpay()->cryptoTransfer(string $reference, string $coin, string $recipient, string $amount, array $metadata, string $blockchain)

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

Lazerpay::cryptoSwap(string $reference, string $fromCoin, string $toCoin, integer $amount, array $metadata, string $blockchain)

/**
 * Alternatively, use the helper.
 */
lazerpay()->cryptoSwap(string $reference, string $fromCoin, string $toCoin, integer $amount, array $metadata, string $blockchain)


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

    
Lazerpay::cryptoSwapAmount(string $fromCoin, string $toCoin, string $amount, string $blockchain)

/**
 * Alternatively, use the helper.
 */
lazerpay()->cryptoSwapAmount(string $fromCoin, string $toCoin, string $amount, string $blockchain)


/**
* Get all payment links
* @return array
*/

Lazerpay::getPaymentLinks()

/**
 * Alternatively, use the helper.
 */
lazerpay()->getPaymentLinks()


/**
* Fetch payment link
* @param string $reference or id
* @return array
*/


Lazerpay::fetchPaymentLink(string $reference)

/**
 * Alternatively, use the helper.
 */
lazerpay()->fetchPaymentLink(string $reference)


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

Lazerpay::createPaymentLink(string $title, string $description, string $type = 'standard', string $logo, string $amount, string $currency, string $redirect_url)

/**
 * Alternatively, use the helper.
 */
lazerpay()->createPaymentLink(string $title, string $description, string $type = 'standard', string $logo, string $amount, string $currency, string $redirect_url)



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

Lazerpay::updatePaymentLink(string $reference, string $title, string $description, string $type = 'standard', string $logo, string $amount, string $currency, string $redirect_url)

/**
 * Alternatively, use the helper.
 */
lazerpay()->updatePaymentLink(string $reference, string $title, string $description, string $type = 'standard', string $logo, string $amount, string $currency, string $redirect_url)





```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
