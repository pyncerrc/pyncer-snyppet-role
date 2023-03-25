<?php
namespace Pyncer\Snyppet\Role\Table\Role;

use Pyncer\Snyppet\Role\Table\Role\RoleModel;
use Pyncer\Data\Mapper\AbstractMapper;
use Pyncer\Data\Model\ModelInterface;

class RoleMapper extends AbstractMapper
{
    public function getTable(): string
    {
        return 'role';
    }

    public function forgeModel(iterable $data = []): ModelInterface
    {
        return new RoleModel($data);
    }

    public function isValidModel(ModelInterface $model): bool
    {
        return ($model instanceof RoleModel);
    }

    public function selectByAlias(
        string $alias,
    ): ?ModelInterface
    {
        return $this->selectByColumns([
            'alias' => $alias,
        ]);
    }
}
