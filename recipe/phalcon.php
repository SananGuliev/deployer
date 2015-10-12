<?php
/* (c) Sanan Guliev <sanan@guliev.info>
 *
 * http://sanan.guliev.info/cv
 */
require_once __DIR__ . '/common.php';

// Phalcon shared dirs
//set('shared_dirs', ['app/cache']);

// Phalcon writable dirs
set('writable_dirs', ['app/cache']);
/**
 * Phalcon migrations.
 */
task('migration', function () {
    run("cd {{release_path}} && phalcon migration run");
})->desc('Phalcon migration');
/**
 * Phalcon cache directory make writable.
 */
task('cache', function () {
    run("cd {{release_path}} && chmod -R a+w app/cache");
    run("cd {{release_path}} && chmod -R a+w .phalcon");
})->desc('Phalcon writable directories');
/**
 * Main task
 */
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    //'deploy:vendors',
    'deploy:shared',
    'deploy:symlink',
    'cleanup',
    'cache',
    'migration',
])->desc('Deploy your project');
after('deploy', 'success');