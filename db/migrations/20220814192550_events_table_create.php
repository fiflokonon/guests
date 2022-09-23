<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class EventsTableCreate extends AbstractMigration
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
        $this->table('evenements')
            ->addColumn('titre', 'string', ['limit' => 200])
            ->addColumn('slogan', 'string', ['limit' => 200])
            ->addColumn('description', 'string')
            ->addColumn('lieu', 'string')
            ->addColumn('date_de_debut', 'timestamp')
            ->addColumn('date_de_fin', 'timestamp')
            ->addColumn('id_utilisateur', 'integer')
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('id_utilisateur', 'utilisateurs', 'id',
                ['delete' => 'NO_ACTION', 'update' => 'CASCADE'])
            ->addIndex('slogan', ['unique' => true])
            ->create();;
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->table('evenements')->drop();
    }
}
