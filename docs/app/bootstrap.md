# Bootstrap

The app bootstrap file is located at `/resources/bootstrap.php`.

Bones bootstrap documentation can be found [here](https://github.com/bayfrontmedia/bones/blob/master/docs/usage/bootstrap.md).

The following services are bootstrapped and placed into the container:

- [bones-service-orm](https://github.com/bayfrontmedia/bones-service-orm/blob/master/docs/setup.md#add-to-container) with alias `ormService`
- [bones-service-rbac](https://github.com/bayfrontmedia/bones-service-rbac/blob/master/docs/setup.md#add-to-container) with alias `rbacService`
- [Leaky Bucket](https://github.com/bayfrontmedia/leaky-bucket) PDO `AdapterInterface` (required by `bones-service-api`)
- [bones-service-api](https://github.com/bayfrontmedia/bones-service-api/blob/master/docs/setup.md#add-to-container) with alias `apiService`
- [Monolog PDO](https://github.com/bayfrontmedia/monolog-pdo) (used by Multi-Logger)
- [Multi-Logger](https://github.com/bayfrontmedia/multi-logger) with alias `log` and channels `SYSTEM` and `AUDIT`