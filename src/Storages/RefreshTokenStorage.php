<?php namespace Nord\Lumen\OAuth2\DynamoDB\Storages;

use Carbon\Carbon;
use Crisu83\ShortId\ShortId;
use League\OAuth2\Server\Entity\RefreshTokenEntity;
use League\OAuth2\Server\Storage\RefreshTokenInterface;
use Nord\Lumen\OAuth2\DynamoDB\Models\AccessToken;
use Nord\Lumen\OAuth2\DynamoDB\Models\RefreshToken;
use Nord\Lumen\OAuth2\Exceptions\RefreshTokenNotFound;

/**
 * Class RefreshTokenStorage.
 *
 * @package Nord\Lumen\OAuth2\DynamoDB\Storages
 */
class RefreshTokenStorage extends DynamoDBStorage implements RefreshTokenInterface
{

    /**
     * @inheritdoc
     */
    public function get($token)
    {
        $refreshToken = $this->findByToken($token);

        if ($refreshToken === null) {
            throw new RefreshTokenNotFound;
        }

        return $this->createEntity($refreshToken);
    }

    /**
     * @inheritdoc
     */
    public function create($token, $expireTime, $accessToken)
    {
        $accessToken = AccessToken::findByToken($accessToken);

        $refreshToken = new RefreshToken([
            'accessTokenId' => $accessToken->getKey(),
            'expireTime'    => Carbon::createFromTimestamp($expireTime)->format('Y-m-d H:i:s'),
        ]);
        $refreshToken->setId($token);
        $refreshToken->save();

        return $this->createEntity($refreshToken);
    }

    /**
     * @inheritdoc
     */
    public function delete(RefreshTokenEntity $token)
    {
        $refreshToken = $this->findByToken($token->getId());

        if ($refreshToken === null) {
            throw new RefreshTokenNotFound;
        }

        $refreshToken->delete();
    }

    /**
     * @param RefreshToken $refreshToken
     *
     * @return RefreshTokenEntity
     */
    protected function createEntity(RefreshToken $refreshToken)
    {
        $entity = new RefreshTokenEntity($this->server);

        $entity->setId($refreshToken->token);
        $entity->setAccessTokenId($refreshToken->accessTokenId);
        $entity->setExpireTime(Carbon::createFromFormat('Y-m-d H:i:s', $refreshToken->expireTime)->getTimestamp());

        return $entity;
    }

    /**
     * @param string $token
     *
     * @return RefreshToken
     * @throws RefreshTokenNotFound
     */
    protected function findByToken($token)
    {
        $refreshToken = RefreshToken::findByToken($token);

        if ($refreshToken === null) {
            throw new RefreshTokenNotFound;
        }

        return $refreshToken;
    }
}
