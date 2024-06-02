<?php

namespace API;

use FASTSQL\SecureSQLGenerator;
use FASTSQL\FieldDefinition;
use FASTSQL\TableManipulator;

class Models
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
     * @return bool True if the table is successfully created, false otherwise.
     */

    public function createContactUsTable(): bool
    {
        return 
        // $this->secureSQLGenerator
        //     ->setQuery(
                (new TableManipulator('contact-us'))
                    ->ifNotExists()
                    ->addFields([
                        (new FieldDefinition("id"))->integer()->unsigned()->autoIncrement()->primaryKey()->comment("Unique Auto-generated id for users"),
                        (new FieldDefinition("name"))->varchar()->length(100)->notNull()->comment("Full name"),
                        (new FieldDefinition("email"))->email()->notNull()->unique()->comment("user email address"),
                        (new FieldDefinition("message"))->text()->length(5000)->notNull()->comment("Contact Message"),
                        (new FieldDefinition("phone"))->varchar()->length(15)->comment("phone number"),
                        (new FieldDefinition("status"))->tinyInt()->length(2)->notNull()->default(0)->comment("Account Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("date_submitted"))->utcDatetime()->currentTimestamp()->comment("Account Creation date"),
                        (new FieldDefinition("date_read"))->utcDatetime()->comment("Last Update Date date"),
                    ])
                    ->getCreateTableStatement();
            // )->execute();
    }

    public function createHAJTable(): bool
    {
        return 
        // $this->secureSQLGenerator
        //     ->setQuery(
                (new TableManipulator('hajRegistration'))
                    ->ifNotExists()
                    ->addFields([
                        // Student information
                        (new FieldDefinition("id"))->integer()->unsigned()->autoIncrement()->primaryKey()->comment("Unique Auto-generated id for users"),
                        (new FieldDefinition("firstName"))->varchar()->length(100)->notNull()->comment("Student Full name"),
                        (new FieldDefinition("middleName"))->varchar()->length(50)->comment("Student Middle name"),
                        (new FieldDefinition("lastName"))->varchar()->length(50)->notNull()->comment("student Surname"),
                        (new FieldDefinition("dateOfBirth"))->varchar()->length(15)->notNull()->comment("Student Date of Birth"),
                        (new FieldDefinition("gender"))->varchar()->length(15)->notNull()->comment("student gender"),
                        (new FieldDefinition("religion"))->varchar()->length(15)->comment("Account Creation date"),
                        (new FieldDefinition("nationality"))->varchar()->length(50)->comment("nationality"),
                        (new FieldDefinition("lastSchool"))->varchar()->length(100)->comment("last school"),
                        (new FieldDefinition("lastClass"))->varchar()->length(10)->comment("last class"),
                        (new FieldDefinition("healthCondition"))->text()->length(500)->notNull()->comment("Health condition"),
                        (new FieldDefinition("stateOfOrigin"))->varchar()->length(25)->notNull()->comment("state of origin"),
                        (new FieldDefinition("placeOfBirth"))->varchar()->length(25)->notNull()->comment("place of birth"),
                        (new FieldDefinition("lga"))->varchar()->length(50)->notNull()->comment("lga/city"),
                        // Guadian Information
                        (new FieldDefinition("guardianName"))->varchar()->length(100)->notNull()->comment("guradian Full name"),
                        (new FieldDefinition("guardianCurrentAddress"))->varchar()->length(500)->comment("Guradian current address"),
                        (new FieldDefinition("guardianPermanentAddress"))->varchar()->length(500)->comment("Guradian permanent address"),
                        (new FieldDefinition("guardianPhoneNumber"))->varchar()->length(15)->comment("guradian phone number"),
                        // Medical Information
                        (new FieldDefinition("asthmaStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("asthmat Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("eyeStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("eye Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("earStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("ear Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("noseBleadingStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("nose bleeding Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("hasLearningDifficulties"))->tinyInt()->length(2)->notNull()->default(0)->comment("has Learning Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("allergies"))->varchar()->length(500)->notNull()->default('')->comment("allergies"),
                        (new FieldDefinition("smallPox"))->tinyInt()->length(2)->notNull()->default(0)->comment("smallPox Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("whoopingCough"))->tinyInt()->length(2)->notNull()->default(0)->comment("whoopingCough Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("polio"))->tinyInt()->length(2)->notNull()->default(0)->comment("polio Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("tetanus"))->tinyInt()->length(2)->notNull()->default(0)->comment("tetanus Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("tuberculosis"))->tinyInt()->length(2)->notNull()->default(0)->comment("tuberculosis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("mumps"))->tinyInt()->length(2)->notNull()->default(0)->comment("mumps Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("meningitis"))->tinyInt()->length(2)->notNull()->default(0)->comment("meningitis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("hepatitis"))->tinyInt()->length(2)->notNull()->default(0)->comment("hepatitis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("rubella"))->tinyInt()->length(2)->notNull()->default(0)->comment("rubella Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("haveMedicalConditions"))->tinyInt()->length(2)->notNull()->default(0)->comment("other medical Condition Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("medicalConditions"))->tinyInt()->length(2)->notNull()->default(0)->comment("Account Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("havePersonalDoctor"))->tinyInt()->length(2)->notNull()->default(0)->comment("have a private doctor Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("doctorName"))->varchar()->length(100)->comment("doctor Full name"),
                        (new FieldDefinition("doctorAddress"))->varchar()->length(500)->comment("doctor current address"),
                        (new FieldDefinition("doctorPhoneNumber"))->varchar()->length(15)->comment("doctor phone number"),
                    ])
                    ->getCreateTableStatement();
            // )->execute();
    }

    public function createHMJTable(): bool
    {
        return 
        // $this->secureSQLGenerator
            // ->setQuery(
                (new TableManipulator('hmjRegistration'))
                    ->ifNotExists()
                    ->addFields([
                        // Student information
                        (new FieldDefinition("id"))->integer()->unsigned()->autoIncrement()->primaryKey()->comment("Unique Auto-generated id for users"),
                        (new FieldDefinition("firstName"))->varchar()->length(100)->notNull()->comment("Student Full name"),
                        (new FieldDefinition("middleName"))->varchar()->length(50)->comment("Student Middle name"),
                        (new FieldDefinition("lastName"))->varchar()->length(50)->notNull()->comment("student Surname"),
                        (new FieldDefinition("dateOfBirth"))->varchar()->length(15)->notNull()->comment("Student Date of Birth"),
                        (new FieldDefinition("gender"))->varchar()->length(15)->notNull()->comment("student gender"),
                        (new FieldDefinition("religion"))->varchar()->length(15)->comment("Account Creation date"),
                        (new FieldDefinition("nationality"))->varchar()->length(50)->comment("nationality"),
                        (new FieldDefinition("lastSchool"))->varchar()->length(100)->comment("last school"),
                        (new FieldDefinition("lastClass"))->varchar()->length(10)->comment("last class"),
                        (new FieldDefinition("healthCondition"))->text()->length(500)->notNull()->comment("Health condition"),
                        (new FieldDefinition("stateOfOrigin"))->varchar()->length(25)->notNull()->comment("state of origin"),
                        (new FieldDefinition("placeOfBirth"))->varchar()->length(25)->notNull()->comment("place of birth"),
                        (new FieldDefinition("lga"))->varchar()->length(50)->notNull()->comment("lga/city"),
                        // Guadian Information
                        (new FieldDefinition("guardianName"))->varchar()->length(100)->notNull()->comment("guradian Full name"),
                        (new FieldDefinition("guardianCurrentAddress"))->varchar()->length(500)->comment("Guradian current address"),
                        (new FieldDefinition("guardianPermanentAddress"))->varchar()->length(500)->comment("Guradian permanent address"),
                        (new FieldDefinition("guardianPhoneNumber"))->varchar()->length(15)->comment("guradian phone number"),
                        // Medical Information
                        (new FieldDefinition("asthmaStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("asthmat Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("eyeStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("eye Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("earStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("ear Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("noseBleadingStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("nose bleeding Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("hasLearningDifficulties"))->tinyInt()->length(2)->notNull()->default(0)->comment("has Learning Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("allergies"))->varchar()->length(500)->notNull()->default('')->comment("allergies"),
                        (new FieldDefinition("smallPox"))->tinyInt()->length(2)->notNull()->default(0)->comment("smallPox Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("whoopingCough"))->tinyInt()->length(2)->notNull()->default(0)->comment("whoopingCough Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("polio"))->tinyInt()->length(2)->notNull()->default(0)->comment("polio Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("tetanus"))->tinyInt()->length(2)->notNull()->default(0)->comment("tetanus Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("tuberculosis"))->tinyInt()->length(2)->notNull()->default(0)->comment("tuberculosis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("mumps"))->tinyInt()->length(2)->notNull()->default(0)->comment("mumps Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("meningitis"))->tinyInt()->length(2)->notNull()->default(0)->comment("meningitis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("hepatitis"))->tinyInt()->length(2)->notNull()->default(0)->comment("hepatitis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("rubella"))->tinyInt()->length(2)->notNull()->default(0)->comment("rubella Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("haveMedicalConditions"))->tinyInt()->length(2)->notNull()->default(0)->comment("other medical Condition Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("medicalConditions"))->tinyInt()->length(2)->notNull()->default(0)->comment("Account Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("havePersonalDoctor"))->tinyInt()->length(2)->notNull()->default(0)->comment("have a private doctor Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("doctorName"))->varchar()->length(100)->comment("doctor Full name"),
                        (new FieldDefinition("doctorAddress"))->varchar()->length(500)->comment("doctor current address"),
                        (new FieldDefinition("doctorPhoneNumber"))->varchar()->length(15)->comment("doctor phone number"),
                        
                    ])
                    ->getCreateTableStatement();
            // )->execute();
    }

    public function createHHSTable(): bool
    {
        return 
        // $this->secureSQLGenerator
        //     ->setQuery(
                (new TableManipulator('hhsRegistration'))
                    ->ifNotExists()
                    ->addFields([
                        // Student information
                        (new FieldDefinition("id"))->integer()->unsigned()->autoIncrement()->primaryKey()->comment("Unique Auto-generated id for users"),
                        (new FieldDefinition("firstName"))->varchar()->length(100)->notNull()->comment("Student Full name"),
                        (new FieldDefinition("middleName"))->varchar()->length(50)->comment("Student Middle name"),
                        (new FieldDefinition("lastName"))->varchar()->length(50)->notNull()->comment("student Surname"),
                        (new FieldDefinition("dateOfBirth"))->varchar()->length(15)->notNull()->comment("Student Date of Birth"),
                        (new FieldDefinition("gender"))->varchar()->length(15)->notNull()->comment("student gender"),
                        (new FieldDefinition("religion"))->varchar()->length(15)->comment("Account Creation date"),
                        (new FieldDefinition("nationality"))->varchar()->length(50)->comment("nationality"),
                        (new FieldDefinition("lastSchool"))->varchar()->length(100)->comment("last school"),
                        (new FieldDefinition("lastClass"))->varchar()->length(10)->comment("last class"),
                        (new FieldDefinition("healthCondition"))->text()->length(500)->notNull()->comment("Health condition"),
                        (new FieldDefinition("stateOfOrigin"))->varchar()->length(25)->notNull()->comment("state of origin"),
                        (new FieldDefinition("placeOfBirth"))->varchar()->length(25)->notNull()->comment("place of birth"),
                        (new FieldDefinition("lga"))->varchar()->length(50)->notNull()->comment("lga/city"),
                        // Guadian Information
                        (new FieldDefinition("guardianName"))->varchar()->length(100)->notNull()->comment("guradian Full name"),
                        (new FieldDefinition("guardianCurrentAddress"))->varchar()->length(500)->comment("Guradian current address"),
                        (new FieldDefinition("guardianPermanentAddress"))->varchar()->length(500)->comment("Guradian permanent address"),
                        (new FieldDefinition("guardianPhoneNumber"))->varchar()->length(15)->comment("guradian phone number"),
                        // Medical Information
                        (new FieldDefinition("asthmaStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("asthmat Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("eyeStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("eye Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("earStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("ear Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("noseBleadingStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("nose bleeding Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("hasLearningDifficulties"))->tinyInt()->length(2)->notNull()->default(0)->comment("has Learning Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("allergies"))->varchar()->length(500)->notNull()->default('')->comment("allergies"),
                        (new FieldDefinition("smallPox"))->tinyInt()->length(2)->notNull()->default(0)->comment("smallPox Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("whoopingCough"))->tinyInt()->length(2)->notNull()->default(0)->comment("whoopingCough Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("polio"))->tinyInt()->length(2)->notNull()->default(0)->comment("polio Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("tetanus"))->tinyInt()->length(2)->notNull()->default(0)->comment("tetanus Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("tuberculosis"))->tinyInt()->length(2)->notNull()->default(0)->comment("tuberculosis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("mumps"))->tinyInt()->length(2)->notNull()->default(0)->comment("mumps Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("meningitis"))->tinyInt()->length(2)->notNull()->default(0)->comment("meningitis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("hepatitis"))->tinyInt()->length(2)->notNull()->default(0)->comment("hepatitis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("rubella"))->tinyInt()->length(2)->notNull()->default(0)->comment("rubella Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("haveMedicalConditions"))->tinyInt()->length(2)->notNull()->default(0)->comment("other medical Condition Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("medicalConditions"))->tinyInt()->length(2)->notNull()->default(0)->comment("Account Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("havePersonalDoctor"))->tinyInt()->length(2)->notNull()->default(0)->comment("have a private doctor Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("doctorName"))->varchar()->length(100)->comment("doctor Full name"),
                        (new FieldDefinition("doctorAddress"))->varchar()->length(500)->comment("doctor current address"),
                        (new FieldDefinition("doctorPhoneNumber"))->varchar()->length(15)->comment("doctor phone number"),
                        
                    ])
                    ->getCreateTableStatement();
            // )->execute();
    }

    public function createHMCTable(): bool
    {
        return 
        // $this->secureSQLGenerator
        //     ->setQuery(
                (new TableManipulator('hmcRegistration'))
                    ->ifNotExists()
                    ->addFields([
                        // Student information
                        (new FieldDefinition("id"))->integer()->unsigned()->autoIncrement()->primaryKey()->comment("Unique Auto-generated id for users"),
                        (new FieldDefinition("firstName"))->varchar()->length(100)->notNull()->comment("Student Full name"),
                        (new FieldDefinition("middleName"))->varchar()->length(50)->comment("Student Middle name"),
                        (new FieldDefinition("lastName"))->varchar()->length(50)->notNull()->comment("student Surname"),
                        (new FieldDefinition("dateOfBirth"))->varchar()->length(15)->notNull()->comment("Student Date of Birth"),
                        (new FieldDefinition("gender"))->varchar()->length(15)->notNull()->comment("student gender"),
                        (new FieldDefinition("religion"))->varchar()->length(15)->comment("Account Creation date"),
                        (new FieldDefinition("nationality"))->varchar()->length(50)->comment("nationality"),
                        (new FieldDefinition("lastSchool"))->varchar()->length(100)->comment("last school"),
                        (new FieldDefinition("lastClass"))->varchar()->length(10)->comment("last class"),
                        (new FieldDefinition("healthCondition"))->text()->length(500)->notNull()->comment("Health condition"),
                        (new FieldDefinition("stateOfOrigin"))->varchar()->length(25)->notNull()->comment("state of origin"),
                        (new FieldDefinition("placeOfBirth"))->varchar()->length(25)->notNull()->comment("place of birth"),
                        (new FieldDefinition("lga"))->varchar()->length(50)->notNull()->comment("lga/city"),
                        // Guadian Information
                        (new FieldDefinition("guardianName"))->varchar()->length(100)->notNull()->comment("guradian Full name"),
                        (new FieldDefinition("guardianCurrentAddress"))->varchar()->length(500)->comment("Guradian current address"),
                        (new FieldDefinition("guardianPermanentAddress"))->varchar()->length(500)->comment("Guradian permanent address"),
                        (new FieldDefinition("guardianPhoneNumber"))->varchar()->length(15)->comment("guradian phone number"),
                        // Medical Information
                        (new FieldDefinition("asthmaStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("asthmat Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("eyeStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("eye Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("earStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("ear Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("noseBleadingStatus"))->tinyInt()->length(2)->notNull()->default(0)->comment("nose bleeding Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("hasLearningDifficulties"))->tinyInt()->length(2)->notNull()->default(0)->comment("has Learning Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("allergies"))->varchar()->length(500)->notNull()->default('')->comment("allergies"),
                        (new FieldDefinition("smallPox"))->tinyInt()->length(2)->notNull()->default(0)->comment("smallPox Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("whoopingCough"))->tinyInt()->length(2)->notNull()->default(0)->comment("whoopingCough Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("polio"))->tinyInt()->length(2)->notNull()->default(0)->comment("polio Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("tetanus"))->tinyInt()->length(2)->notNull()->default(0)->comment("tetanus Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("tuberculosis"))->tinyInt()->length(2)->notNull()->default(0)->comment("tuberculosis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("mumps"))->tinyInt()->length(2)->notNull()->default(0)->comment("mumps Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("meningitis"))->tinyInt()->length(2)->notNull()->default(0)->comment("meningitis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("hepatitis"))->tinyInt()->length(2)->notNull()->default(0)->comment("hepatitis Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("rubella"))->tinyInt()->length(2)->notNull()->default(0)->comment("rubella Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("haveMedicalConditions"))->tinyInt()->length(2)->notNull()->default(0)->comment("other medical Condition Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("medicalConditions"))->tinyInt()->length(2)->notNull()->default(0)->comment("Account Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("havePersonalDoctor"))->tinyInt()->length(2)->notNull()->default(0)->comment("have a private doctor Status: 0 -> inactive, 1 -> Active"),
                        (new FieldDefinition("doctorName"))->varchar()->length(100)->comment("doctor Full name"),
                        (new FieldDefinition("doctorAddress"))->varchar()->length(500)->comment("doctor current address"),
                        (new FieldDefinition("doctorPhoneNumber"))->varchar()->length(15)->comment("doctor phone number"),
                        
                    ])
                    ->getCreateTableStatement();
            // )->execute();
    }

    public function insertContactUsForm($data)
    {
        return $this->secureSQLGenerator->insert('contact-us', $data)->execute();
    }


    /**
     * This method is used to setup the necessary database tables for the landing page.
     * @return array An array containing the result of the createContactUsTable method.
     * @throws \Exception If any error occurs during the database operations.
     * @since 1.0.0
     */

    public function setup()
    {
        return [
            'contactus'=> $this->createContactUsTable(),
            'hmcReg'=> $this->createHMCTable(),
            'hmjReg'=> $this->createHMJTable(),
            'hhsReg'=> $this->createHHSTable(),
            'hajReg'=> $this->createHAJTable()
        ];
    }
}
