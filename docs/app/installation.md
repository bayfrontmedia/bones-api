# Installation

These instructions are for the initial installation of this application.

- [Create project](#create-project)
- [Define environment variables](#define-environment-variables)
- [Configure the app](#configure-the-app)
- [Set file permissions](#set-file-permissions)
- [Database migration](#database-migration)
- [Scheduled jobs](#scheduled-jobs)
- [Exception links](#exception-links)
- [Message events](#message-events)
- [Resource pruning](#resource-pruning)
- [Deployment](#deployment)
- [Assets](#assets)

## Create project

```shell
composer create-project bayfrontmedia/bones-api PROJECT_NAME
```

## Define environment variables

Rename `.env.example` to `.env` and update. ([See docs](https://github.com/bayfrontmedia/bones/blob/master/docs/install/manual.md#add-required-environment-variables))

> **NOTE:** Be sure to define a cryptographically secure app key for the APP_KEY variable.

Once Bones is installed, you can use the `php bones install:key` command to replace `SECURE_APP_KEY` with a valid key,
or you can use the `php bones make:key` command to generate a key you can define manually.

## Configure the app

Update all configuration files at `config/*.php` as needed. ([See configuration](configuration.md))

## Set file permissions

The web server must have write permissions to the `storage/app` directory.
Typically, this is done by granting the `www-data` group ownership and write access:

```shell
chgrp -R www-data /path/to/storage/app
chmod -R 775 /path/to/storage/app
```

## Database migration

Run the initial database migration using:

```shell
php bones migrate:up
```

The API service includes an [optional database seeding](https://github.com/bayfrontmedia/bones-service-api/blob/master/docs/setup.md#database-migration-and-seeding) to add an initial admin user and all the necessary permissions:

```shell
php bones api:seed user@example.com password

# Force seeding (no input/confirmation required)
php bones api:seed user@example.com password --force
```

The password is optional. If not provided, one will be created automatically.

## Scheduled jobs

The `php bones schedule:run` command must be setup to run every minute.
If a cron job will be used to run the scheduled jobs, add a new entry to your crontab to run every minute:

```shell
* * * * * cd /path/to/your/app && php bones schedule:run >> /dev/null 2>&1

# Path to PHP binary may need to be defined
* * * * * /path/to/php/bin cd /path/to/your/app && php bones schedule:run >> /dev/null 2>&1
```

## Exception links

Update the `resources/api/api-errors.php` file as needed to provide links to be returned with API errors.

For more information, see [exceptions](exceptions.md).

## Message events

The `app/Events/MessageEvents` event subscriber exists for events which may send messages.
These events must be updated to be handled as desired.

Until these are set up, authentication abilities may be restricted if a [TFA/OTP code](configuration.md#api) is required.

## Resource pruning

All soft-deleted resources which no longer need to exist in the database should be periodically pruned with [purgeTrashed](https://github.com/bayfrontmedia/bones-service-orm/blob/master/docs/traits/softdeletes.md#purgetrashed).
In addition, the [logs table](configuration.md#app) should be periodically exported/saved and pruned.

These can be done using a [scheduled job](../events/scheduledjobs.md).

## Deployment

### Self-hosted

Self-hosted deployment can be handled with the `deploy:app` [console command](console.md#deployapp).

### DigitalOcean

To deploy to DigitalOcean app platform:

[![Deploy to DO](https://www.deploytodo.com/do-btn-blue.svg)](https://cloud.digitalocean.com/apps/new?repo=https://github.com/bayfrontmedia/bones-api/tree/master&refcode=7e41d0ac1ab5)

When deploying to DigitalOcean, be sure to update the environment variables in `.do/deploy.template.yaml`
and encrypt the `APP_KEY` and applicable `DB_*` values.

## Assets

Postman collection and environment export files which cover all the routes and functionality of this project
are available in the [API service repository](https://github.com/bayfrontmedia/bones-service-api/tree/master/docs/assets).