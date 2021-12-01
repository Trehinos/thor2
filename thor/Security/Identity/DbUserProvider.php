<?php

namespace Thor\Security\Identity;

use Thor\Database\PdoTable\{Criteria, CrudHelper};

/**
 * This class provides a way to retrieve a DbUser from DB.
 *
 * @package          Thor/Security/Identity
 * @copyright (2021) Sébastien Geldreich
 * @license          MIT
 */
class DbUserProvider implements ProviderInterface
{

    public function __construct(
        private CrudHelper $userCrud,
        private string $usernameField
    ) {
    }

    public function getIdentity(string $identifier): ?DbUser
    {
        return $this->userCrud->readOneBy(new Criteria([$this->usernameField => $identifier]));
    }

}
