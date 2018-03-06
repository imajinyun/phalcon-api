<?php

namespace App\Auth;

use App\Model\User;
use App\Service;
use Phalcon\Di;

class EmailAccountType implements AccountTypeInterface
{
    public const NAME = 'email';

    /**
     * User login.
     *
     * @param array $data
     *
     * @return mixed|null|string
     */
    public function login(array $data)
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get(Service::SECURITY);
        $email = $data[Manager::LOGIN_EMAIL];
        $password = $data[Manager::LOGIN_PASSWORD];

        $bindParams = ['email' => $email];
        $user = User::findFirst([
            'columns'    => (new User())->columnMap(),
            'conditions' => 'email=:email:',
            'limit'      => 1,
            'bind'       => $bindParams,
        ]);

        if (! $user) {
            return null;
        }

        if (! $security->checkHash($password, $user->getPassword())) {
            return null;
        }

        return (string)$user->getId();
    }

    /**
     * User authenticate.
     *
     * @param string $identity
     *
     * @return bool|mixed
     */
    public function authenticate($identity)
    {
        $count = User::count([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $identity],
        ]);

        return $count > 0;
    }
}
