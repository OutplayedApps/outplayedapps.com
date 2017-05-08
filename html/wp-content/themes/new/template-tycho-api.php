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
        $query = "select * from cats where True";
        break;
    case "subcatsonly":      
        $query = "SELECT * FROM subcats where True";
        $query = add_get_var_to_query($query, "catId");
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

$result = getAllResultsInArray($mysqli);
$mysqli->close();
return $result;

}

function getAllResultsInArray($mysqli) {
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

    return $myArray;
}

function performOperation($op) {
    $mysqli = new mysqli("localhost", "tycho", "AbhinavBrahe$2", "tycho");
    $result = $mysqli->multi_query($op);
    //echo $op;
    $result = getAllResultsInArray($mysqli);
    $mysqli->close();
    return $result;
    //return "ok";
}

function getOrElse($i) {
    return isset($_GET[$i]) ? $_GET[$i] : "";
}

    $type = $_GET["query"];

if (isset($_GET["action"])) {

    if ($type == "cats") {
        $catName = getOrElse("catName");
        $catId = getOrElse("catId");
        $selectQueryAdd = "; select * from cats where catId={$catId}";
        //$selectQueryAdd = "";
        $insertQuery = "insert into cats (catName) values ('{$catName}')".$selectQueryAdd;
        $updateQuery = "update cats set catName='{$catName}' where catId={$catId}".$selectQueryAdd;
        $deleteQuery = "delete from cats where catId={$catId}";
        //echo $insertQuery;
    }
    else if ($type == "subcatsonly") {
        $subcatName = getOrElse("subcatName");
        $catId = getOrElse("catId");
        $subcatId = getOrElse("subcatId");
        $selectQueryAdd = "; select * from subcats where subcatId={$subcatId}";
        //$selectQueryAdd = "";
        $insertQuery = "insert into subcats (subcatName, catId) values ('{$subcatName}',{$catId})".$selectQueryAdd;
        $updateQuery = "update subcats set subcatName='{$subcatName}',subcatId={$subcatId} where subcatId={$subcatId}".$selectQueryAdd;
        $deleteQuery = "delete from subcats where subcatId={$subcatId}";
    }
    else if ($type == "guides") {
        $guideName = getOrElse("guideName");
        $googleDocsId = getOrElse("googleDocsId");
        $price = getOrElse("price");
        $guideId = getOrElse("guideId");
        $subcatId = getOrElse("subcatId");
        $catId = getOrElse("catId");
        $selectQueryAdd = "; select * from guides where guideId={$guideId}";
        //$selectQueryAdd = "";
        $insertQuery = "insert into guides (guideName, googleDocsId, price, subcatId, catId) values ('{$guideName}','{$googleDocsId}', {$price}, {$subcatId}, {$catId})".$selectQueryAdd;
        $updateQuery = "update guides set guideName='{$guideName}',googleDocsId='{$googleDocsId}',price={$price},subcatId={$subcatId},catId={$catId} where guideId={$guideId}".$selectQueryAdd;
        $deleteQuery = "delete from guides where guideId={$guideId}";
    }
}
    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
            if (isset($_GET["action"])) {
                $action = $_GET["action"];
                if ($action=="insert") $result = performOperation($insertQuery);
                else if ($action=="update") $result = performOperation($updateQuery);
                else if ($action=="delete") $result = performOperation($deleteQuery);
                if (isset($result[0])) {
                    $result = $result[0];
                }
            }
            else {
                $result = query();
            }
            break;

}
header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');

echo json_encode($result);
    
//$result->close();


?>