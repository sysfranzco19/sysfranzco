<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjects extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'                 => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'                  => ['type' => 'VARCHAR', 'constraint' => 150],
            'short_description'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'description'           => ['type' => 'TEXT', 'null' => true],
            'category'              => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'status'                => ['type' => 'ENUM', 'constraint' => ['draft', 'published'], 'default' => 'draft'],
            'demo_url'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'requires_subscription' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'youtube_url'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'            => ['type' => 'DATETIME', 'null' => true],
            'updated_at'            => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('status');
        $this->forge->createTable('projects');

        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'project_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'image_path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'is_cover'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('project_images');
    }

    public function down()
    {
        $this->forge->dropTable('project_images');
        $this->forge->dropTable('projects');
    }
}
