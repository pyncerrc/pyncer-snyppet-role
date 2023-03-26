<?php
namespace Pyncer\Snyppet\Role\Install;

use Pyncer\Database\Table\Column\IntSize;
use Pyncer\Database\Table\ReferentialAction;
use Pyncer\Database\Value;
use Pyncer\Snyppet\AbstractInstall;

class Install extends AbstractInstall
{
    protected function safeInstall(): bool
    {
        $this->connection->createTable('role')
            ->serial('id')
            ->string('name', 50)->null()
            ->string('alias', 50)->null()->index()
            ->enum('group', ['guest', 'user', 'admin', 'super'])->default('admin')->index()
            ->bool('enabled')->default(false)->index()
            ->bool('deleted')->default(false)->index()
            ->execute();

        $this->connection->createTable('user__role')
            ->serial('id')
            ->int('user_id', IntSize::BIG)->index()
            ->int('role_id', IntSize::BIG)->index()
            ->index(null, 'user_id', 'role_id')->unique()
            ->foreignKey(null, 'user_id')
                ->references('user', 'id')
                ->deleteAction(ReferentialAction::CASCADE)
                ->updateAction(ReferentialAction::CASCADE)
            ->foreignKey(null, 'role_id')
                ->references('role', 'id')
                ->deleteAction(ReferentialAction::CASCADE)
                ->updateAction(ReferentialAction::CASCADE)
            ->execute();

        return true;
    }

    protected function safeUninstall(): bool
    {
        if ($connection->hasTable('user__role')) {
            $this->connection->dropTable('user__role');
        }

        if ($connection->hasTable('role')) {
            $this->connection->dropTable('role');
        }

        return true;
    }

    public function getRequired(): array
    {
        return [
            'access' => '*'
        ];
    }
}
