# Console

The app console commands are located at `/app/Console/Commands`.

Bones console documentation can be found [here](https://github.com/bayfrontmedia/bones/blob/master/docs/usage/console.md).

- [DeployApp](#deployapp)

## DeployApp

This command is designed to help facilitate the app deployment process.

An example has been given, but you will most likely need to customize this command
depending on your application and server configuration.

```shell
# Deploy application
# TARGET examples: origin/master (branch), v1.0.0 (tag), or commit hash
php bones deploy:app TARGET
```