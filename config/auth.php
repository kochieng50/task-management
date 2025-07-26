<?php
// Authentication configuration for Laravel with Sanctum - Kennedy Oyoo

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. These defaults are suitable
    | for most applications using web and API authentication.
    |
    */
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Defines the authentication guards for the application. The 'web' guard
    | uses session-based authentication, while the 'api' guard uses Sanctum
    | for token-based API authentication.
    |
    | Supported: "session", "sanctum"
    |
    */
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Defines how users are retrieved from the database. The 'eloquent' driver
    | uses the Eloquent ORM with the User model for authentication.
    |
    | Supported: "database", "eloquent"
    |
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Configures the password reset functionality, including the table for
    | token storage, token expiry time, and throttling settings to prevent
    | abuse of password reset requests.
    |
    */
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Specifies the number of seconds before a password confirmation window
    | expires, requiring users to re-enter their password. Set to 3 hours
    | by default.
    |
    */
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
