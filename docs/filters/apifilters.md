# Filters: ApiFilters

Miscellaneous API filters.

| Subscription (method)                                         | Filter               | Priority |
|---------------------------------------------------------------|----------------------|----------|
| [validatePasswordRequirements](#validatepasswordrequirements) | `rbac.user.password` | 10       |

## validatePasswordRequirements

**Description:**

Ensure password meets minimum requirements.

- Min length: 12
- Max length: 64
- Min lowercase characters: 1
- Min uppercase characters: 1
- Min digits: 1
- Min special characters: 0

**Parameters:**

- `$password` (string)

**Returns:**

- (string)

**Throws:**

- `Bayfront\BonesService\Api\Exceptions\Http\BadRequestException`