<?php
namespace Pyncer\Snyppet\Role\Component\Module\Role;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractGetItemModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Snyppet\Role\Table\Role\RoleMapper;

class GetRoleItemModule extends AbstractGetItemModule
{
    protected function forgeMapper(): MapperInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new RoleMapper($connection);
    }
}
