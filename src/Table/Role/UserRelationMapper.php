<?php
namespace Pyncer\Snyppet\Role\Table\Role;

use Pyncer\Data\Mapper\AbstractRelationMapper;

class UserRelationMapper extends AbstractRelationMapper
{
    public function getTable(): string
    {
        return 'user__role';
    }

    public function getParentIdColumn(): string
    {
        return 'role_id';
    }

    public function getChildIdColumn(): string
    {
        return 'user_id';
    }
}
