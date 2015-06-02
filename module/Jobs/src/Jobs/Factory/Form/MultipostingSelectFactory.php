<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2015 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace Jobs\Factory\Form;


use Jobs\Form\MultipostingSelect;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for the Multiposting select box
 * 
 * @author Carsten Bleek <bleek@cross-solution.de>
 */
class MultipostingSelectFactory implements FactoryInterface
{
    /**
     * Creates the multiposting select box.
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\ServiceManager\AbstractPluginManager
         * @var $headscript     \Zend\View\Helper\HeadScript
         * @var $channels       \Jobs\Options\ProviderOptions */
        $services = $serviceLocator->getServiceLocator();
        $router = $services->get('Router');
        $select  = new MultipostingSelect();
        $helpers = $services->get('ViewHelperManager');
        $headscript = $helpers->get('headscript');
        $basepath  = $helpers->get('basepath');
        $channels = $serviceLocator->getServiceLocator()->get('Jobs/Options/Provider');

        $headscript->appendFile($basepath('Jobs/js/form.multiposting-select.js'));

        $options = array();


        $groups = array();
        foreach ($channels as $name=>$channel) {
            /* @var $channel \Jobs\Options\ChannelOptions */

            $category = $channel->getCategory();

            if (!isset($groups[$category])) {
                $groups[$category] = array('label' => $category);
            }

            $link = $router->assemble($channel->getParams(), array('name' => $channel->getRoute()));
            $groups[$category]['options'][$channel->getKey()] =
                              $channel->getLabel() . '|'
                            . $channel->getHeadLine() . '|'
                            . $channel->getDescription() . '|'
                            . $channel->getLinkText() . '|'
                            . $link . '|' . $channel->getPublishDuration() . '|'
                            . $channel->getFormattedPrice() . '|'
                            . $channel->getPrice();
        }


        $select->setAttributes(array(
            'data-autoinit' => 'false',
            'multiple' => 'multiple'
        ));
        $select->setValueOptions($groups);

        return $select;
    }

}