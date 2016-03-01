<?php namespace Nord\Lumen\OAuth2\DynamoDB\Storages;

use Carbon\Carbon;
use Crisu83\ShortId\ShortId;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Exception\AccessDeniedException;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use Nord\Lumen\OAuth2\DynamoDB\Models\AccessToken;
use Nord\Lumen\OAuth2\Exceptions\AccessTokenNotFound;

/**
 * Class AccessTokenStorage.
 *
 * @package Nord\Lumen\OAuth2\DynamoDB\Storages
 */
class AccessTokenStorage extends DynamoDBStorage implements AccessTokenInterface
{

    /**
     * @inheritdoc
     */
    public function get($token)
    {
        $accessToken = $this->findByToken($token);

        if ($accessToken === null) {
            throw new AccessDeniedException;
        }

        return $this->createEntity($accessToken);
    }

    /**
     * @inheritdoc
     */
    public function getScopes(AccessTokenEntity $token)
    {
    }

    /**
     * @inheritdoc
     */
    public function create($token, $expireTime, $sessionId)
    {
        $accessToken = new AccessToken([
            'sessionId'  => $sessionId,
            'expireTime' => Carbon::createFromTimestamp($expireTime)->format('Y-m-d H:i:s'),
        ]);

        $accessToken->setId($token);
        $accessToken->save();
    }

    /**
     * @inheritdoc
     */
    public function associateScope(AccessTokenEntity $token, ScopeEntity $scope)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * @inheritdoc
     */
    public function delete(AccessTokenEntity $token)
    {
        $accessToken = $this->findByToken($token->getId());

        if ($accessToken === null) {
            throw new AccessTokenNotFound;
        }

        $accessToken->delete();
    }

    /**
     * @param AccessToken $accessToken
     *
     * @return AccessTokenEntity
     */
    protected function createEntity(AccessToken $accessToken)
    {
        $entity = new AccessTokenEntity($this->server);

        $entity->setId($accessToken->token);
        $entity->setExpireTime(Carbon::createFromFormat('Y-m-d H:i:s', $accessToken->expireTime)->getTimestamp());

        return $entity;
    }

    /**
     * @param string $token
     *
     * @return AccessToken
     */
    protected function findByToken($token)
    {
        return AccessToken::findByToken($token);
    }
}
