<?php

namespace Deployer;

require 'recipe/symfony3.php';

// Symfony Flex
set('clear_paths', []);
set('shared_dirs', ['var/log', 'var/sessions']);
set('writable_dirs', ['var/cache', 'var/log', 'var/sessions']);
set('web_dir', 'public');
set('assets', ['{{web_dir}}/css', '{{web_dir}}/images', '{{web_dir}}/js']);
task('deploy:assets:install', function () {
    run('{{bin/php}} {{bin/console}} assets:install {{console_options}} {{release_path}}/{{web_dir}}');
})->desc('Install bundle assets');

// Project name
set('application', 'wow-affixes');

// Project repository
set('repository', 'git@github.com:WFrancois/wow-affixes.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

set('env', function() {
    return [
        'APP_ENV' => get('symfony_env'),
    ];
});

// Shared files/dirs between deploys
add('shared_files', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('ns378030')
    ->set('deploy_path', '/home/projects/{{application}}');

// Tasks

after('deploy:assets:install', 'deploy:assets:webpack');

task('deploy:assets:webpack', function() {
    run('cd {{release_path}}; npm install');
    run('cd {{release_path}}; ./node_modules/.bin/encore production');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');