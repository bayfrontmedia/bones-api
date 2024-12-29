<?php

namespace App\Migrations;

use Bayfront\Bones\Interfaces\MigrationInterface;
use Bayfront\MonologPDO\PDOHandler;

class CreateLogsTable implements MigrationInterface
{

    protected PDOHandler $handler;

    public function __construct(PDOHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Create logs table (v1.0)';
    }

    /**
     * @inheritDoc
     */
    public function up(): void
    {
        $this->handler->up();
    }

    /**
     * @inheritDoc
     */
    public function down(): void
    {
        $this->handler->down();
    }

}