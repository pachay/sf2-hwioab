<?php

namespace Ailove\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AiloveUserExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * @param array $config
     */
    public function registerDoctrineMapping(array $config)
    {
        foreach ($config['class'] as $type => $class) {
            if (!class_exists($class)) {
                return;
            }
        }

        $collector = DoctrineCollector::getInstance();

        $collector->addAssociation($config['class']['user'], 'mapManyToMany', array(
            'fieldName'       => 'groups',
            'targetEntity'    => $config['class']['group'],
            'cascade'         => array( ),
            'joinTable'       => array(
                 'name' => $config['table']['user_group'],
                 'joinColumns' => array(
                     array(
                         'name' => 'user_id',
                         'referencedColumnName' => 'id',
                          ),
                     ),
                 'inverseJoinColumns' => array( array(
                      'name' => 'group_id',
                                    'referencedColumnName' => 'id',
                                 )),
                              )
                         ));
                   }

}
