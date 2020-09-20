<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_staff extends CI_Migration {

    public function __construct()
    {
        $this->load->dbforge();
        $this->load->database();
    }

    public function up() 
    {
        $this->dbforge->add_field(array(
            'id' => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => TRUE,
                'auto_increment'    => TRUE
            ],
            'first_name' => [
                'type'          => 'VARCHAR',
                'constraint'    => '150'
            ],
            'surname' => [
                'type'          => 'VARCHAR',
                'constraint'    => 150
            ],
            'email' => [
                'type'          => 'VARCHAR',
                'constraint'    => 150,
                'unique'        => TRUE
            ],
            'phone_no' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100
            ],
            'role' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100
            ],
            'course_being_taught' => [
                'type'          => 'VARCHAR',
                'constraint'    => 100
            ],
            'created_at' => [
                'type'              => 'TIMESTAMP',
                'current_timestamp' => TRUE
            ] 
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('staffs');
    }

    public function down() 
    {
        $this->dbforge->drop_table('staffs');
    }
}

/* End of file Add_staff.php */
