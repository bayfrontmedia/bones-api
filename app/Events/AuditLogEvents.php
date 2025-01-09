<?php

namespace App\Events;

use Bayfront\ArrayHelpers\Arr;
use Bayfront\Bones\Abstracts\EventSubscriber;
use Bayfront\Bones\Application\Services\Events\EventSubscription;
use Bayfront\Bones\Application\Utilities\Helpers;
use Bayfront\Bones\Interfaces\EventSubscriberInterface;
use Bayfront\BonesService\Orm\OrmResource;
use Bayfront\BonesService\Orm\Traits\HasOmittedFields;
use Bayfront\BonesService\Rbac\Models\PermissionsModel;
use Bayfront\BonesService\Rbac\Models\TenantInvitationsModel;
use Bayfront\BonesService\Rbac\Models\TenantMetaModel;
use Bayfront\BonesService\Rbac\Models\TenantRolePermissionsModel;
use Bayfront\BonesService\Rbac\Models\TenantRolesModel;
use Bayfront\BonesService\Rbac\Models\TenantsModel;
use Bayfront\BonesService\Rbac\Models\TenantTeamsModel;
use Bayfront\BonesService\Rbac\Models\TenantUserMetaModel;
use Bayfront\BonesService\Rbac\Models\TenantUserRolesModel;
use Bayfront\BonesService\Rbac\Models\TenantUsersModel;
use Bayfront\BonesService\Rbac\Models\TenantUserTeamsModel;
use Bayfront\BonesService\Rbac\Models\UserKeysModel;
use Bayfront\BonesService\Rbac\Models\UserMetaModel;
use Bayfront\BonesService\Rbac\Models\UsersModel;
use Bayfront\MultiLogger\ChannelName;
use Bayfront\MultiLogger\Exceptions\ChannelNotFoundException;
use Bayfront\MultiLogger\Log;
use Bayfront\Validator\Rules\IsJson;

/**
 * Events used to write to the audit log.
 */
class AuditLogEvents extends EventSubscriber implements EventSubscriberInterface
{

    protected Log $log;

    /**
     * The container will resolve any dependencies.
     */
    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    /**
     * @inheritDoc
     */
    public function getSubscriptions(): array
    {
        return [
            new EventSubscription('orm.resource.created', [$this, 'auditCreated'], 10),
            new EventSubscription('orm.resource.updated', [$this, 'auditUpdated'], 10),
            new EventSubscription('orm.resource.trashed', [$this, 'auditTrashed'], 10),
            new EventSubscription('orm.resource.restored', [$this, 'auditRestored'], 10),
            new EventSubscription('orm.resource.deleted', [$this, 'auditDeleted'], 10)
        ];
    }

    /**
     * Audit all models?
     * If TRUE, no need to build $auditable_models array.
     *
     * @var bool
     */
    private bool $audit_all = false;

    /**
     * Models to audit.
     *
     * @var array
     */
    private array $auditable_models = [
        PermissionsModel::class,
        TenantInvitationsModel::class,
        TenantMetaModel::class,
        TenantRolePermissionsModel::class,
        TenantRolesModel::class,
        TenantTeamsModel::class,
        TenantUserMetaModel::class,
        TenantUserRolesModel::class,
        TenantUserTeamsModel::class,
        TenantUsersModel::class,
        TenantsModel::class,
        UserKeysModel::class,
        UserMetaModel::class,
        UsersModel::class
    ];

    /**
     * Sanitize resource for writing to logs.
     *
     * @param OrmResource $resource
     * @param array $array
     * @return array
     */
    private function sanitizeResource(OrmResource $resource, array $array): array
    {

        $array = Arr::dot($array);

        foreach ($array as $k => $v) {

            if (is_string($v)) {

                $json = new IsJson($v);

                if ($json->isValid()) {
                    $array[$k] = json_decode($v, true);
                }

            }

        }

        return $this->filterOmittedFields($resource, Arr::undot($array));

    }

    /**
     * Filter omitted fields from log.
     *
     * @param OrmResource $resource
     * @param array $array
     * @return array
     */
    private function filterOmittedFields(OrmResource $resource, array $array): array
    {

        if (in_array(HasOmittedFields::class, Helpers::classUses($resource->getModelClassName()))) {

            /** @var HasOmittedFields $model */
            $model = $resource->getModel();

            foreach ($array as $k => $v) {
                if ($model->isOmittedField($k)) {
                    $array[$k] = '****';
                }
            }

        }

        return $array;

    }

    /**
     * Log resource created.
     *
     * @param OrmResource $resource
     * @return void
     * @throws ChannelNotFoundException
     */
    public function auditCreated(OrmResource $resource): void
    {

        if ($this->audit_all === true || in_array($resource->getModelClassName(), $this->auditable_models)) {

            $this->log->channel(ChannelName::AUDIT)->info('Resource created', [
                'action' => 'create',
                'model' => $resource->getModelClassName(),
                'resource' => $this->sanitizeResource($resource, $resource->read())
            ]);

        }

    }

    /**
     * Log resource updated.
     *
     * @param OrmResource $resource
     * @param OrmResource $previous
     * @param array $fields
     * @return void
     * @throws ChannelNotFoundException
     */
    public function auditUpdated(OrmResource $resource, OrmResource $previous, array $fields): void
    {

        if ($this->audit_all === true || in_array($resource->getModelClassName(), $this->auditable_models)) {

            $this->log->channel(ChannelName::AUDIT)->info('Resource updated', [
                'action' => 'update',
                'model' => $resource->getModelClassName(),
                'resource' => $this->sanitizeResource($resource, $resource->read()),
                'previous' => $this->sanitizeResource($previous, $previous->read()),
                'fields' => $this->sanitizeResource($resource, $fields)
            ]);

        }

    }

    /**
     * Log resource trashed.
     *
     * @param OrmResource $resource
     * @return void
     * @throws ChannelNotFoundException
     */
    public function auditTrashed(OrmResource $resource): void
    {

        if ($this->audit_all === true || in_array($resource->getModelClassName(), $this->auditable_models)) {

            $this->log->channel(ChannelName::AUDIT)->info('Resource trashed', [
                'action' => 'trash',
                'model' => $resource->getModelClassName(),
                'resource' => $this->sanitizeResource($resource, $resource->read())
            ]);

        }

    }

    /**
     * Log resource restored.
     *
     * @param OrmResource $resource
     * @param OrmResource $previous
     * @return void
     * @throws ChannelNotFoundException
     */
    public function auditRestored(OrmResource $resource, OrmResource $previous): void
    {

        if ($this->audit_all === true || in_array($resource->getModelClassName(), $this->auditable_models)) {

            $this->log->channel(ChannelName::AUDIT)->info('Resource restored', [
                'action' => 'restore',
                'model' => $resource->getModelClassName(),
                'resource' => $this->sanitizeResource($resource, $resource->read()),
                'previous' => $this->sanitizeResource($previous, $previous->read())
            ]);

        }

    }

    /**
     * Log resource deleted.
     *
     * @param OrmResource $resource
     * @return void
     * @throws ChannelNotFoundException
     */
    public function auditDeleted(OrmResource $resource): void
    {

        if ($this->audit_all === true || in_array($resource->getModelClassName(), $this->auditable_models)) {

            $this->log->channel(ChannelName::AUDIT)->info('Resource deleted', [
                'action' => 'delete',
                'model' => $resource->getModelClassName(),
                'resource' => $this->sanitizeResource($resource, $resource->read())
            ]);

        }

    }

}