# Migrations

The app migrations are located at `/app/Migrations`.

Bones migrations documentation can be found [here](https://github.com/bayfrontmedia/bones/blob/master/docs/services/db.md#migrations).

- [CreateApiBucketTable](#createapibuckettable)
- [CreateApiLogTable](#createapilogtable)

## CreateApiBucketTable

The `CreateApiBucketTable` migration handles the table necessary for the [Leaky Bucket PDO adapter](bootstrap.md).
The table name is defined in the [app config file](configuration.md#app).

## CreateApiLogTable

The `CreateApiLogTable` migration handles the table necessary for the [Monolog PDO handler](bootstrap.md).
The table name is defined in the [app config file](configuration.md#app).