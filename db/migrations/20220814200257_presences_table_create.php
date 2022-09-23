<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PresencesTableCreate extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $this->table('presences')
            ->addColumn('dateDePresence', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('id_invitation', 'integer')
            ->addForeignKey('id_invitation', 'invitations', 'id',
                ['delete' => 'NO_ACTION', 'update' => 'CASCADE'])
            ->create();
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->table('presences')->drop();
    }
}
