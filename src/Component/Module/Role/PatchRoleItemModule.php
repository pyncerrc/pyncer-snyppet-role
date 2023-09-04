<?php
namespace Pyncer\Snyppet\Role\Component\Module\Role;

use Pyncer\App\Identifier as ID;
use Pyncer\Component\Module\AbstractPatchItemModule;
use Pyncer\Data\Mapper\MapperInterface;
use Pyncer\Data\MapperQuery\MapperQueryInterface;
use Pyncer\Data\Validation\ValidatorInterface;
use Pyncer\Snyppet\Role\Table\Role\RoleMapper;
use Pyncer\Snyppet\Role\Table\Role\RoleMapperQuery;
use Pyncer\Snyppet\Role\Table\Role\RoleValidator;

class PatchRoleItemModule extends AbstractPatchItemModule
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

    protected function forgeMapperQuery(): MapperQueryInterface
    {
        $connection = $this->get(ID::DATABASE);
        return new RoleMapperQuery($connection, $this->request);
    }
}
