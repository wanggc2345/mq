<?php

return [
    'driver' => 'rabbitmq',
    'queue' => 'default',

    'hosts' => [
        [
            'host' => '127.0.0.1',
            'port' => 5672,
            'user' => 'guest',
            'password' => 'guest',
            'vhost' =>'/',
        ],
    ],

    'options' => [
        'ssl_options' => [
            'cafile' => null,
            'local_cert' => null,
            'local_key' => null,
            'verify_peer' => true,
            'passphrase' => null,
        ],
    ],

];