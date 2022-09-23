<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InvitationsTableCreate extends AbstractMigration
{
    /**
     * Ch:ange Method.
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
        $this->table('invitations')
            ->addColumn('nomPrenoms', 'string', ['limit' => 100])
            ->addColumn('id_evenement', 'integer')
            ->addColumn('nombre', 'integer', ['limit' => 50])
            ->addColumn('lien_carte', 'string', ['default' => null])
            ->addColumn('lien_code', 'string', ['default' => null])
            ->addColumn('retour', 'boolean')
            ->addColumn('statut_envoye', 'boolean', ['default' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex('nomPrenoms', ['unique' => true])
            ->addIndex('lien_code', ['unique' => true])
            ->addIndex('lien_carte', ['unique' => true])
            ->addForeignKey('id_evenement', 'evenements', 'id',
                ['delete' => 'NO_ACTION', 'update' => 'CASCADE'])
            ->create();
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->table('invitations')->drop();
    }
}
