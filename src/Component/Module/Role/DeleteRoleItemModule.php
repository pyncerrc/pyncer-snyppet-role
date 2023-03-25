<?php
namespace Pyncer\Snyppet\Role\Component\Module\Role;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractDeleteItemModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Snyppet\Role\Table\Role\RoleMapper;

class DeleteRoleItemModule extends AbstractDeleteItemModule
{
    protected function forgeMapper(): MapperInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new RoleMapper($connection);
    }
}
