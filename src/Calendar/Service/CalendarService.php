<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   09/12/2019
 * @time  :   11:15
 */

namespace App\Calendar\Service;


use App\Calendar\Model\Month;
use App\Manager\Service\ManagerService;

/**
 * Class CalendarService
 *
 * @package App\Calendar\Service
 *
 */
class CalendarService extends ManagerService
{
    /**
     * @return Month
     * @throws \Exception
     */
    public function getAgenda()
    {
        $month = $this->getRequest()
                      ->get("month", null);
        $year  = $this->getRequest()
                      ->get("year", null);
        $month = new Month($month, $year);
        $month->setWeeks();
        $month->setStartingDay();
        
        return $month;
    }
}