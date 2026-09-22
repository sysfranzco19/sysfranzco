<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePosts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 200],
            'content'      => ['type' => 'LONGTEXT', 'null' => true],
            'category'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tags'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'cover_image'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['draft', 'published'], 'default' => 'draft'],
            'published_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey(['status', 'published_at']);
        $this->forge->createTable('posts');
    }

    public function down()
    {
        $this->forge->dropTable('posts');
    }
}
