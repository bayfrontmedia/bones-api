# Configuration

The configuration files are located at `/confg`.

- [API](#api)
- [App](#app)
- [Database](#database)
- [ORM](#orm)
- [RBAC](#rbac)
- [Router](#router)
- [Scheduler](#scheduler)

## API

The `api.php` file includes configuration required by [bones-service-api](https://github.com/bayfrontmedia/bones-service-api/blob/master/docs/setup.md#configuration).

## App

The `app.php` file includes [configuration required by Bones](https://github.com/bayfrontmedia/bones/blob/master/docs/usage/config.md).

In addition, the following configuration keys are added:

- `buckets_table`: Buckets table name
- `logs_table`: Logs table name
- `slow_response_duration`: Elapsed duration (in seconds) to begin logging slow responses

## Database

The `database.php` file includes configuration required by the [Bones database service](https://github.com/bayfrontmedia/bones/blob/master/docs/services/db.md).

## ORM

The `orm.php` file includes configuration required by [bones-service-orm](https://github.com/bayfrontmedia/bones-service-orm/blob/master/docs/setup.md#configuration).

## RBAC

The `rbac.php` file includes configuration required by [bones-service-rbac](https://github.com/bayfrontmedia/bones-service-rbac/blob/master/docs/setup.md#configuration).

## Router

The `router.php` file includes configuration required by the [Bones router service](https://github.com/bayfrontmedia/bones/blob/master/docs/services/router.md).

## Scheduler

The `scheduler.php` file includes configuration required by the [Bones scheduler service](https://github.com/bayfrontmedia/bones/blob/master/docs/services/scheduler.md).