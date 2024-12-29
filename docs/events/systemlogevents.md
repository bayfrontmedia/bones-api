# Events: SystemLogEvents

System events which are logged.

| Subscription (method)                                             | Event                                | Priority |
|-------------------------------------------------------------------|--------------------------------------|----------|
| [addExtraInfo](#addextrainfo)                                     | `app.bootstrap`                      | 5        |
| [addRequestInfo](#addrequestinfo)                                 | `app.http`                           | 5        |
| [logLimitExceeded](#loglimitexceeded)                             | `api.auth.limit`                     | 10       |
| [logAuthOtpFail](#logauthotpfail)                                 | `api.auth.otp.fail`                  | 10       |
| [logAuthPasswordFail](#logauthpasswordfail)                       | `api.auth.password.fail`             | 10       |
| [logAuthRefreshFail](#logauthrefreshfail)                         | `api.auth.refresh.fail`              | 10       |
| [logAuthTfaFail](#logauthtfafail)                                 | `api.auth.tfa.fail`                  | 10       |
| [logUserPasswordFail](#loguserpasswordfail)                       | `api.user.password.fail`             | 10       |
| [logUserPasswordRequestFail](#loguserpasswordrequestfail)         | `api.user.password_request.fail`     | 10       |
| [logUserVerificationRequestFail](#loguserverificationrequestfail) | `api.user.verification_request.fail` | 10       |
| [logUserVerificationFail](#loguserverificationfail)               | `aapi.user.verification.fail`        | 10       |
| [logAuthSuccess](#logauthsuccess)                                 | `api.auth.success`                   | 5        |
| [addUserToLogs](#addusertologs)                                   | `api.controller.private`             | 5        |
| [logBonesDown](#logbonesdown)                                     | `bones.down`                         | 10       |
| [logBonesUp](#logbonesup)                                         | `bones.up`                           | 10       |
| [logException](#logexception)                                     | `bones.exception`                    | 10       |
| [logSlowResponse](#logslowresponse)                               | `bones.end`                          | 99       |

## addExtraInfo

**Description:**

Add extra info to logs.

- `extra.time`: RFC3339 extended time
- `extra.request.id` [Request ID](https://github.com/bayfrontmedia/bones-service-api/blob/master/docs/setup.md#configuration) (if existing)
- `extra.app.env`: App environment
- `extra.api.version`: API version

**Parameters:**

- (none)

**Returns:**

- (void)

**Throws:**

- `Bayfront\MultiLogger\Exceptions\ChannelNotFoundException`

## addRequestInfo

**Description:**

Add request info to logs.

- `extra.request.method`: Request method
- `extra.request.path`: Requested path
- `extra.request.query`: Requested query string
- `extra.request.ip`: Client IP address
- `extra.request.user_agent`: Client user agent

**Parameters:**

- (none)

**Returns:**

- (void)

**Throws:**

- `Bayfront\MultiLogger\Exceptions\ChannelNotFoundException`

## logLimitExceeded

**Description:**

Log rate limit has been exceeded.

- Level: `notice`

**Parameters:**

- (none)

**Returns:**

- (void)

**Throws:**

- (none)

## logAuthOtpFail

**Description:**

Log user failed to authenticate using email + OTP.

- Level: `notice`
- Context:
  - `email`

**Parameters:**

- `$email` (string)

**Returns:**

- (void)

**Throws:**

- (none)

## logAuthPasswordFail

**Description:**

Log user failed to authenticate using email + password.

- Level: `notice`
- Context:
  - `email`

**Parameters:**

- `$email` (string)

**Returns:**

- (void)

**Throws:**

- (none)

## logAuthRefreshFail

**Description:**

Log user failed to authenticate using refresh token.

- Level: `notice`

**Parameters:**

- (none)

**Returns:**

- (void)

**Throws:**

- (none)

## logAuthTfaFail

**Description:**

Log user failed to authenticate using email + TFA.

- Level: `notice`
- Context:
  - `email`

**Parameters:**

- `$email` (string)

**Returns:**

- (void)

**Throws:**

- (none)

## logUserPasswordFail

**Description:**

Log user failed to reset password using incorrect token.

- Level: `notice`
- Context:
  - `email`

**Parameters:**

- `$email` (string)

**Returns:**

- (void)

**Throws:**

- (none)

## logUserPasswordRequestFail

**Description:**

Log user failed to request password reset.

- Level: `notice`
- Context:
  - `email`

**Parameters:**

- `$email` (string)

**Returns:**

- (void)

**Throws:**

- (none)

## logUserVerificationRequestFail

**Description:**

Log user failed to request new email verification.

- Level: `notice`
- Context:
  - `email`

**Parameters:**

- `$email` (string)

**Returns:**

- (void)

**Throws:**

- (none)

## logUserVerificationFail

**Description:**

Log user failed to verify email.

- Level: `notice`
- Context:
  - `email`

**Parameters:**

- `$email` (string)

**Returns:**

- (void)

**Throws:**

- (none)

## logAuthSuccess

**Description:**

Add user ID to logs as `extra.user.id` and log successful authentication.

- Level: `info`

**Parameters:**

- `$user` (`User`)

**Returns:**

- (void)

**Throws:**

- `Bayfront\MultiLogger\Exceptions\ChannelNotFoundException`

## addUserToLogs

**Description:**

Add user ID to logs as `extra.user.id`.

**Parameters:**

- `$controller` (`PrivateApiController`)

**Returns:**

- (void)

**Throws:**

- `Bayfront\MultiLogger\Exceptions\ChannelNotFoundException`

## logBonesDown

**Description:**

Log Bones down.

- Level: `notice`
- Context:
  - `json`

**Parameters:**

- `$json` (array)

**Returns:**

- (void)

**Throws:**

- (none)

## logBonesUp

**Description:**

Log Bones up.

- Level: `notice`

**Parameters:**

- (none)

**Returns:**

- (void)

**Throws:**

- (none)

## logException

**Description:**

Log exception, excluding `HttpException`.

- Level: `critical`
- Context:
  - `response.status`
  - `response.message`
  - `exception.type`
  - `exception.code`
  - `exception.file`
  - `exception.line`
  - `exception.trace`

**Parameters:**

- `$response` (`Response`)
- `$e` (`Throwable`)

**Returns:**

- (void)

**Throws:**

- (none)

## logSlowResponse

**Description:**

Log slow API response.

- Level: `warning`
- Context:
  - `response.status`
  - `elapsed`

**Parameters:**

- `$response` (`Response`)

**Returns:**

- (void)

**Throws:**

- (none)