<?php
return [
    [
        'TableName'             => 'oauth_clients',
        'AttributeDefinitions'  => [
            [
                'AttributeName' => 'id',
                'AttributeType' => 'S',
            ],
        ],
        'KeySchema'             => [
            [
                'AttributeName' => 'id',
                'KeyType'       => 'HASH',
            ],
        ],
        'ProvisionedThroughput' => [
            'ReadCapacityUnits'  => (int) env('OAUTH2_CLIENTS_DYNAMODB_READ_CAPACITY_UNITS', 10),
            'WriteCapacityUnits' => (int) env('OAUTH2_CLIENTS_DYNAMODB_WRITE_CAPACITY_UNITS', 20),
            'OnDemand'           => false,
        ],
    ],
    [
        'TableName'             => 'oauth_sessions',
        'AttributeDefinitions'  => [
            [
                'AttributeName' => 'id',
                'AttributeType' => 'S',
            ],
        ],
        'KeySchema'             => [
            [
                'AttributeName' => 'id',
                'KeyType'       => 'HASH',
            ],
        ],
        'ProvisionedThroughput' => [
            'ReadCapacityUnits'  => (int) env('OAUTH2_SESSIONS_DYNAMODB_READ_CAPACITY_UNITS', 10),
            'WriteCapacityUnits' => (int) env('OAUTH2_SESSIONS_DYNAMODB_WRITE_CAPACITY_UNITS', 20),
            'OnDemand'           => false,
        ],
    ],
    [
        'TableName'             => 'oauth_access_tokens',
        'AttributeDefinitions'  => [
            [
                'AttributeName' => 'token',
                'AttributeType' => 'S',
            ],
        ],
        'KeySchema'             => [
            [
                'AttributeName' => 'token',
                'KeyType'       => 'HASH',
            ],
        ],
        'ProvisionedThroughput' => [
            'ReadCapacityUnits'  => (int) env('OAUTH2_ACCESS_TOKENS_DYNAMODB_READ_CAPACITY_UNITS', 10),
            'WriteCapacityUnits' => (int) env('OAUTH2_ACCESS_TOKENS_DYNAMODB_WRITE_CAPACITY_UNITS', 20),
            'OnDemand'           => false,
        ],
    ],
    [

        'TableName'             => 'oauth_refresh_tokens',
        'AttributeDefinitions'  => [
            [
                'AttributeName' => 'token',
                'AttributeType' => 'S',
            ],
        ],
        'KeySchema'             => [
            [
                'AttributeName' => 'token',
                'KeyType'       => 'HASH',
            ],
        ],
        'ProvisionedThroughput' => [
            'ReadCapacityUnits'  => (int) env('OAUTH2_REFRESH_TOKENS_DYNAMODB_READ_CAPACITY_UNITS', 10),
            'WriteCapacityUnits' => (int) env('OAUTH2_REFRESH_TOKENS_DYNAMODB_WRITE_CAPACITY_UNITS', 20),
            'OnDemand'           => false,
        ],
    ],
];
