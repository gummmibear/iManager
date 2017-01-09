<?php
namespace App\ConfigManager;

use App\ConfigManager\Provider\FileProviderInterface;

class ConfigManager
{
    const CACHE_FILE = '/../data/cache/app_config.php';

    /** @var FileProviderInterface[] */
    private $providers = [];

    /** @var string */
    private $rootDir;

    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function registerProviders(array $providers)
    {
        $this->providers = array_merge($this->providers, $providers);
    }

    public function getConfig() : array
    {
        $cachedConfig = $this->getCachedConfig();

        if (!empty($cachedConfig)) {
            return $cachedConfig;
        }

        $config = [];

        foreach($this->providers as $fileProvider) {
            $config = array_merge($config, $fileProvider->getConfig());
        }

        $config = $this->resolveVariables($config);

        $this->cacheConfig($config);

        return $config;
    }

    private function cacheConfig(array $config) : void
    {
        $cachedConfigFile = $this->getCachedFilePath();

        // Cache config if enabled
        if (isset($config['config_cache_enabled']) && $config['config_cache_enabled'] === true) {
            file_put_contents($cachedConfigFile, '<?php return ' . var_export($config, true) . ';');
        }
    }

    private function getCachedConfig() : array
    {
        $cachedConfigFile = $this->getCachedFilePath();

        if (is_file($cachedConfigFile)) {
            return include $cachedConfigFile;
        }

        return [];
    }

    /**
     * @param array $config
     *
     * @return array
     */
    private function resolveVariables(array $config): array
    {
        $parameters = [];
        if (isset($config['parameters'])) {
            foreach ($config['parameters'] as $key => $value) {
                $parameters[$key] = $value;
            }
        }

        array_walk_recursive(
            $config,
            function(&$val, $key) use($parameters){
                $matches = [];
                preg_match_all('/\%(.*?)\%/', $val, $matches);

                $matches = isset($matches[1]) ? $matches[1] : [];
                if (count($matches)) {
                    foreach($matches as $param) {
                        if (isset($parameters[$param])) {
                            $val = str_replace("%$param%", $parameters[$param], $val);
                        }
                    }
                }
            }
        );

        return $config;
    }

    private function getCachedFilePath() : string
    {
        return $this->rootDir . self::CACHE_FILE;
    }
}