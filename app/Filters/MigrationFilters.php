<?php

namespace App\Filters;

use App\Migrations\CreateBucketsTable;
use App\Migrations\CreateLogsTable;
use Bayfront\Bones\Abstracts\FilterSubscriber;
use Bayfront\Bones\Application\Services\Filters\FilterSubscription;
use Bayfront\Bones\Interfaces\FilterSubscriberInterface;
use Bayfront\LeakyBucket\AdapterInterface;
use Bayfront\LeakyBucket\Adapters\PDO;
use Bayfront\MonologPDO\PDOHandler;

/**
 * Filters used to enqueue database migrations.
 */
class MigrationFilters extends FilterSubscriber implements FilterSubscriberInterface
{

    private AdapterInterface $adapter;
    private PDOHandler $handler;

    /**
     * The container will resolve any dependencies.
     */
    public function __construct(AdapterInterface $adapter, PDOHandler $handler)
    {
        $this->adapter = $adapter;
        $this->handler = $handler;
    }

    /**
     * @inheritDoc
     */
    public function getSubscriptions(): array
    {

        return [
            new FilterSubscription('bones.migrations', [$this, 'createBucketsTable'], 10),
            new FilterSubscription('bones.migrations', [$this, 'createLogsTable'], 10)
        ];

    }

    /**
     * Add migration for buckets table.
     *
     * @param array $array
     * @return array
     */
    public function createBucketsTable(array $array): array
    {

        if ($this->adapter instanceof PDO) {
            return array_merge($array, [
                new CreateBucketsTable($this->adapter)
            ]);
        }

        return $array;

    }

    /**
     * Add migration for logs table.
     *
     * @param array $array
     * @return array
     */
    public function createLogsTable(array $array): array
    {
        return array_merge($array, [
            new CreateLogsTable($this->handler)
        ]);
    }

}