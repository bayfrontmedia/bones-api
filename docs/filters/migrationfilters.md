# Filters: MigrationFilters

Filters used to enqueue database migrations.

| Subscription (method)                     | Filter             | Priority |
|-------------------------------------------|--------------------|----------|
| [createBucketsTable](#createbucketstable) | `bones.migrations` | 10       |
| [createLogsTable](#createlogstable)       | `bones.migrations` | 10       |

## createBucketsTable

**Description:**

Add [migration](../app/migrations.md) for buckets table.

**Parameters:**

- `$array` (array)

**Returns:**

- (array)

**Throws:**

- (none)

## createLogsTable

**Description:**

Add [migration](../app/migrations.md) for logs table.

**Parameters:**

- `$array` (array)

**Returns:**

- (array)

**Throws:**

- (none)