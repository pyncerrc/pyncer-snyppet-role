<?php
namespace Pyncer\Snyppet\Role;

use Pyncer\Database\ConnectionInterface;
use Pyncer\Database\ConnectionTrait;
use Pyncer\Snyppet\Access\Table\User\UserModel;
use Pyncer\Snyppet\Access\User\UserGroup;

class RoleManager
{
    /**
     * @var array<RoleModel>
     */
    protected array $roles = [];

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

        switch ($this->userModel->getGroup()) {
            case UserGroup::SUPER:
                $this->roles[] = 'super';
                $this->roles[] = 'admin';
                $this->roles[] = 'user';
            case UserGroup::ADMIN:
                $where->compare('group', 'super', '!=');
                $this->roles[] = 'admin';
                $this->roles[] = 'user';
                break;
            case UserGroup::USER:
                $where->compare('group', 'super', '!=');
                $where->compare('group', 'admin', '!=');
                $this->roles[] = 'user';
                break;
            case UserGroup::GUEST:
                $where->compare('group', 'guest');
                $this->roles[] = 'guest';
                break;
        }

        $result = $query->execute();

        while ($row = $this->connection->fetch($result)) {
            $this->roles[] = $row['alias'];
        }
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = array_unique($roles);
        return $this;
    }

    public function addRoles(string ...$roles): static
    {
        $this->roles = [$this->roles, ...$roles];
        $this->roles = array_unique($this->roles);
        return $this;
    }

    public function deleteRoles(string ...$roles): static
    {
        $resultRoles = [];

        foreach ($this->roles as $role) {
            if (!in_array($role, $roles)) {
                $resultRoles[] = $role;
            }
        }

        $this->roles = $resultRoles;
        return $this;
    }

    public function isGuest(): bool
    {
        return ($this->userModel->getGroup() === UserGroup::GUEST);
    }

    public function isUser(): bool
    {
        if ($this->isSuper() || $this->isAdmin()) {
            return true;
        }

        return ($this->userModel->getGroup() === UserGroup::USER);
    }

    public function isAdmin(): bool
    {
        if ($this->isSuper()) {
            return true;
        }

        return ($this->userModel->getGroup() === UserGroup::ADMIN);
    }

    public function isSuper(): bool
    {
        return ($this->userModel->getGroup() === UserGroup::SUPER);
    }

    public function is(string $role): bool
    {
        return $this->isAnyOf($role);
    }

    public function isAnyOf(string ...$roles): bool
    {
        if ($this->isSuper()) {
            return true;
        }

        foreach ($roles as $role) {
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
            if (!in_array($this->roles, $role, true)) {
                return false;
            }
        }

        return true;
    }
}
