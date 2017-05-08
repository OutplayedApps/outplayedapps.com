<?php
    /**
    * Template Name: Tycho Api
    */

class Country {
    public $id;
    public $name;
}

class CountryRepository {
   /* protected $db;
    public function __construct(PDO $db) {
        $this->db = $db;
    }
    private function read($row) {
        $result = new Country();
        $result->id = $row["id"];
        $result->name = $row["name"];
        return $result;
    }
    public function getAll() {
        $sql = "SELECT * FROM countries";
        $q = $this->db->prepare($sql);
        $q->execute();
        $rows = $q->fetchAll();
        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }*/
}
function add_get_var_to_query($query, $var) { //adds on a "WHERE" statement to the query.
            if(isset($_GET[$var]))
        {
            $query .= " and ".$var."=".$_GET[$var];
        }
        return $query;
}

function query() {
//$myPDO = new PDO('mysql:host=localhost;dbname=tycho', 'ashwin', 'AbhinavBrahe$2');
//$result = $myPDO->query("SELECT * FROM cats");
$mysqli = new mysqli("localhost", "tycho", "AbhinavBrahe$2", "tycho");

switch ($_GET["query"]) {
    case "cats":
        $query = "select catName, catId from cats where True";
        break;
    case "subcats":
//        $query = "select * from subcats left join guides  where True";
$query = "";
$extra = "where True";
$extra .= add_get_var_to_query("", "catId");
$query1 = "SELECT * FROM subcats {$extra}";
$query2 = "SELECT * FROM guides {$extra}";
$query = "{$query1};{$query2}";
        
        break;
    case "guides": #?query=guides&subcatId=1
        $query = "select * from guides where True";
        $query = add_get_var_to_query($query, "subcatId");
	$query = add_get_var_to_query($query, "catId");
        break;
    default:
        $query="";
}

$result = $mysqli->multi_query($query);

$myArray = array();
 do {
    if ($mysqli->more_results())
            $mysqli->next_result();
    if ($result = $mysqli->store_result()) {
        while ($row = $result->fetch_assoc()) {
            array_push($myArray, $row);
        }
        $result->close();
    }

}  while ($mysqli->more_results());

$mysqli->close();

return $myArray;

}

switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $result = query();
        break;
}
header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');

echo json_encode($result);
    
//$result->close();


?>