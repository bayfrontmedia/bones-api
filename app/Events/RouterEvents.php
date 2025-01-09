<?php

namespace App\Events;

use Bayfront\Bones\Abstracts\EventSubscriber;
use Bayfront\Bones\Application\Services\Events\EventSubscription;
use Bayfront\Bones\Application\Services\Filters\FilterService;
use Bayfront\Bones\Application\Utilities\App;
use Bayfront\Bones\Interfaces\EventSubscriberInterface;
use Bayfront\BonesService\Api\Utilities\ApiRoutes;
use Bayfront\RouteIt\Router;

/**
 * Router-related events.
 */
class RouterEvents extends EventSubscriber implements EventSubscriberInterface
{

    protected Router $router;
    protected FilterService $filter;

    /**
     * The container will resolve any dependencies.
     */
    public function __construct(Router $router, FilterService $filter)
    {
        $this->router = $router;
        $this->filter = $filter;
    }

    /**
     * NOTE:
     * Technically, routes do not have to be added until the app.http event,
     * however, if they are to be available via CLI, such as with the
     * route:list command, they need to be added earlier.
     *
     * @inheritDoc
     */
    public function getSubscriptions(): array
    {

        return [
            new EventSubscription('app.bootstrap', [$this, 'addRoutes'], 10)
        ];

    }

    /**
     * Define all routes.
     *
     * For API service predefined routes,
     * see: https://github.com/bayfrontmedia/bones-service-api/blob/master/docs/setup.md#routes
     *
     * @return void
     */
    public function addRoutes(): void
    {

        $this->router->setHost(App::getConfig('router.host'))
            ->setRoutePrefix(App::getConfig('router.route_prefix')) // Unfiltered
            ->addNamedRoute('/storage', 'storage')
            ->setRoutePrefix($this->filter->doFilter('router.route_prefix', App::getConfig('router.route_prefix'))) // Filtered
            ->addFallback('ANY', function () {
                App::abort(404);
            })
            ->addRedirect('GET', '/', '/api/v1/server/status');

        ApiRoutes::define($this->router, '/api/v1');

    }

}