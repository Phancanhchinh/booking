<?php
namespace GD\Api\Traits;
use GD\Api\Models\UserToken;
trait CanFindUserWithBearerToken
{
    /**
     * @param string $token
     * @return UserInterface|null
     */
    public function findUserWithBearerToken($token)
    {
        $token = UserToken::findByToken($this->parseToken($token));
        if ($token === null) {
            return null;
        }
        return $token->user;
    }

    private function parseToken($token)
    {
        return str_replace('Bearer ', '', $token);
    }
}
