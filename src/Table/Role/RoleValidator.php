<?php
namespace Pyncer\Snyppet\Role\Table\Role;

use Pyncer\Data\Validation\AbstractValidator;
use Pyncer\Database\ConnectionInterface;
use Pyncer\Validation\Rule\BoolRule;
use Pyncer\Validation\Rule\EnumRule;
use Pyncer\Validation\Rule\StringRule;

class RoleValidator extends AbstractValidator
{
    public function __construct(ConnectionInterface $connection)
    {
        parent::__construct($connection);

        $this->addRule(
            'name',
            new StringRule(
                maxLength: 50,
            ),
        );

        $this->addRule(
            'alias',
            new StringRule(
                maxLength: 50,
            ),
        );

        $this->addRules(
            'group',
            new EnumRule([
                'guest', 'user', 'admin', 'super'
            ])
        );

        $this->addRule(
            'enabled',
            new BoolRule(),
        );

        $this->addRule(
            'deleted',
            new BoolRule(),
        );
    }
}
