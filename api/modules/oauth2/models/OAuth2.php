<?php
namespace api\modules\oauth2\models;

use Yii;
use OAuth2\Storage\UserCredentialsInterface;

class OAuth2 extends \common\models\User implements UserCredentialsInterface
{
    /**
     * Implemented for Oauth2 Interface
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        $token = $module->getServer()->getResourceController()->getToken();
        return !empty($token['user_id'])
            ? static::findIdentity($token['user_id'])
            : null;
    }

    /**
     * Implemented for Oauth2 Interface
     */
    public function checkUserCredentials($email, $password)
    {
        $user = static::findByEmail($email);
        if (empty($user)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    /**
     * Implemented for Oauth2 Interface
     */
    public function getUserDetails($email)
    {
        $user = static::findByEmail($email);
        return ['user_id' => $user->getId()];
    }

/*
	public function validateRequest(RequestInterface $request, ResponseInterface $response)
    {
        if (!$request->request("password") || !$request->request("email")) {
            $response->setError(400, 'invalid_request', 'Missing parameters: "email" and "password" required');

            return null;
        }

        if (!$this->storage->checkUserCredentials($request->request("email"), $request->request("password"))) {
            $response->setError(401, 'invalid_grant', 'Invalid email and password combination');

            return null;
        }

        $userInfo = $this->storage->getUserDetails($request->request("email"));

        if (empty($userInfo)) {
            $response->setError(400, 'invalid_grant', 'Unable to retrieve user information');

            return null;
        }

        if (!isset($userInfo['user_id'])) {
            throw new \LogicException("you must set the user_id on the array returned by getUserDetails");
        }

        $this->userInfo = $userInfo;

        return true;
    }
*/
}