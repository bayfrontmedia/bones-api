<?php

namespace App\Events;

use Bayfront\Bones\Abstracts\EventSubscriber;
use Bayfront\Bones\Application\Services\Events\EventSubscription;
use Bayfront\Bones\Application\Utilities\App;
use Bayfront\Bones\Interfaces\EventSubscriberInterface;
use Bayfront\HttpResponse\Response;
use Bayfront\MultiLogger\Log;

/**
 * Actions to perform when environment = "dev".
 */
class DevEvents extends EventSubscriber implements EventSubscriberInterface
{

    protected Log $log;

    /**
     * The container will resolve any dependencies.
     */
    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    /**
     * @inheritDoc
     */
    public function getSubscriptions(): array
    {

        if (App::environment() != App::ENV_DEV) {
            return [];
        }

        return [
            new EventSubscription('bones.end', [$this, 'logAllRequests'], 99)
        ];

    }

    /**
     * Log all HTTP requests.
     *
     * @param Response $response
     * @return void
     */
    public function logAllRequests(Response $response): void
    {

        if (App::getInterface() == App::INTERFACE_HTTP) {

            $response_code = $response->getStatusCode()['code'];

            $this->log->debug('Response: ' . $response_code, [
                'response' => [
                    'size' => strlen($response->getBody()),
                    'status' => $response_code
                ],
                'elapsed' => floatval(App::getElapsedTime())
            ]);

        }

    }

}