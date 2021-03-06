<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright https://yawik.org/COPYRIGHT.php
 * @author bleek@cross-solution.de
 * @license   MIT
 */

namespace Applications\Filter;

use Laminas\Filter\FilterInterface;
use Applications\Entity\StatusInterface as Status;

/**
 * Class ActionToStatus
 *
 * @package Applications\Filter
 */
class ActionToStatus implements FilterInterface
{
    protected $actionToStatusMap = array(
        'confirm' => Status::CONFIRMED,
        'invite' => Status::INVITED,
        'reset' => Status::INCOMING,
    );

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function filter($value)
    {
        return isset($this->actionToStatusMap[$value])
            ? $this->actionToStatusMap[$value]
            : false;
    }
}
