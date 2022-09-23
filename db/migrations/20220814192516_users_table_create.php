<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UsersTableCreate extends AbstractMigration
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
        $this->table('utilisateurs')
            ->addColumn('prenoms', 'string', ['limit' => 70])
            ->addColumn('nom', 'string', ['limit' => 50])
            ->addColumn('sexe', 'string', ['limit' => 2])
            ->addColumn('email', 'string', ['limit' => 40])
            ->addColumn('tel', 'string', ['limit' => 15])
            ->addColumn('mot_de_passe', 'string')
            ->addColumn('statut', 'boolean', ['default' => true])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex('email', ['unique' => true])
            ->addIndex('tel', ['unique' => true])
            ->create();
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->table('utilisateurs')->drop();
    }
}
