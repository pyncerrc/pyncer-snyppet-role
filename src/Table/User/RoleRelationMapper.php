<?php
namespace Pyncer\Snyppet\Role\Table\User;

use Pyncer\Data\Mapper\AbstractRelationMapper;

class RoleRelationMapper extends AbstractRelationMapper
{
    public function getTable(): string
    {
        return 'user__role';
    }

    public function getParentIdColumn(): string
    {
        return 'user_id';
    }

    public function getChildIdColumn(): string
    {
        return 'role_id';
    }
}
