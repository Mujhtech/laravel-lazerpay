<?php
/*
 *
 * (c) Muhideen Mujeeb Adeoye <mujeeb.muhideen@gmail.com>
 *
 */

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

    /**
     * Webhook
     *
     */
    //'webhook' => getenv('LAZERPAY_WEBHOOK'),


];