<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   19/02/2020
 */

namespace App\Pedagogy\Listener;


use App\Pedagogy\Entity\HourlyVolume;
use Doctrine\ORM\Event\LifecycleEventArgs;

class HourlyVolumeListener {
    /**
     * @param LifecycleEventArgs $args
     *
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $args) {
        $object        = $args->getObject();
        if (!$object instanceof HourlyVolume) {
            return;
        }
        $semester = $object->getSemester();
        $schoolYear = $semester->getSchoolyear();
        $object->setSchoolYear($schoolYear);
    }
    
    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args) {
        $object        = $args->getObject();
        if (!$object instanceof HourlyVolume) {
            return;
        }
        $semester = $object->getSemester();
        $schoolYear = $semester->getSchoolyear();
        $object->setSchoolYear($schoolYear);
    }
}