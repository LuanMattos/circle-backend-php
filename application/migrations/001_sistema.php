<?php


class Migration_Sistema extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(
           ['codigo' =>
                ['type' =>
                    'INT',
                    'constraint' => 9,
                    'unsigned' => true,
                    'auto_increment' => true
                ],
            ]
        );
        $this->dbforge->add_key('codigo', TRUE);
        $this->dbforge->create_table('da_dados_globais');
    }

    public function down()
    {
        $this->dbforge->drop_table('da_dados_globais');
    }
}