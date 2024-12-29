# Events: BootstrapEvents

Actions to perform in order to bootstrap the application.

| Subscription (method)                           | Event           | Priority |
|-------------------------------------------------|-----------------|----------|
| [modifyResponseHeaders](#modifyresponseheaders) | `app.bootstrap` | 10       |

## modifyResponseHeaders

**Description:**

Add Bones values to the [HTTP response](https://github.com/bayfrontmedia/bones/blob/master/docs/services/response.md) headers.

The following headers are added:

- `X-Application`
- `X-Application-Version`

**Parameters:**

- (none)

**Returns:**

- (void)

**Throws:**

- (none)