# Exceptions

The app exceptions are located at `/app/Exceptions`.

Bones exceptions documentation can be found [here](https://github.com/bayfrontmedia/bones/blob/master/docs/usage/exceptions.md).

- [Handler](#handler)

## Handler

The exception handler is located at `/app/Exceptions/Handler.php`.

This file is responsible for managing how the app responds to exceptions.

For more information, see [exception handler](https://github.com/bayfrontmedia/bones/blob/master/docs/usage/exceptions.md#exception-handler).

### API exceptions

When the app is in debug mode, the default Bones exception handler is used.
Otherwise, the API service is used to create an `ErrorResource` schema to respond to all exceptions.
The `resources/api/api-errors.php` file is used to populate links returned with the error.

For more information, see [API service exception handler](https://github.com/bayfrontmedia/bones-service-api/blob/master/docs/exceptions.md#exception-handler).