<?php
namespace Pyncer\Snyppet\Role\Component\Module\Role;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractGetItemModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Data\MapperQuery\MapperQueryInterface;
use Pyncer\Snyppet\Role\Table\Role\RoleMapper;
use Pyncer\Snyppet\Role\Table\Role\RoleMapperQuery;

class GetRoleItemModule extends AbstractGetItemModule
{
    protected function forgeMapper(): MapperInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new RoleMapper($connection);
    }

    protected function forgeMapperQuery(): MapperQueryInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new RoleMapperQuery($connection);
    }
}
