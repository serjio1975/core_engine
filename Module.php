<?php

namespace Api;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;


class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\Api::class => function($container) {
                    return new Model\Api( $container->get(\Zend\Db\Adapter\Adapter::class), $container);
                },
                \Refill\Service\Customer::class => function($container) {
                    return new \Refill\Service\Customer(
                        $container->get(\Zend\Db\Adapter\Adapter::class), $container
                        );
                },
                \Refill\Service\Payment::class => function($container) {
                    return new \Refill\Service\Payment(
                        $container->get(\Zend\Db\Adapter\Adapter::class), $container
                        );
                },
                
            ],
        ];
    }
    
     // Add this method:
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ApiController::class => function($container) {
                    return new Controller\ApiController(
                        $container->get(\Zend\Db\Adapter\Adapter::class),$container, $container->get(Model\Api::class)
                    );
                },
            ],
        ];
    }
}