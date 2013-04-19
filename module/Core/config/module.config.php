<?php
/**
 * Cross Applicant Management
 * Configuration file of the Core module
 * 
 * This file intents to provide the configuration for all other modules
 * as well (convention over configuration).
 * Having said that, you may always overwrite or extend the configuration
 * in your own modules configuration file(s) (or via the config autoloading).
 *
 * @copyright (c) 2013 Cross Solution (http://cross-solution.de)
 * @license   GPLv3
 */

return array(
    
    // Routes
    'router' => array(
        'routes' => array(
            'lang' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/:lang',
                    'defaults' => array(
                        'controller' => 'Core\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'home' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/test[/:logo]',
                            'defaults' => array(
                                'controller' => 'Core\Controller\Index',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
            
        ),
    ),
    
    // Setup the service manager
    'service_manager' => array(
        'invokables' => array(
            'query' => 'Core\Mapper\Query\Query',
            'criteria' => 'Core\Mapper\Query\Criteria\Criteria',
        ),
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'main_navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'query_criterion_manager' => 'Core\Mapper\Query\Service\CriterionManagerFactory',
            'query_criterion_converter_manager' => 'Core\Mapper\Query\Service\CriterionConverterManagerFactory',
            'query_option_manager' => 'Core\Mapper\Query\Service\OptionManagerFactory',
        ),
        'initializers' => array(
            'criteria' => 'Core\Mapper\Query\Service\CriteriaInitializer',
        ),
        'shared' => array(
            'query' => false,
            'criteria' => false,
        ),
    ),
    
    // Translation settings consumed by the 'translator' factory above.
    'translator' => array(
        'locale' => 'de_DE',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    
    // Navigation-Konfig für die main_navigation
    'navigation' => array(
        'default' => array(
            'home' => array(
                'label' => 'Home',
                'route' => 'lang',
                'params' => array(
                    'lang' => 'de',
                ),
            ),
        ),
    ),
    
    // Configuration of the controller service manager (Which loads controllers)
    'controllers' => array(
        'invokables' => array(
            'Core\Controller\Index' => 'Core\Controller\IndexController'
        ),
    ),
    
    // Configuration of the controller plugin service manager
    'controller_plugins' => array(
        'invokables' => array(
            'listquery' => 'Core\Controller\Plugin\ListQuery'
        )
    ),
    
    // Configure the view service manager
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        
        // Map template to files. Speeds up the lookup through the template stack. 
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            //'core/index/index'        => __DIR__ . '/../view/core/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        
        // Where to look for view templates not mapped above
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    'view_helpers' => array(
        'invokables' => array(
            'jquery' => 'Core\View\Helper\Jquery',
            'form_row' => 'Core\Form\View\Helper\FormRow',
            'form_multi_checkbox' => 'Core\Form\View\Helper\FormMultiCheckbox',
            'form_radio' => 'Core\Form\View\Helper\FormRadio',
            'build_query' => 'Core\View\Helper\BuildQuery',
        ),
        'factories' => array(
            'params' => 'Core\View\Helper\Service\ParamsHelperFactory',
        ),
    ),
    
    
);
