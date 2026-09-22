<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateComments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'post_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'author_name'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'author_email' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'content'      => ['type' => 'TEXT'],
            'status'       => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'spam'], 'default' => 'pending'],
            'ip_address'   => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['post_id', 'status']);
        $this->forge->addKey(['ip_address', 'created_at']);
        $this->forge->addForeignKey('post_id', 'posts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('comments');
    }

    public function down()
    {
        $this->forge->dropTable('comments');
    }
}
