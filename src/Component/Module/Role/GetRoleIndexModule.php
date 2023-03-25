<?php
namespace Pyncer\Snyppet\Role\Component\Module\Role;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractGetIndexModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Snyppet\Role\Table\Role\RoleMapper;

class GetRoleIndexModule extends AbstractGetIndexModule
{
    protected function forgeMapper(): MapperInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new RoleMapper($connection);
    }
}
