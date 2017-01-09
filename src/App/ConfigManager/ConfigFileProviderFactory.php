<?php
namespace App\ConfigManager;

use App\ConfigManager\Provider\FileProviderInterface;
use App\ConfigManager\Provider\PhpFileProvider;
use App\ConfigManager\Provider\YamlFileProvider;

class ConfigFileProviderFactory
{
    const PHP_PROVIDER = 'php';
    const YML_PROVIDER = 'yml';

    /**
     * ProviderFactory constructor.
     *
     * @param $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * @param $provider
     * @param $pattern
     *
     * @return FileProviderInterface
     */
    public function getProvider($provider, $pattern) : FileProviderInterface {
        $pattern = $this->rootDir . $pattern;
        switch ($provider) {
            case self::PHP_PROVIDER:
                return new PhpFileProvider($pattern);
            case self::YML_PROVIDER:
                return new YamlFileProvider($pattern);
            default:
                throw new \RuntimeException(sprintf('Provider for %s not found', $provider));
        }
    }
}