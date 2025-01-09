<?php

namespace App\Migrations;

use Bayfront\Bones\Interfaces\MigrationInterface;
use Bayfront\LeakyBucket\AdapterException;
use Bayfront\LeakyBucket\Adapters\PDO;

class CreateBucketsTable implements MigrationInterface
{

    protected PDO $pdoAdapter;

    public function __construct(PDO $pdoAdapter)
    {
        $this->pdoAdapter = $pdoAdapter;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Create buckets table (v1.0)';
    }

    /**
     * @inheritDoc
     * @throws AdapterException
     */
    public function up(): void
    {
        $this->pdoAdapter->up();
    }

    /**
     * @inheritDoc
     * @throws AdapterException
     */
    public function down(): void
    {
        $this->pdoAdapter->down();
    }

}