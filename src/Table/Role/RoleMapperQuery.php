<?php
namespace Pyncer\Snyppet\Role\Table\Role;

use Pyncer\Data\MapperQuery\AbstractRequestMapperQuery;
use Pyncer\Snyppet\Access\User\Group;

class RoleMapperQuery extends AbstractRequestMapperQuery
{
    protected function isValidFilter(
        string $left,
        mixed $right,
        string $operator
    ): bool
    {
        if ($left === 'enabled' && is_bool($right) && $operator === '=') {
            return true;
        }

        if ($left === 'deleted' && is_bool($right) && $operator === '=') {
            return true;
        }

        if ($left === 'alias' && is_string($right) && $operator === '=') {
            return true;
        }

        if ($left === 'group' &&
            Group::tryFrom($right) !== null &&
            $operator === '='
        ) {
            return true;
        }

        return parent::isValidFilter($left, $right, $operator);
    }
}
