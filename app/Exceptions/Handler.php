<?php /** @noinspection PhpRedundantMethodOverrideInspection */

namespace App\Exceptions;

use Bayfront\Bones\Abstracts\ExceptionHandler;
use Bayfront\Bones\Application\Utilities\App;
use Bayfront\Bones\Interfaces\ExceptionHandlerInterface;
use Bayfront\BonesService\Api\Utilities\ApiError;
use Bayfront\HttpResponse\Response;
use Throwable;

/**
 * Exception Handler.
 */
class Handler extends ExceptionHandler implements ExceptionHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function respond(Response $response, Throwable $e): void
    {
        if (App::isDebug()) {
            parent::respond($response, $e);
        } else {
            ApiError::respond($response, $e, require(App::resourcesPath('/api/api-errors.php')));
        }
    }

}