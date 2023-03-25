<?php
namespace Pyncer\Snyppet\Role\Component\Module\Role;

use Pyncer\App\Identifier as ID;
use Pyncer\Snyppet\Role\Table\Role\RoleMapper;
use Pyncer\Component\Module\AbstractDeleteIndexModule;
use Pyncer\Data\Mapper\MapperInterface;

class DeleteRoleItemModule extends AbstractDeleteIndexModule
{
    protected function forgeMapper(): MapperInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new RoleMapper($connection);
    }
}
