# Events: AuditLogEvents

Events used to write to the audit log.

When the property `audit_all` is `true`, all models will be audited.
Otherwise, the models listed in the `auditable_models` array will be audited.

| Subscription (method)           | Event                    | Priority |
|---------------------------------|--------------------------|----------|
| [auditCreated](#auditcreated)   | `orm.oresource.created`  | 10       |
| [auditUpdated](#auditupdated)   | `orm.oresource.updated`  | 10       |
| [auditTrashed](#audittrashed)   | `orm.oresource.trashed`  | 10       |
| [auditRestored](#auditrestored) | `orm.oresource.restored` | 10       |
| [auditDeleted](#auditdeleted)   | `orm.oresource.deleted`  | 10       |

## auditCreated

**Description:**

Log resource created.

**Parameters:**

- `$resource` (`OrmResource`)

**Returns:**

- (void)

**Throws:**

- `Bayfront\MultiLogger\Exceptions\ChannelNotFoundException`

## auditUpdated

**Description:**

Log resource updated.

**Parameters:**

- `$resource` (`OrmResource`)
- `$previous` (`OrmResource`)
- `$fields` (array)

**Returns:**

- (void)

**Throws:**

- `Bayfront\MultiLogger\Exceptions\ChannelNotFoundException`

## auditTrashed

**Description:**

Log resource trashed.

**Parameters:**

- `$resource` (`OrmResource`)

**Returns:**

- (void)

**Throws:**

- `Bayfront\MultiLogger\Exceptions\ChannelNotFoundException`

## auditRestored

**Description:**

Log resource restored.

**Parameters:**

- `$resource` (`OrmResource`)
- `$previous` (`OrmResource`)

**Returns:**

- (void)

**Throws:**

- `Bayfront\MultiLogger\Exceptions\ChannelNotFoundException`

## auditDeleted

**Description:**

Log resource deleted.

**Parameters:**

- `$resource` (`OrmResource`)

**Returns:**

- (void)

**Throws:**

- `Bayfront\MultiLogger\Exceptions\ChannelNotFoundException`