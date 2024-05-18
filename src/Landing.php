<?php

namespace API;

use FASTSQL\SecureSQLGenerator;
use FASTSQL\FieldDefinition;
use FASTSQL\TableManipulator;

class Landing
{
    private $secureSQLGenerator;
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->createNeededInstances();
    }

    private function createNeededInstances()
    {
        if (!$this->secureSQLGenerator)
            $this->secureSQLGenerator = new SecureSQLGenerator($this->pdo);
    }

    /**
     * Create a new table for contact us form submissions.
     *
     * @return bool True if the table is successfully created, false otherwise.
     */
    public function createContactUsTable(): bool
    {
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

    public function insertContactUsForm($data){
        return $this->secureSQLGenerator->insert('contact-us', $data)->execute();
    }


    public function setup(array $data)
    {
        return [$this->createContactUsTable()];
    }
}
