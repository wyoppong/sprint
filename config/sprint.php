<?php

/*
 * All configuration options for Sprint
 *
 */

return [
    'access' => [
        'role' => [

            /*
             * The name of the administrator role
             * Should be Administrator by design and unable to change from the backend
             * It is not recommended to change
             */
            'super' => 'super administrator',
            'system' => 'system administrator',
            'admin' => 'administrator',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | Some of Sprint's features are optional. You may disable the features
    | by removing them from this array. You're free to only remove some of
    | these features or you can even remove all of these if you need to.
    |
    */

    'features' => [
        // Features::termsAndPrivacyPolicy(),
        // Features::profilePhotos(),
        // Features::api(),
    ],

    'show-user-object' => false,
];