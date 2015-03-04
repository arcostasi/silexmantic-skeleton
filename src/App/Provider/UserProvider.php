<?php

namespace App\Provider;

use App\Model\BaseModel;

use Doctrine\DBAL\Query\QueryBuilder;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;

/**
 * User Provider to the Security Service
 *
 * @author Anderson Costa <arcostasi@gmail.com>
 */
class UserProvider extends BaseModel implements UserProviderInterface {

    /**
     * Load user by username
     * @param string $username
     * @return User
     * @throws \Exception
     */
    public function loadUserByUsername($username)
    {
        $qb = new QueryBuilder($this->db);

        $stmt = $qb->select('username, password, roles')
            ->from('users', 'u')
            ->where('u.username = :username')
            ->andWhere('u.active = 1')
            ->setParameter('username', $username)
            ->execute();

        if (!$user = $stmt->fetchObject()) {
            throw new \Exception(sprintf('Usuário "%s" não encontrado.', $username));
        }

        return new User($user->username, $user->password, explode(',', $user->roles), true, true, true, true);
    }

    /**
     * User refresh
     * @param UserInterface $user
     * @return User
     * @throws \Exception
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new \Exception(sprintf('A interface "%s" não é suportado.'), get_class($user));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * Class supports
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}
