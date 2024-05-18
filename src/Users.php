<?php

namespace API;

use FASTSQL\SecureSQLGenerator;
use FASTSQL\FieldDefinition;
use FASTSQL\TableManipulator;

class Users{
    private $fields = [];
    private $tableManipulator;
    private $secureSQLGenerator;
    private $pdo;
    private $tableName;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
        $this->createNeededInstances(); 
    }

    private function createNeededInstances() {
        if(!$this->secureSQLGenerator) 
            $this->secureSQLGenerator = new SecureSQLGenerator($this->pdo);
    }

    /**
 * Create a new table for contact us form submissions.
 *
 * @return bool True if the table is successfully created, false otherwise.
 */
public function createContactUsTable(): bool {
    return $this->secureSQLGenerator
        ->setQuery(
            (new TableManipulator('contact-us'))
                ->ifNotExists()
                ->addFields([
                    (new FieldDefinition("id"))->integer()->unsigned()->autoIncrement()->primaryKey()->comment("Unique Auto-generated id for users"),
                    (new FieldDefinition("name"))->varchar()->length(100)->notNull()->comment("Full name"),
                    (new FieldDefinition("email"))->email()->notNull()->unique()->comment("user email address"),
                    (new FieldDefinition("message"))->text()->length(5000)->notNull()->unique()->comment("Contact Message"),
                    (new FieldDefinition("phone"))->varchar()->length(15)->comment("phone number"),
                    (new FieldDefinition("status"))->tinyInt()->length(2)->notNull()->default(0)->comment("Account Status: 0 -> inactive, 1 -> Active"),
                    (new FieldDefinition("date_submitted"))->utcDatetime()->currentTimestamp()->comment("Account Creation date"),
                    (new FieldDefinition("date_read"))->utcDatetime()->comment("Last Update Date date"),
                ])
                ->getCreateTableStatement()
        )->execute();
}

    public function createUsersTable() {
        return $this->secureSQLGenerator
            ->setQuery(
                (new TableManipulator('users'))
                ->ifNotExists()
                ->addFields([
                    (new FieldDefinition("id"))->integer()->unsigned()->autoIncrement()->primaryKey()->comment("Unique Auto-generated id for users"),
                    (new FieldDefinition("first_name"))->varchar()->length(20)->notNull()->comment("user first name"),
                    (new FieldDefinition("last_name"))->varchar()->length(20)->notNull()->comment("user last name"),
                    (new FieldDefinition("username"))->varchar()->length(20)->notNull()->comment("user last name"),
                    (new FieldDefinition("email"))->email()->notNull()->unique()->comment("user email address"),
                    (new FieldDefinition("phone"))->varchar()->length(15)->comment("user phone address"),
                    (new FieldDefinition("password"))->varchar()->length(255)->notNull()->comment("user email address"),
                    (new FieldDefinition("role"))->tinyInt()->length(1)->notNull()->default(0)->comment("Account Status: 0 -> Admin, 1 -> Admin Asistant"),
                    (new FieldDefinition("status"))->tinyInt()->length(2)->notNull()->default(0)->comment("Account Status: 0 -> inactive, 1 -> Active"),
                    (new FieldDefinition("date_created"))->utcDatetime()->currentTimestamp()->comment("Account Creation date"),
                    (new FieldDefinition("date_updated"))->utcDatetime()->comment("Last Update Date date")
                ])
                ->getCreateTableStatement()
            )->execute();
    }

    // public function createUserTable() {
    //     return $this->secureSQLGenerator
    //         ->setQuery(
    //             (new TableManipulator('users'))
    //             ->ifNotExists()
    //             ->addFields([
    //                 (new FieldDefinition("id"))->integer()->unsigned()->autoIncrement()->primaryKey()->comment("Unique Auto-generated id for users"),
    //                 (new FieldDefinition("first_name"))->varchar()->length(20)->notNull()->comment("user first name"),
    //                 (new FieldDefinition("last_name"))->varchar()->length(20)->notNull()->comment("user last name"),
    //                 (new FieldDefinition("username"))->varchar()->length(20)->notNull()->comment("user last name"),
    //                 (new FieldDefinition("email"))->email()->notNull()->unique()->comment("user email address"),
    //                 (new FieldDefinition("phone"))->varchar()->length(15)->comment("user phone address"),
    //                 (new FieldDefinition("password"))->varchar()->length(255)->notNull()->comment("user email address"),
    //                 (new FieldDefinition("status"))->tinyInt()->length(2)->notNull()->default(0)->comment("Account Status: 0 -> inactive, 1 -> Active"),
    //                 (new FieldDefinition("date_created"))->utcDatetime()->currentTimestamp()->comment("Account Creation date"),
    //                 (new FieldDefinition("date_updated"))->utcDatetime()->comment("Last Update Date date"),
    //                 (new FieldDefinition("purchased_a_plan"))->tinyInt()->length(1)->notNull()->default(0)->comment("user plan status"),
    //                 (new FieldDefinition("date_of_last_plan"))->utcDatetime()->comment("date of last plan purchase"),
    //                 (new FieldDefinition("active_package"))->varchar()->length(50)->comment("name of active plan"),
    //                 (new FieldDefinition("concent"))->tinyInt()->length(2)->comment("service concent"),
    //             ])
    //             ->getCreateTableStatement()
    //         )->execute();
    // }

    public function getUser($uniqueKey) {
        $user = $this->secureSQLGenerator->select()
                ->from("users")->where(["id" => $uniqueKey])
                ->orWhere(['email' => $uniqueKey])
                ->orWhere(['phone' => $uniqueKey])->execute();
    }

    // public function getUsers($uniqueKey) {
    //     $user = $this->secureSQLGenerator->select()
    //             ->from("users")->where("id = ". $uniqueKey)
    //             ->orWhere('email = '. $uniqueKey)
    //             ->orWhere('phone = '. $uniqueKey)->execute();
    // }

    public function createUser(array $data) {
        return $this->secureSQLGenerator->insert('users', $data)->execute();
    }

    public function setup(array $data) {
        $this->createContactUsTable();
        $this->createUsersTable();
    }
}