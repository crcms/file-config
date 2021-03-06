<?php
use CrCms\FileConfig\Factory;

/**
 * @param array|string|null $key
 * @param string $default
 * @param array $config
 * @return array|\CrCms\FileConfig\FileConfig|string
 */
function file_config($key = null, string $default = '', array $config = [])
{

    if (empty($config)) {
        $config = function_exists('app') && is_object(app('config')) ? app('config')->get('file_config') : require realpath(__DIR__ . DIRECTORY_SEPARATOR . '../config/file_config.php');
    }

    if (is_null($key)) {
        return Factory::fileConfig($config);
    }

    if (is_array($key)) {
        return array_walk($key, function ($item, $k) use ($config) {
            Factory::fileConfig($config)->put($k, $item);
        });
    }

    return strpos($key, '.') === false ?
        Factory::fileConfig($config)->all($key) :
        Factory::fileConfig($config)->get($key, $default);
}