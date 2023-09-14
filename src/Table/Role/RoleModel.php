<?php
namespace Pyncer\Snyppet\Role\Table\Role;

use Pyncer\Data\Model\AbstractModel;
use Pyncer\Snyppet\Access\User\UserGroup;

class RoleModel extends AbstractModel
{
    public function getName(): string
    {
        return $this->get('name');
    }
    public function setName(string $value): static
    {
        $this->set('name', $value);
        return $this;
    }

    public function getAlias(): string
    {
        return $this->get('alias');
    }
    public function setAlias(string $value): static
    {
        $this->set('alias', $value);
        return $this;
    }

    public function getGroup(): UserGroup
    {
        $value = $this->get('group');
        return UserGroup::from($value);
    }
    public function setGroup(string|UserGroup $value): static
    {
        if ($value instanceof UserGroup) {
            $value = $group->value;
        }

        $this->set('group', $value);
        return $this;
    }

    public function getEnabled(): bool
    {
        return $this->get('enabled');
    }
    public function setEnabled(bool $value): static
    {
        $this->set('enabled', $value);
        return $this;
    }

    public function getDeleted(): bool
    {
        return $this->get('deleted');
    }
    public function setDeleted(bool $value): static
    {
        $this->set('deleted', $value);
        return $this;
    }

    public static function getDefaultData(): array
    {
        return [
            'id' => 0,
            'name' => '',
            'alias' => '',
            'group' => 'admin',
            'enabled' => false,
            'deleted' => false,
        ];
    }
}
