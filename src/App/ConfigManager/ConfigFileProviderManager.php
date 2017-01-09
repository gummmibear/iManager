<?php
namespace App\ConfigManager;

use App\ConfigManager\Provider\FileProviderInterface;


class ConfigFileProviderManager
{
    /** @var [] */
    private $autoloadFilePattern = [
        'php' => [
            '/*.global.php',
            '/*.local.php'
        ],
        'yml' => [
            '/*.yml'
        ]
    ];

    /**
     * @param ConfigFileProviderFactory $fileProviderFactory
     */
    public function __construct(ConfigFileProviderFactory $fileProviderFactory)
    {
        $this->fileProviderFactory = $fileProviderFactory;
    }

    /**
     * @return FileProviderInterface[]
     */
    public function createDefaultProviders()
    {
        $providers = [];
        foreach($this->autoloadFilePattern as $providerKey => $providersPatterns) {
            foreach ($providersPatterns as $pattern) {
                $providers[] = $this->fileProviderFactory->getProvider($providerKey, $pattern);
            }
        }

        return $providers;
    }
}