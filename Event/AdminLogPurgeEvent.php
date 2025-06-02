<?php

namespace AdminLogPurge\Event;

use Thelia\Core\Event\ActionEvent;

/**
 * Class AdminLogPurgeEvent
 * @package AdminLogPurge\Event
 */
class AdminLogPurgeEvent extends ActionEvent
{
    protected mixed $startDate;
    protected mixed $removeAll;
    protected mixed $AdminLogs;

    public function __construct($startDate)
    {
        $this->setStartDate($startDate);

    }

    /**
     * @return mixed
     */
    public function getStartDate(): mixed
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    

    /**
     * @return mixed
     */
    public function getAdminLogs(): mixed
    {
        return $this->AdminLogs;
    }

    /**
     * @param mixed $AdminLogs
     */
    public function setAdminLogs($AdminLogs): void
    {
        $this->AdminLogs = $AdminLogs;
    }
}