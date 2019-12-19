<?php
/**
 * sf_progesco
 *
 * @author:   emile.camara
 * @date  :   26/11/2019
 * @time  :   22:04
 */

namespace App\Pedagogy\Specification\Course;

use GBProd\Specification\Specification;

/**
 * Class CheckCourseDate
 *
 * @package App\Pedagogy\Specification\Course
 *
 */
class CheckCourseDate implements Specification
{
    /**
     * @param mixed $candidate
     *
     * @return bool
     * @throws \Exception
     */
    public function isSatisfiedBy($candidate) : bool
    {
        $startDate = $candidate->getStartDate()->format("Y-m-d");
        $startHour = $candidate->getStartDate()->format("H:i:s");
        
        $newStartDate = new \DateTime($startDate." ".$startHour);
        $newStartDate = (int)$newStartDate->format("H");
        
        return ($newStartDate > 7 && $newStartDate < 21);
    }
}