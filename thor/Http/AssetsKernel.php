<?php

namespace Thor\Http;

use Thor\Debug\Logger;
use Thor\Web\Assets\AssetsList;
use Thor\Http\Server\WebServer;
use Thor\Factories\Configurations;
use Thor\Web\Assets\AssetsManager;
use Thor\Factories\WebServerFactory;
use Thor\Configuration\Configuration;
use Thor\Factories\AssetServerFactory;
use Thor\Factories\TwigFunctionFactory;
use Thor\Configuration\ConfigurationFromFile;

class AssetsKernel extends WebKernel
{

    private AssetsManager $assetsManager;

    public function __construct(WebServer $server) {
        parent::__construct($server);
        $this->assetsManager = new AssetsManager();
        $this->webServer->getTwig()->addFunction(TwigFunctionFactory::asset($this->assetsManager));
    }

    /**
     * This function return a new kernel.
     *
     * It loads the configuration files and use it to instantiate the Kernel.
     *
     * @see Configurations::getWebConfiguration()
     */
    public static function create(): static
    {
        self::guardHttp();
        Logger::write('Start Web context');

        return self::createFromConfiguration(Configurations::getAssetsConfiguration());
    }

    /**
     * This static function returns a new WebKernel with specified configuration.
     *
     * @param Configuration $config
     *
     * @return static
     */
    public static function createFromConfiguration(Configuration $config): static
    {
        return new self(AssetServerFactory::creatAssetServerFromConfiguration($config));
    }

}
