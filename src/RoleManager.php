<?php
namespace Pyncer\Snyppet\Role;

use Pyncer\Database\ConnectionInterface;
use Pyncer\Database\ConnectionTrait;
use Pyncer\Snyppet\Access\Table\User\UserModel;
use Pyncer\Snyppet\Access\User\Group;

class RoleManager
{
    /**
     * @var array<RoleModel>
     */
    protected array $roles;

    public function __construct(
        protected ConnectionInterface $connection,
        protected UserModel $userModel
    ) {
        $this->initializeRoles();
    }

    protected function initializeRoles(): void
    {
        $query = $this->connection->select('role')
            ->columns('alias')
            ->join('user__role', 'role_id', 'id');

        $where = $query->getWhere();

        $where->compare('enabled', true)
            ->compare('deleted', false)
            ->compare(['user__role', 'user_id'], $this->userModel->getId());

        switch ($this->user->getGroup()) {
            case 'admin':
                $where->compare('group', 'super', '!=');
                break;
            case 'user':
                $where->compare('group', 'super', '!=');
                $where->compare('group', 'admin', '!=');
                break;
            case 'guest':
                $where->compare('group', 'guest');
                break;
        }

        $result = $query->execute();

        while ($row = $this->connection->fetch($result)) {
            $this->roles[] = $row['alias'];
        }
    }

    public function isGuest(): bool
    {
        return ($this->userModel->getGroup() === Group::GUEST);
    }

    public function isUser(): bool
    {
        if ($this->isSuper() || $this->isAdmin()) {
            return true;
        }

        return ($this->userModel->getGroup() === Group::USER);
    }

    public function isAdmin(): bool
    {
        if ($this->isSuper()) {
            return true;
        }

        return ($this->userModel->getGroup() === Group::ADMIN);
    }

    public function isSuper(): bool
    {
        return ($this->userModel->getGroup() === Group::SUPER);
    }

    public function isAnyOf(string ...$roles): bool
    {
        if ($this->isSuper()) {
            return true;
        }

        foreach ($roles as $role) {
            switch ($role) {
                case 'super':
                    if ($this->isSuper()) {
                        return true;
                    }
                    break;
                case 'admin':
                    if ($this->isAdmin()) {
                        return true;
                    }
                    break;
                case 'user':
                    if ($this->isUser()) {
                        return true;
                    }
                    break;
                case 'guest':
                    if ($this->isGuest()) {
                        return true;
                    }
                    break;
            }

            if (in_array($role, $this->roles, true)) {
                return true;
            }
        }

        return false;
    }

    public function isAllOf(string ...$roles): bool
    {
        if ($this->isSuper()) {
            return true;
        }

        foreach ($roles as $role) {
            switch ($role) {
                case 'super':
                    if (!$this->isSuper()) {
                        return false;
                    }
                    break;
                case 'admin':
                    if (!$this->isAdmin()) {
                        return false;
                    }
                    break;
                case 'user':
                    if (!$this->isUser()) {
                        return false;
                    }
                    break;
                case 'guest':
                    if (!$this->isGuest()) {
                        return false;
                    }
                    break;
            }

            if (!in_array($this->roles, $role, true)) {
                return false;
            }
        }

        return true;
    }
}
