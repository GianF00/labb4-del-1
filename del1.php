<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitors</title>

</head>
<body>
    <h1>Gians Gästbok</h1>

    <form method="POST">
        Namn: <br> <input type="text" name="namn" id="namn" required>
                <br>
        Meddelande: <br> <textarea id="meddelande" name="meddelande" rows="4" cols="100" required></textarea>
                <br>
                <input type="submit" name="submit" id="submit" value="Skapa inlägg">

    </form>



    
</body>
</html>



<?php
$fp = fopen("testfile.txt", "a") or die("Unable to open file!");


//funktion för att lägga till ny info
function newValue($obj){
    $a = unserialize(file_get_contents("testfile.txt"));
    $a[] = $obj;
    return serialize($a);
}


//class
class Visitors{
    private $name;
    private $message;
    private $date;
    function __construct($name, $message, $date){
        $this->name = $name;
        $this->message = $message;
        $this->date = $date;
    }

    function get_name(){
        return $this->name;
    }
    function get_message(){
        return $this->message;
    }   
    function get_date(){
        return $this->date;
    }
    function __destruct(){ }

}

echo "<br>";
echo "<h2>Gästboksinlägg</h2>";


//if(!empty($_REQUEST["submit"])){
    if (isset($_POST["namn"]) && isset($_POST["meddelande"])){
        $nm = $_POST["namn"];
        $meddela = $_POST["meddelande"];
        $dt = date("Y-m-d H:i:s");
        
        //ny obj
        $NewVisitors = new Visitors($nm, $meddela, $dt);
        file_put_contents("testfile.txt", newValue($NewVisitors));

    }
//}
    //array
    //$visit = array($NewVisitors);

    //file_put_contents("testfile.txt", newValue($NewVisitors));

    if(file_exists("testfile.txt")){  //controlla e evita di leggere cose che non ci sono quando si apre il fil nel rad 88   
        
        $visit = unserialize(file_get_contents("testfile.txt"));
    }
    else{
        $visit = array();       //se non ce niente si crea un array 
    }

    foreach($visit as $key => $value){
        print_r($value?->get_name() . "<br>" . $value?->get_message());
        //echo "{$value?->name}" . "<br>" . "{$value?->message}";
        
        //print_r('<input type="button" value="radera" onclick="location.href="?delete='.$key.'"">');
        echo "<br>";
        print_r("Publicerad " . $value->get_date());
        print_r('<a href="delete.php?del='.$key.'" onclick="return confirm(\'Är du säker på att du vill radera detta inlägg?\')">Radera inlägg</a>');
        echo "<br>";
        echo "<hr>";
    }




?>