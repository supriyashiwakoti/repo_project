<?php
use Drupal\Core\Database\Database;

function form_install() {
    $schema = form_schema();
    Database::getConnection()->schema()->createTable('information', $schema['information']);
}

function form_schema() {
    $schema['information'] = array(
        'description' => 'Table for storing form submissions',
        'fields' => array(
            'id' => array(
                'type' => 'serial',
                'unsigned' => TRUE,
                'not null' => TRUE,
                'description' => 'Primary Key: Unique identifier for each record.',
            ),
            'username' => array(
                'type' => 'varchar',
                'length' => 255,
                'not null' => TRUE,
                'description' => 'Username from the form submission.',
            ),
            'email' => array(
                'type' => 'varchar',
                'length' => 255,
                'not null' => TRUE,
                'description' => 'Email from the form submission.',
            ),
            'password' => array(
                'type' => 'varchar',
                'length' => 255,
                'not null' => TRUE,
                'description' => 'Password from the form submission.',
            ),
        ),
        'primary key' => array('id'),
        'mysql_engine' => 'InnoDB',
        'mysql_character_set' => 'utf8mb4',
    );

    return $schema;
}





?>
