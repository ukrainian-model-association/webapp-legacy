<?php

namespace App\Security;

use App\DB\Query;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class Authenticator
{
    public static function create()
    {
        return new self();
    }

    /**
     * @param HttpRequest $request
     *
     * @return Credentials
     */
    public function getCredentials($request)
    {
        return Credentials::create()
            ->setUsername($request->get('login'))
            ->setPassword($request->get('password'));
    }

    /**
     * @param Credentials $credentials
     *
     * @return User|null
     */
    public function getUser($credentials)
    {
        $userData = Query::create()
            ->setSql('select ua.* from user_auth ua where `ua.email` = :username limit 1')
            ->setParameter('username', $credentials->getUsername())
            ->execute();

        if (!$userData) {
            return null;
        }

        return User::create($userData);
    }

    /**
     * @param Credentials $credentials
     * @param User        $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, $user)
    {
        if (null === $credentials->getPassword() || md5($credentials->getPassword()) !== $user->getPassword()) {
            return false;
        }

        return true;
    }

    /**
     * @param User $user
     *
     * @return null
     */
    public function onAuthenticationSuccess($user)
    {
        if (!$user->isActivated()) {
            db::exec('UPDATE user_data SET rank = ((SELECT MAX(rank) FROM user_data) + 1) WHERE user_id = :uid', ['uid' => $user->getId()]);
            user_auth_peer::instance()->update([
                'id'           => $user->getId(),
                'active'       => true,
                'activated_ts' => time(),
            ]);
        }

        session::set_user_id($user->getId(), unserialize($user->getCredentials()));
        cookie::set('uid', $user->getId(), time() + 60 * 60 * 24 * 30, '/', conf::get('server'));

        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
