# Events: MessageEvents

Events which send messages.

| Subscription (method)                                   | Event                             | Priority |
|---------------------------------------------------------|-----------------------------------|----------|
| [otpCreated](#otpcreated)                               | `api.auth.otp`                    | 10       |
| [tfaCreated](#tfacreated)                               | `api.auth.password.tfa`           | 10       |
| [userPasswordRequested](#userpasswordrequested)         | `api.user.password_request`       | 10       |
| [userPasswordUpdated](#userpasswordupdated)             | `rbac.user.password.updated`      | 10       |
| [userVerificationRequested](#userverificationrequested) | `api.user.verification.request`   | 10       |
| [userVerified](#userverified)                           | `rbac.user.verified`              | 10       |
| [tenantInvitationCreated](#tenantinvitationcreated)     | `rbac.tenant.invitation.created`  | 10       |
| [tenantInvitationAccepted](#tenantinvitationaccepted)   | `rbac.tenant.invitation.accepted` | 10       |

## otpCreated

**Description:**

OTP created.

**Parameters:**

- `$user` (`User`)
- `$totp` (`Totp`)

**Returns:**

- (void)

**Throws:**

- (none)

## tfaCreated

**Description:**

TFA created.

**Parameters:**

- `$user` (`User`)
- `$totp` (`Totp`)

**Returns:**

- (void)

**Throws:**

- (none)

## userPasswordRequested

**Description:**

User password reset requested.

**Parameters:**

- `$user` (`User`)
- `$totp` (`Totp`)

**Returns:**

- (void)

**Throws:**

- (none)

## userPasswordUpdated

**Description:**

User password updated.

**Parameters:**

- `$resource` (`OrmResource`)

**Returns:**

- (void)

**Throws:**

- (none)

## userVerificationRequested

**Description:**

User verification requested.

**Parameters:**

- `$user` (`User`)
- `$totp` (`Totp`)

**Returns:**

- (void)

**Throws:**

- (none)

## userVerified

**Description:**

User verified.

**Parameters:**

- `$email` (string)

**Returns:**

- (void)

**Throws:**

- (none)

## tenantInvitationCreated

**Description:**

Tenant invitation created.

**Parameters:**

- `$tenantInvitation` (`OrmResource`)

**Returns:**

- (void)

**Throws:**

- (none)

## tenantInvitationAccepted

**Description:**

Tenant invitation accepted.

**Parameters:**

- `$user` (`OrmResource`)
- `$tenant_id` (string)

**Returns:**

- (void)

**Throws:**

- (none)