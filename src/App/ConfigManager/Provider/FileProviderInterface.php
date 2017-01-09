<?php
namespace App\ConfigManager\Provider;

interface FileProviderInterface
{
    public function getConfig() : array;

    public function getConfigFromFile(array $config, \SplFileInfo $file) : array;
}