<?php

namespace App\Provider;

use App\Model\BaseModel;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Provide users to the security service
 *
 * @author Anderson Costa <arcostasi@gmail.com>
 */
class UserProvider extends BaseModel implements UserProviderInterface {

    /**
     * Load user by username
     * @param $user
     * @return $user
     */
    public function loadUserByUsername($username) 
    {
        // tratamento dos caracteres escape usados em SQL injections
        $username = $this->db->real_escape_string($username);

        $sql = <<<"SQL"
SELECT `username`, `email`, `password`, `roles`
FROM users
WHERE username = '$username' AND `status` = 'active'
SQL;

        $result = $this->db->query($sql);

        if (!$result) {
            throw new \Exception(sprintf('SQL Error: %s', $sql));
        }

        if (!$user = $result->fetch_array(MYSQLI_ASSOC)) {
            throw new \Exception(sprintf('Usuário "%s" não encontrado.', $username));
        }

        return new User($user['username'], $user['password'], explode(',', $user['roles']), true, true, true, true);
    }

    public function refreshUser(UserInterface $user) 
    {
        if (!$user instanceof User) {
            throw new \Exception(sprintf('A interface "%s" não é suportado.'), get_class($user));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) 
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}
