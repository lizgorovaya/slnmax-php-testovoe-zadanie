<?php

require_once 'people.php';
require_once 'peopleList.php';
require_once 'dbconnection.php';



$peopleList = new PeopleList();
$people = $peopleList->getPeople();

foreach ($people as $person) {
    echo $person->name . ' ' . $person->surname . '<br>';
}
?>