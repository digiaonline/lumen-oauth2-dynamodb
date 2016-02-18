<?php namespace Nord\Lumen\OAuth2\DynamoDB;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use League\OAuth2\Server\Storage\ClientInterface;
use League\OAuth2\Server\Storage\RefreshTokenInterface;
use League\OAuth2\Server\Storage\ScopeInterface;
use League\OAuth2\Server\Storage\SessionInterface;
use Nord\Lumen\OAuth2\DynamoDB\Storages\AccessTokenStorage;
use Nord\Lumen\OAuth2\DynamoDB\Storages\ClientStorage;
use Nord\Lumen\OAuth2\DynamoDB\Storages\RefreshTokenStorage;
use Nord\Lumen\OAuth2\DynamoDB\Storages\ScopeStorage;
use Nord\Lumen\OAuth2\DynamoDB\Storages\SessionStorage;

class DynamoDBServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerContainerBindings($this->app);
    }


    /**
     *
     */
    protected function registerContainerBindings(Container $container)
    {
        $container->bind(AccessTokenStorage::class, function () {
            return new AccessTokenStorage;
        });

        $container->bind(ClientStorage::class, function () {
            return new ClientStorage;
        });

        $container->bind(RefreshTokenStorage::class, function () {
            return new RefreshTokenStorage;
        });

        $container->bind(ScopeStorage::class, function () {
            return new ScopeStorage;
        });

        $container->bind(SessionStorage::class, function () {
            return new SessionStorage;
        });

        $container->bind(AccessTokenInterface::class, AccessTokenStorage::class);
        $container->bind(ClientInterface::class, ClientStorage::class);
        $container->bind(RefreshTokenInterface::class, RefreshTokenStorage::class);
        $container->bind(ScopeInterface::class, ScopeStorage::class);
        $container->bind(SessionInterface::class, SessionStorage::class);
    }
}
