<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FilesTableCreate extends AbstractMigration
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
        $this->table('fichiers')
            ->addColumn('lien_fichier', 'string')
            ->addColumn('id_evenement', 'integer')
            ->addIndex('lien_fichier', ['unique' => true])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('id_evenement', 'evenements', 'id',
                ['delete' => 'NO_ACTION', 'update' => 'CASCADE'])
            ->create();
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->table('fichiers')->drop();
    }
}
