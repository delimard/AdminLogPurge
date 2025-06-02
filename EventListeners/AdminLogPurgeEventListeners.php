<?php

namespace AdminLogPurge\EventListeners;

use Propel\Runtime\Propel;
use AdminLogPurge\Event\AdminLogPurgeEvent;
use AdminLogPurge\Event\AdminLogPurgeEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Install\Database;
use Thelia\Model\Map\ModuleTableMap;

/**
 * Class AdminLogPurgeEventListeners
 * @package AdminLogPurge\EventListeners
 */
class AdminLogPurgeEventListeners implements EventSubscriberInterface
{

    /**
     *
     * @param AdminLogPurgeEvent $event
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function remove(AdminLogPurgeEvent $event)
    {
        $startDate = $event->getStartDate();

    
            $sqlAdminLogs = "DELETE `admin_log` FROM `admin_log` WHERE `admin_log`.`UPDATED_AT` <= :startDate";
      

        // Get database connection
        $con = Propel::getWriteConnection(ModuleTableMap::DATABASE_NAME);
        $database = new Database($con);

        // Execute query
        $stmtAdminLogs = $database->execute($sqlAdminLogs, [':startDate' => $startDate]);

        $event->setAdminLogs($stmtAdminLogs->rowCount());
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.

     * @return array The event names to listen to
     * @api
     */
    public static function getSubscribedEvents(): array
    {
        return [
            AdminLogPurgeEvents::REMOVE_ADMIN_LOG => ['remove', 128]
        ];
    }
}