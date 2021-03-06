<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright https://yawik.org/COPYRIGHT.php
 * @license   MIT
 */

/** SettingsEntityResolverFactory.php */
namespace Settings\Repository;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

class SettingsEntityResolverFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $moduleManager = $container->get('ModuleManager');
        $config        = $container->get('Config');

        $map = array();
        foreach (array_keys($moduleManager->getLoadedModules()) as $module) {
            $map[$module] = isset($config[$module]['settings']['entity'])
                ? $config[$module]['settings']['entity']
                : '\Settings\Entity\ModuleSettingsContainer';
        }

        $resolver = new SettingsEntityResolver($map);
        return $resolver;
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
    }
}
