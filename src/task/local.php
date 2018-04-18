<?php

namespace Deployer;

set('local_deploy_path', __DIR__ . '/../../.build');
set('local_cache_repository', __DIR__ . '/../../../../..');
set('local_keep_releases', 1);

set('local_upload_options', [
    'options' => [ 
        '--exclude=.git',
        '--exclude=vendor',
        '--exclude=node_modules',
    ],
]);

desc('Build your application locally');
task('local:build', function() {
    set('deploy_path', get('local_deploy_path'));
    set('previous_release', get('local_cache_repository'));
    set('keep_releases', get('local_keep_releases'));

    invoke('deploy:prepare');
    invoke('deploy:release');
    invoke('deploy:update_code');
    copyShared('{{previous_release}}', '{{release_path}}');
    invoke('deploy:shared');
    invoke('deploy:vendors');
    invoke('hook:build');
    invoke('deploy:symlink');
    invoke('cleanup');
})->local();

desc('Upload your locally-built application to your hosts');
task('local:upload', function () {
    $configs = array_merge_recursive(get('local_upload_options'), [
        'options' => ['--delete']
    ]);

    upload('{{local_deploy_path}}/current/', '{{release_path}}', $configs);
});

desc('Remove locally-built application');
task('local:cleanup', function () {
    run('rm -rf {{local_deploy_path}}');
})->local();