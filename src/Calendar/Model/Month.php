<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   09/12/2019
 * @time  :   10:59
 */

namespace App\Calendar\Model;

/**
 * Class Month
 *
 * @package App\Calendar\Model
 *
 */
class Month
{
    private $month;
    
    public $days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
    
    private $months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    
    private $year;
    
    private $weeks;
    
    private $startingDay;
    
    private $startingDayFormated;
    
    
    /**
     * Month constructor.
     * @param int $month Le mois de l'année
     * @param int $year L'année
     * @throws \Exception
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        if ($month === null || $month < 1 || $month > 12) {
            $month = intval(date("m"));
        }
        
        if ($year === null) {
            $year = intval(date("Y"));
        }
        
        
        
        $this->month = $month;
        $this->year = $year;
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->months[$this->month - 1] . " " . $this->year;
    }
    
    public function setStartingDay() {
        $this->startingDay = new \DateTime("{$this->year}-{$this->month}-01");
        $start = $this->startingDay;
        $this->startingDayFormated = ($start->format("N") === "1")?$start: (clone $start)->modify("last monday");
    }
    
    public function getMonthName($id) {
        return $this->months[$id-1];
    }
    
    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }
    
    /**
     * @param int $month
     */
    public function setMonth(int $month): void
    {
        $this->month = $month;
    }
    
    /**
     * @return array
     */
    public function getMonths(): array
    {
        return $this->months;
    }
    
    /**
     * @param array $months
     */
    public function setMonths(array $months): void
    {
        $this->months = $months;
    }
    
    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }
    
    /**
     * @param int|null $year
     */
    public function setYear(?int $year): void
    {
        $this->year = $year;
    }
    
    /**
     * @return mixed
     */
    public function getStartingDayFormated()
    {
        return $this->startingDayFormated;
    }
    
    /**
     * @param mixed $startingDayFormated
     */
    public function setStartingDayFormated($startingDayFormated): void
    {
        $this->startingDayFormated = $startingDayFormated;
    }
    
    /**
     * Retourne la date du 1er jour de début de la 1ère semaine
     * @return \DateTime
     */
    public function getStartingDay(): \DateTime {
        if($this->startingDay === null) {
            $this->setStartingDay();
        }
        return $this->startingDay;
    }
    
    /**
     * Calculate the number of weeks in the month
     */
    public function setWeeks() {
        $start = $this->getStartingDay();
        $end = (clone $start)->modify("+1 month -1 day");
        $startWeek = intval($start->format("W"));
        $endWeek = intval($end->format("W"));
        if($endWeek === 1) {
            $endWeek = intval((clone $end)->modify("-7 days")->format("W")) + 1;
        }
        $weeks = $endWeek - $startWeek + 1;
        
        if($weeks < 0) {
            $weeks = intval($end->format("W"));
        }
        
        $this->weeks = $weeks;
    }
    
    /**
     * Return the number of weeks in the month
     * @return int
     */
    public function getWeeks(): int
    {
        return $this->weeks;
    }
    
    /**
     * Permet d'indiquer si le jour est dans le mois en cours
     * @param \DateTime $date
     * @return bool
     */
    public function withInMonth(\DateTime $date): bool {
        return $this->getStartingDay()->format("Y-m") === $date->format("Y-m");
    }
    
    /**
     * @return bool
     * @throws \Exception
     */
    public function isClosed() {
        if($this->withInMonth(new \DateTime('now')) == true) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Return the next month
     * @return Month
     * @throws \Exception
     */
    public function nextMonth(): Month {
        $month = $this->month + 1;
        $year = $this->year;
        if($month > 12) {
            $month = 1;
            $year = $year + 1;
        }
        
        return new Month($month, $year);
    }
    
    /**
     * Return the previous month
     * @return Month
     * @throws \Exception
     */
    public function previousMonth(): Month {
        $month = $this->month - 1;
        $year = $this->year;
        
        if($month < 1) {
            $month = 12;
            $year = $year - 1;
        }
        
        return new Month($month, $year);
    }
}