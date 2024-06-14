<?php

class Person
{
    public $id_people;
    public $name;
    public $surname;
    public $date_of_birth;
    public $gender;
    public $place_of_birth;

    public function __construct($id_people = null)
    {
        if ($id_people) {
            $this->id_people = $id_people;
            $this->fetchPersonFromDatabase($id_people);
        } else {
            $this->save();
        }
    }
    private function fetchPersonFromDatabase($id_people)
    {
        $db = new Database();
        $conn = $db->getConnection();
        $query = "SELECT * FROM people WHERE id_people = $id_people";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->date_of_birth = $row['date_of_birth'];
            $this->gender = $row['gender'];
            $this->place_of_birth = $row['place_of_birth'];
        } else {
            echo "No person found with id_people: $id_people";
        }

        $conn->close();
    }


    public function save()
    {
        if (!$this->validate()) {
            echo "Invalid person data. Please check the provided information.";
            return;
        }

        $db = new Database();
        $conn = $db->getConnection();
        $query = "INSERT INTO people (name, surname, date_of_birth, gender, place_of_birth) VALUES ('$this->name', '$this->surname', '$this->date_of_birth', '$this->gender', '$this->place_of_birth')";
        $result = $conn->query($query);

        if ($result === true) {
            $this->id_people = $conn->insert_id;
            echo "Person saved successfully with id_people: $this->id_people";
        } else {
            echo "Error saving person: " . $conn->error;
        }

        $conn->close();
    }

    public function delete()
    {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "DELETE FROM people WHERE id_people = $this->id_people";
        $result = $conn->query($query);

        if ($result === true) {
            echo "Person deleted successfully";
        } else {
            echo "Error deleting person: " . $conn->error;
        }

        $conn->close();
    }

    public static function calculateAge($date_of_birth)
    {
        $today = new DateTime();
        $diff = $today->diff(new DateTime($date_of_birth));
        return $diff->y;
    }

    public static function convertGender($gender)
    {
        if ($gender === true) {
            return "муж";
        } elseif ($gender === false) {
            return "жен";
        }
        return "";
    }

    public function formatPerson($calculateAge = false, $convertGender = false)
    {
        $formattedPerson = new stdClass();
        $formattedPerson->id_people = $this->id_people;
        $formattedPerson->name = $this->name;
        $formattedPerson->surname = $this->surname;
        $formattedPerson->date_of_birth = $this->date_of_birth;
        $formattedPerson->gender = $this->gender;
        $formattedPerson->place_of_birth = $this->place_of_birth;

        if ($calculateAge) {
            $formattedPerson->age = self::calculateAge($this->date_of_birth);
        }

        if ($convertGender) {
            $formattedPerson->gender = self::convertGender($this->gender);
        }

        return $formattedPerson;
    }
    private function validate()
    {
        if (empty($this->name) || empty($this->surname) || empty($this->date_of_birth) || $this->gender === null || empty($this->place_of_birth)) {
            return false;
        }

        return true;
    }
}


?>