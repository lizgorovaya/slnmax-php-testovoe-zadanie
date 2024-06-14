<?php

class PeopleList
{
    private $peopleIds;
    private $db;

    public function __construct($filters = [])
    {
        if (!class_exists('Person')) {
            echo "Error: class Person missing.";
            return;
        }

        $this->db = new Database();
        $this->peopleIds = $this->findPeopleIds($filters);
    }

    public function getPeople()
    {
        $people = [];

        foreach ($this->peopleIds as $personId) {
            $person = new Person($personId, $this->db);
            $people[] = $person;
        }

        return $people;
    }

    public function deletePeople()
    {
        foreach ($this->peopleIds as $personId) {
            $person = new Person($personId, $this->db);
            $person->delete();
        }
    }

    private function findPeopleIds($filters)
    {
        $conn = $this->db->getConnection();

        $query = "SELECT id_people FROM people";
        $result = $conn->query($query);

        $peopleIds = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $peopleIds[] = $row['id_people'];
            }
        }

        $conn->close();

        return $peopleIds;
    }
}
?>