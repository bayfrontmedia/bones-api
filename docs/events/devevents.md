# Events: DevEvents

Actions to perform when environment = `dev`.

| Subscription (method)             | Event       | Priority |
|-----------------------------------|-------------|----------|
| [logAllRequests](#logallrequests) | `bones.end` | 99       |

## logAllRequests

**Description:**

Log all HTTP requests.

- Level: `debug`
- Context:
  - `response.size`
  - `response.status`
  - `elapsed`

**Parameters:**

- `$response` (`Response`)

**Returns:**

- (void)

**Throws:**

- (none)