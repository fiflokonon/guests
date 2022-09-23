<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PhotoProfilesTableCreate extends AbstractMigration
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
        $this->table('photos')
            ->addColumn('lien_photo', 'string')
            ->addColumn('id_utilisateur', 'integer')
            ->addIndex('lien_photo', ['unique' => true])
            ->addColumn('statut', 'boolean', ['default' => true])
            ->addForeignKey('id_utilisateur', 'utilisateurs', 'id',
                ['delete' => 'NO_ACTION', 'update' => 'CASCADE'])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->table('photos')->drop();
    }
}
