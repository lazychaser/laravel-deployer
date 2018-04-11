<?php

use Lorisleiva\LaravelDeployer\Test\DeploymentTestCase;

return [

    'options' => [
        'repository' => DeploymentTestCase::REPOSITORY,
        'branch' => null,
        'debug' => true,
    ],

    'localhost' => [
        'deploy_path' => DeploymentTestCase::SERVER,
    ],

    'hooks' => [
        'build' => [
            'npm:install',
            'npm:development',
        ],
        'ready' => [
            'artisan:cache:clear',
            'artisan:optimize',
        ],
    ],

    'include' => [
        'fixtures/recipes/mocks.php',
    ],

];