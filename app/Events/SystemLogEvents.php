<?php

namespace App\Events;

use Bayfront\Bones\Abstracts\EventSubscriber;
use Bayfront\Bones\Application\Services\Events\EventSubscription;
use Bayfront\Bones\Application\Utilities\App;
use Bayfront\Bones\Application\Utilities\Constants;
use Bayfront\Bones\Exceptions\HttpException;
use Bayfront\Bones\Interfaces\EventSubscriberInterface;
use Bayfront\BonesService\Api\Controllers\Abstracts\PrivateApiController;
use Bayfront\BonesService\Rbac\User;
use Bayfront\HttpRequest\Request;
use Bayfront\HttpResponse\Response;
use Bayfront\MultiLogger\Exceptions\ChannelNotFoundException;
use Bayfront\MultiLogger\Log;
use Throwable;

/**
 * System events which are logged.
 */
class SystemLogEvents extends EventSubscriber implements EventSubscriberInterface
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

        return [
            new EventSubscription('app.bootstrap', [$this, 'addExtraInfo'], 5),
            new EventSubscription('app.http', [$this, 'addRequestInfo'], 5),
            new EventSubscription('api.auth.limit', [$this, 'logLimitExceeded'], 10),
            new EventSubscription('api.auth.otp.fail', [$this, 'logAuthOtpFail'], 10),
            new EventSubscription('api.auth.password.fail', [$this, 'logAuthPasswordFail'], 10),
            new EventSubscription('api.auth.refresh.fail', [$this, 'logAuthRefreshFail'], 10),
            new EventSubscription('api.auth.tfa.fail', [$this, 'logAuthTfaFail'], 10),
            new EventSubscription('api.user.password.fail', [$this, 'logUserPasswordFail'], 10),
            new EventSubscription('api.user.password_request.fail', [$this, 'logUserPasswordRequestFail'], 10),
            new EventSubscription('api.user.verification_request.fail', [$this, 'logUserVerificationRequestFail'], 10),
            new EventSubscription('api.user.verification.fail', [$this, 'logUserVerificationFail'], 10),
            new EventSubscription('api.auth.success', [$this, 'logAuthSuccess'], 5),
            new EventSubscription('api.controller.private', [$this, 'addUserToLogs'], 5),
            new EventSubscription('bones.down', [$this, 'logBonesDown'], 10),
            new EventSubscription('bones.up', [$this, 'logBonesUp'], 10),
            new EventSubscription('bones.exception', [$this, 'logException'], 10),
            new EventSubscription('bones.end', [$this, 'logSlowResponse'], 99),
        ];

    }

    /**
     * Add extra info to logs.
     *
     * @return void
     * @throws ChannelNotFoundException
     */
    public function addExtraInfo(): void
    {

        $channels = $this->log->getChannels();

        foreach ($channels as $channel) {

            $logger = $this->log->getChannel($channel);

            $logger->pushProcessor(function ($record) {

                $record['extra']['time'] = date('Y-m-d\TH:i:s.vP');
                $record['extra']['app']['env'] = App::environment();
                $record['extra']['api']['version'] = App::getConfig('api.version');

                if (Constants::isDefined('REQUEST_ID')) {
                    $record['extra']['request']['id'] = Constants::get('REQUEST_ID');
                }

                return $record;

            });

        }

    }

    /**
     * Add request info to logs.
     *
     * @return void
     * @throws ChannelNotFoundException
     */
    public function addRequestInfo(): void
    {

        $channels = $this->log->getChannels();

        foreach ($channels as $channel) {

            $logger = $this->log->getChannel($channel);

            $logger->pushProcessor(function ($record) {

                $record['extra']['request']['method'] = Request::getMethod();
                $record['extra']['request']['path'] = Request::getRequest(Request::PART_PATH);
                $record['extra']['request']['query'] = Request::getRequest(Request::PART_QUERY_STRING);
                $record['extra']['request']['ip'] = Request::getIp();
                $record['extra']['request']['user_agent'] = Request::getUserAgent();

                return $record;

            });

        }

    }

    /**
     * Log rate limit has been exceeded.
     *
     * @return void
     */
    public function logLimitExceeded(): void
    {
        $this->log->notice('Rate limit exceeded');
    }

    /**
     * Log user failed to authenticate using email + OTP.
     *
     * @param string $email
     * @return void
     */
    public function logAuthOtpFail(string $email): void
    {
        $this->log->notice('Failed to authenticate with OTP', [
            'email' => $email
        ]);
    }

    /**
     * Log user failed to authenticate using email + password.
     *
     * @param string $email
     * @return void
     */
    public function logAuthPasswordFail(string $email): void
    {
        $this->log->notice('Failed to authenticate with password', [
            'email' => $email
        ]);
    }

    /**
     * Log user failed to authenticate using refresh token.
     *
     * @return void
     */
    public function logAuthRefreshFail(): void
    {
        $this->log->notice('Failed to authenticate with refresh token');
    }

    /**
     * Log user failed to authenticate using email + TFA.
     *
     * @param string $email
     * @return void
     */
    public function logAuthTfaFail(string $email): void
    {
        $this->log->notice('Failed to authenticate with TFA', [
            'email' => $email
        ]);
    }

    /**
     * Log user failed to reset password using incorrect token.
     *
     * @param string $email
     * @return void
     */
    public function logUserPasswordFail(string $email): void
    {
        $this->log->notice('Failed to reset password', [
            'email' => $email
        ]);
    }

    /**
     * Log user failed to request password reset.
     *
     * @param string $email
     * @return void
     */
    public function logUserPasswordRequestFail(string $email): void
    {
        $this->log->notice('Failed to request password reset', [
            'email' => $email
        ]);
    }

    /**
     * Log user failed to request new email verification.
     *
     * @param string $email
     * @return void
     */
    public function logUserVerificationRequestFail(string $email): void
    {
        $this->log->notice('Failed to request new email verification', [
            'email' => $email
        ]);
    }

    /**
     * Log user failed to verify email.
     *
     * @param string $email
     * @return void
     */
    public function logUserVerificationFail(string $email): void
    {
        $this->log->notice('Failed to verify email', [
            'email' => $email
        ]);
    }

    private ?User $user = null;

    /**
     * Add user ID to logs.
     *
     * @param User $user
     * @return void
     * @throws ChannelNotFoundException
     */
    private function addUserId(User $user): void
    {

        $this->user = $user;

        $channels = $this->log->getChannels();

        foreach ($channels as $channel) {

            $logger = $this->log->getChannel($channel);

            $logger->pushProcessor(function ($record) {

                if ($this->user instanceof User) {
                    $record['extra']['user']['id'] = $this->user->getId();
                }

                return $record;

            });

        }

    }

    /**
     * Add user ID to logs and log successful authentication.
     *
     * @param User $user
     * @return void
     * @throws ChannelNotFoundException
     */
    public function logAuthSuccess(User $user): void
    {
        $this->addUserId($user);
        $this->log->info('User authenticated');
    }

    /**
     * Add user ID to logs.
     *
     * @param PrivateApiController $controller
     * @return void
     * @throws ChannelNotFoundException
     */
    public function addUserToLogs(PrivateApiController $controller): void
    {
        $this->addUserId($controller->user);
    }

    /**
     * Log Bones down.
     *
     * @param array $json
     * @return void
     */
    public function logBonesDown(array $json): void
    {
        $this->log->notice('Bones down', [
            'json' => $json
        ]);
    }

    /**
     * Log Bones up.
     *
     * @return void
     */
    public function logBonesUp(): void
    {
        $this->log->notice('Bones up');
    }

    /**
     * Log exception.
     *
     * @param Response $response
     * @param Throwable $e
     * @return void
     */
    public function logException(Response $response, Throwable $e): void
    {

        if ($e instanceof HttpException) { // Do not log HttpExceptions
            return;
        }

        $this->log->critical('Unexpected exception', [
            'response' => [
                'status' => $response->getStatusCode()['code'],
                'message' => $e->getMessage()
            ],
            'exception' => [
                'type' => get_class($e),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace()
            ]
        ]);

    }

    /**
     * Log slow API response.
     *
     * @param Response $response
     * @return void
     */
    public function logSlowResponse(Response $response): void
    {

        $elapsed = floatval(App::getElapsedTime());

        if ($elapsed > floatval(App::getConfig('app.slow_response_duration', 1))) {

            $this->log->warning('Slow API response', [
                'response' => [
                    'status' => $response->getStatusCode()['code']
                ],
                'elapsed' => $elapsed
            ]);

        }

    }

}