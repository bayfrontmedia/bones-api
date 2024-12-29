<?php

namespace App\Events;

use Bayfront\Bones\Abstracts\EventSubscriber;
use Bayfront\Bones\Application\Services\Events\EventSubscription;
use Bayfront\Bones\Application\Utilities\App;
use Bayfront\Bones\Interfaces\EventSubscriberInterface;
use Bayfront\CronScheduler\Cron;
use Bayfront\CronScheduler\LabelExistsException;
use Bayfront\CronScheduler\SyntaxException;
use Bayfront\MultiLogger\Log;
use Bayfront\SimplePdo\Db;

/**
 * Scheduled jobs.
 */
class ScheduledJobs extends EventSubscriber implements EventSubscriberInterface
{

    protected Cron $scheduler;
    protected Db $db;
    protected Log $log;

    /**
     * The container will resolve any dependencies.
     */
    public function __construct(Cron $scheduler, Db $db, Log $log)
    {
        $this->scheduler = $scheduler;
        $this->db = $db;
        $this->log = $log;
    }

    /**
     * @inheritDoc
     */
    public function getSubscriptions(): array
    {

        return [
            new EventSubscription('app.cli', [$this, 'scheduleJobs'], 10)
        ];

    }

    /**
     * Add scheduled jobs to scheduler.
     *
     * @return void
     * @throws LabelExistsException
     * @throws SyntaxException
     */
    public function scheduleJobs(): void
    {

        $this->scheduler->call('delete-expired-buckets', function () {

            $buckets_table = App::getConfig('app.buckets_table', 'buckets');
            $this->db->query("DELETE FROM $buckets_table WHERE updated_at < DATE_SUB(NOW(), INTERVAL 60 MINUTE)");

            $this->log->info('Deleted expired buckets', [
                'count' => $this->db->rowCount(),
                'elapsed' => App::getElapsedTime()
            ]);

        })->everyMinutes(15);

    }

}