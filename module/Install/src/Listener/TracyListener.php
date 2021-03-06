<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright https://yawik.org/COPYRIGHT.php
 * @license   MIT
 */

namespace Install\Listener;

use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\EventManagerInterface;
use Tracy\Debugger;


/**
 * @author  Anthonius Munthi <me@itstoni.com
 * @since   0.29
 * @package Core\Listener
 */
class TracyListener implements ListenerAggregateInterface
{
	use ListenerAggregateTrait;

	/**
	 * {@inheritDoc}
	 * @see \Laminas\EventManager\ListenerAggregateInterface::attach()
	 */
	public function attach(EventManagerInterface $events, $priority = 1)
	{
		$this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'handleError'], $priority);
		$this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'handleError'], $priority);
	}

	/**
	 * @param MvcEvent $e
	 */
	public function handleError(MvcEvent $e)
	{
		if ($e->getError() == \Laminas\Mvc\Application::ERROR_EXCEPTION) {
			if (Debugger::$productionMode) {
				// log an exception in production environment (this will send email as well if email address is set)
				Debugger::log($e->getParam('exception'), Debugger::ERROR);
			} else {
				// just re-throw an exception in non-production environment to let tracy display so called blue screen
				throw $e->getParam('exception');
			}
		}
	}
}
