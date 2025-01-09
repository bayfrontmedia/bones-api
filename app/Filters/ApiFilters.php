<?php

namespace App\Filters;

use Bayfront\Bones\Abstracts\FilterSubscriber;
use Bayfront\Bones\Application\Services\Filters\FilterSubscription;
use Bayfront\Bones\Interfaces\FilterSubscriberInterface;
use Bayfront\BonesService\Api\Exceptions\Http\BadRequestException;
use Bayfront\StringHelpers\Str;

/**
 * Miscellaneous API filters.
 */
class ApiFilters extends FilterSubscriber implements FilterSubscriberInterface
{

    /**
     * The container will resolve any dependencies.
     */
    public function __construct()
    {

    }

    /**
     * @inheritDoc
     */
    public function getSubscriptions(): array
    {

        return [
            new FilterSubscription('rbac.user.password', [$this, 'validatePasswordRequirements'], 10)
        ];

    }

    /**
     * Ensure password meets minimum requirements.
     *
     * @param string $password
     * @return string
     * @throws BadRequestException
     */
    public function validatePasswordRequirements(string $password): string
    {

        if (!Str::hasComplexity($password, 12, 64, 1, 1, 1, 0)) {
            throw new BadRequestException('Password does not meet minimum complexity requirements');
        }

        return $password;

    }

}