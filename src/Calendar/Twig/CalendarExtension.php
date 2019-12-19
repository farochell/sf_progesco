<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   09/12/2019
 * @time  :   11:55
 */

namespace App\Calendar\Twig;


use App\Calendar\Model\Month;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class CalendarExtension
 *
 * @package App\Calendar\Twig
 *
 */
class CalendarExtension extends AbstractExtension
{
    private $container;
    private $em;
    private $request;
    
    /**
     * CalendarExtension constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->em        = $container->get('doctrine.orm.default_entity_manager');
        $this->request   = $container->get('request_stack')
                                     ->getCurrentRequest();
        
    }
    public function getFunctions()
    {
        return [
            new  TwigFunction('calculDay', [$this, 'calculDay']),
            new TwigFunction('withinMonth', [$this, 'withinMonth']),
            new  TwigFunction('getEventDay', [$this, 'getEventDay']),
            new  TwigFunction('previousMonth', [$this, 'previousMonth']),
            new TwigFunction('nextMonth', [$this, 'nextMonth']),
            new TwigFunction('nextDay', [$this, 'nextDay']),
            new TwigFunction('previousDay', [$this, 'previousDay']),
            new TwigFunction('isAM', [$this, 'isAM']),
        ];
    }
    
    /**
     * @param \DateTime $start
     * @param int       $k
     * @param int       $i
     *
     * @return \DateTime
     */
    public function calculDay(\DateTime $start, int $k, int $i)
    {
        return (clone $start)->modify("+" . ($k + $i * 7) . " days");
    }
    
    /**
     * @param \DateTime $date
     * @param Month     $month
     *
     * @return bool
     */
    public function withinMonth(\DateTime $date, Month $month)
    {
        return $month->withInMonth($date);
    }
    
    /**
     * @param array     $pointages
     * @param \DateTime $date
     *
     * @return array|mixed
     */
    public function getEventDay(array $pointages, \DateTime $date)
    {
        $tab = [];
        foreach ($pointages as $pointage) {
            if($pointage['courseDate']->format('d-m-Y') == $date->format('d-m-Y')) {
                $tab [] = $pointage;
            }
        }
        return $tab;
    }
    
    /**
     * @param Month $month
     *
     * @return Month
     * @throws \Exception
     */
    public function previousMonth(Month $month)
    {
        return $month->previousMonth();
    }
    
    /**
     * @param Month $month
     *
     * @return Month
     * @throws \Exception
     */
    public function nextMonth(Month $month)
    {
        return $month->nextMonth();
    }
    
    /**
     * @param $day
     *
     * @return \DateTime
     * @throws \Exception
     */
    public function nextDay($day)
    {
        $date = new \DateTime($day);
        
        return $date->add(new \DateInterval('P1D'));
    }
    
    /**
     * @param  $day
     *
     * @return \DateTime
     * @throws \Exception
     */
    public function previousDay($day)
    {
        $date = new \DateTime($day);
        
        return $date->sub(new \DateInterval('P1D'));
    }
    
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isAM(\DateTime $date)
    {
        if ($date->format('H') < 14.30) {
            $pre2pm = true;
        }
        else {
            $pre2pm = false;
        }
        
        return $pre2pm;
    }
    
}