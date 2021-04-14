<?php

use App\Security\Authenticator;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

load::model('user/profile');

/**
 * @property array json
 */
class sign_authorization_action extends frontend_controller
{
    protected $authorized_access = false;

    public function __execute()
    {
        $request       = HttpRequest::createFromGlobals();
        $authenticator = Authenticator::create();

        try {
            $credentials = $authenticator->getCredentials($request);
            $user        = $authenticator->getUser($credentials);

            if (!$authenticator->checkCredentials($credentials, $user)) {
                throw new AccessDeniedException();
            }

            $authenticator->onAuthenticationSuccess($user);
        } catch (Exception $exception) {
            $authenticator->onAuthenticationFailure($request, $exception);
        }
    }

    public function handleRequest()
    {

    }

    public function execute()
    {
        if ('redirect' === request::get_string('act')) {
            $this->redirect('/');
        }

        $this->set_renderer('ajax');
        $this->json = ['success' => true];

        if (!profile_peer::instance()->is_exists(['email' => request::get('login')])) {
            $this->json['success'] = false;

            return false;
        }

        $user_id = user_auth_peer::instance()->get_list(['email' => request::get('login')]);
        $profile = profile_peer::instance()->get_item($user_id[0]);

        if ($profile['password'] !== md5(request::get('password'))) {
            return $this->json['success'] = false;
        }

        if (!$profile['active']) {
            db::exec('UPDATE user_data SET rank = ((SELECT MAX(rank) FROM user_data) + 1) WHERE user_id = :uid', ['uid' => $profile['user_id']]);
            user_auth_peer::instance()->update([
                'id'           => $profile['user_id'],
                'active'       => true,
                'activated_ts' => time(),
            ]);
        }

        session::set_user_id($profile['user_id'], unserialize($profile['credentials']));
        cookie::set('uid', $profile['user_id'], time() + 60 * 60 * 24 * 30, '/', conf::get('server'));
    }


}
