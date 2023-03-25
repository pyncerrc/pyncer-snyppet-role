<?php
namespace Pyncer\Snyppet\Role\Component\Module\Role;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractPostItemModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Data\Validation\ValidatorInterface;
use Pyncer\Snyppet\Role\Table\Role\RoleMapper;
use Pyncer\Snyppet\Role\Table\Role\RoleValidator;

class PostRoleItemModule extends AbstractPostItemModule
{
    protected function forgeValidator(): ?ValidatorInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new RoleValidator($connection);
    }

    protected function forgeMapper(): MapperInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new RoleMapper($connection);
    }
}
