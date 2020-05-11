<?php

namespace Dazzle\DrupalTranslations;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class Extension implements ExtensionInterface {

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container) {
        // TODO: Implement process() method.
    }

    /**
     * @inheritDoc
     */
    public function getConfigKey() {
        return 'dt';
    }

    /**
     * @inheritDoc
     */
    public function initialize(ExtensionManager $extensionManager) {
        // TODO: Implement initialize() method.
    }

    /**
     * @inheritDoc
     */
    public function configure(ArrayNodeDefinition $builder) {
        // TODO: Implement configure() method.
    }

    /**
     * @inheritDoc
     */
    public function load(ContainerBuilder $container, array $config) {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.yml');
    }

}
