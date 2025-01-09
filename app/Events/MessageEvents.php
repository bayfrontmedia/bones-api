<?php

namespace App\Events;

use Bayfront\Bones\Abstracts\EventSubscriber;
use Bayfront\Bones\Application\Services\Events\EventSubscription;
use Bayfront\Bones\Interfaces\EventSubscriberInterface;
use Bayfront\BonesService\Orm\OrmResource;
use Bayfront\BonesService\Rbac\Totp;
use Bayfront\BonesService\Rbac\User;

/**
 * Events which send messages.
 */
class MessageEvents extends EventSubscriber implements EventSubscriberInterface
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
            new EventSubscription('api.auth.otp', [$this, 'otpCreated'], 10),
            new EventSubscription('api.auth.password.tfa', [$this, 'tfaCreated'], 10),
            new EventSubscription('api.user.password_request', [$this, 'userPasswordRequested'], 10),
            new EventSubscription('rbac.user.password.updated', [$this, 'userPasswordUpdated'], 10),
            new EventSubscription('api.user.verification_request', [$this, 'userVerificationRequested'], 10),
            new EventSubscription('rbac.user.verified', [$this, 'userVerified'], 10),
            new EventSubscription('rbac.tenant.invitation.created', [$this, 'tenantInvitationCreated'], 10),
            new EventSubscription('rbac.tenant.invitation.accepted', [$this, 'tenantInvitationAccepted'], 10)
        ];

    }

    /**
     * OTP created.
     *
     * @param User $user
     * @param Totp $totp
     * @return void
     */
    public function otpCreated(User $user, Totp $totp): void
    {
        // Send message
    }

    /**
     * TFA created.
     *
     * @param User $user
     * @param Totp $totp
     * @return void
     */
    public function tfaCreated(User $user, Totp $totp): void
    {
        // Send message
    }

    /**
     * User password reset requested.
     *
     * @param User $user
     * @param Totp $totp
     * @return void
     */
    public function userPasswordRequested(User $user, Totp $totp): void
    {
        // Send message
    }

    /**
     * User password updated.
     *
     * @param OrmResource $resource
     * @return void
     */
    public function userPasswordUpdated(OrmResource $resource): void
    {
        // Send message
    }

    /**
     * User verification requested.
     *
     * @param User $user
     * @param Totp $totp
     * @return void
     */
    public function userVerificationRequested(User $user, Totp $totp): void
    {
        // Send message
    }

    /**
     * User verified.
     *
     * @param string $email
     * @return void
     */
    public function userVerified(string $email): void
    {
        // Send message
    }

    /**
     * Tenant invitation created.
     *
     * @param OrmResource $tenantInvitation
     * @return void
     */
    public function tenantInvitationCreated(OrmResource $tenantInvitation): void
    {
        // Send message
    }

    /**
     * Tenant invitation accepted.
     *
     * @param OrmResource $user
     * @param string $tenant_id
     * @return void
     */
    public function tenantInvitationAccepted(OrmResource $user, string $tenant_id): void
    {
        // Send message
    }

}