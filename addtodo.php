<?php

$message = "";
 
if (isset($_POST['submit'])) {
                    $myTodo = $_POST['title'];
 
                    if(!empty($myTodo)) {
                                       $message = "Your task has been added. There is no perfect moment, just do it.";
                    }if(empty($myTodo)) {
                                       $message = "";
                    } else {
                    $statement = $pdo->prepare("INSERT INTO todo (title) VALUES ('$myTodo')");
                    $statement ->execute();
 
                    //header('location: index.php');
}
}
 
/*Så här går den ifsats:
Isset är en funktion som kollar om en variabel är lagrad med ett värde. Not set to null. Och då ska ifsatsen köras. Isset körs för att variabeln $myTodo har ett värde. Denna värde är $_POST['title']. Där $_POST är kopplat till inputfältet i html (form method=POST) och 'title' är name="title" i input html taggen. I 'title' (name) lagras det du skriver i inputfältet.
 
Så $myTodo (variabel) = $_POST['title'] (value/värde); menar att variabeln är vad du än skriver. Det kommer alltså ha ett nytt värde varje gång du skriver något i inpultfältet.
 
Så, OM $_POST['submit'] där submit är namnet i button (name='submit') är klickat (tack vare 'type=submit' man kan klicka på rutan då tack vare det) så ska det du skriver ($myTodo = $_POST['title'];) skickas till mySQL databasen  "else {
                    $statement = $pdo->prepare("INSERT INTO todo (title) VALUES ('$myTodo')");
                    $statement ->execute();".
 
                    Men först kollar den innan den når ELSE om fältet är fylld eller inte fylld för att kunna skriva ut ett meddelande. Sedan när den är fylld så utförst ELSE statment och skickar det du skriver till databasen.
 
                    det är $pdo->prepare("INSERT INTO todo (title) VALUES ('$myTodo')"); som gör att den faktiskt skickas och då lagras och sparas i databasen. Men varför?
                    Jo, variabeln $pdo är lagrad med ett värde redan (i phpfilen "database.php" finns den mer utförd. Den är lagrad med den faktiska KOPPLINGEN till databasen MySQL och din mapp Task där Todo undermappen finns och där finns följande columner - id, title, completed och createdBy).
                   
                    prepare - är det som gör att man kan göra följande ändringar i databasen, i det här fallet var det INSERT INTO. och execute(); är det som utför det. INSET INTO lägger till i databsen.
 
                    Alltid med prepare måste man göra en execute.
 
                    All det här är då lagra i en variabel också - bara för att det ser tydligare och kanske mer strukturerad, logisk. Men man behöver inte lagra den i någon variabel du kan lika gärna skippa i det här fallet $statement och bara skriva $pdo->prepare etc */
 
 
/*all the todos listed
 
Här sker hämtningen av det som finns i databasen. Denna utförande görs för att i html så finns en foreach loop som hämtar allt som finns i en array. Array i just det här fallet är då alla rader i databasen. För kom ihåg att ARRAY kan lagrar flera objekt. I html går foreach loopen såhär:
<?php foreach ($mytodolist as $task) {
                    ?>
 
                    där $mytodolist är alla columnerna i databasen för att här nere så har $mytodolist ett värde av  "$todos -> fetchALL(PDO::FETCH_ASSOC);"
 
                    Det är det jag menar -> ($mytodolist = $todos -> fetchALL(PDO::FETCH_ASSOC);)
 
                    I foreach loopen så säger vi till den att loopa dig igenom alla ($mytodolist) men hämta en åt gången (as $task). Varje 'hämtning', varje $task då, printas ut i (titta i html).
 
                    Kolla på utförande här nedan och efter den finns en förklaring.
*/
 
$todos = $pdo->prepare("SELECT * FROM todo WHERE completed = 0");
$todos ->execute();
$mytodolist = $todos -> fetchALL(PDO::FETCH_ASSOC);
 
 
/*
 
                    Så, $todos = $pdo->prepare("SELECT * FROM todo WHERE completed = 0");
$todos ->execute();
$mytodolist = $todos -> fetchALL(PDO::FETCH_ASSOC); 
 
säger följande:
 
$pdo->prepare etc säger hämta (SELECT) allt (*) från todo (din lista) där (WHERE) completed (som finns i din lista, och är en boolean alltså true or false) och false (0). Det vill säga att de som inte är 'checkade' printas ut på den första listan. För att det skriver du in i html där det står "<p><?= $task['title']; ?></p>"
 
--> $task['title'] säger hämta varje text under columnen title.
 
 */
 
 
 
 
/* delete button*/
/*Denna utförande har att göra med DELETE knappen. Förklaring sker nedan*/
if(isset($_GET['delete_task'])) {
                                       $id = $_GET['delete_task'];
                                       $delete = $pdo->prepare("DELETE FROM todo WHERE id = :id");
                                       $delete->execute(array(":id" => $id ));
                                       header('location: index.php');
}
 
 
/*
Isset är som sagt en funktion som säger utför om en variabel är fylld med ett värde. Så alltså IF ISSET $_GET där variabeln $id är fylld , utför då $get ['delete_task']. 'delete_task' är alltså länken till GET methoden och finns i en a href , alltså också en länk alltså när du KLICKAR så utförs då en GET method. (kika html där delete knappen är).
 
Men nu kollar vi vidare på denna ifsats. Den säger:
 
Om delete knappen är klickad (som är en GET method och därför hämtar vi den med $_GET['delete_task']. Den heter delete_task i html) så ska följande ske i databasen --> $pdo->prepare("DELETE FROM todo WHERE id = :id");
                                       $delete->execute(array(":id" => $id ));
 
                                       I databasen sker följande --> DELETE (ta bort) FROM (från) todo (din lista, din sql lista i databasen) där id = :id (alltså id i databasen är lika med ":id" som är samma ":id" som skrivs inuti execute) Execute säger 'att :id är samma sak som $id (där $id är $_GET['delete_task']
 
                                       ALLTSÅ den som blir bortagen på din hemsida. I databasen har ju alla ett unikt id nummer, och därför används den i det här utförande för att if satsen ska veta att det är den du klickar på att ta bort som ska vara samma i databasen när du i databasen med hjälp av DELETE FROM ... WHERE id. Alltså hela id numret ska försvina och all dess innehåll, där av samma innehåll som den du klickade bort i din sida för det innehållet lagrades i den här ifsatsten med hjälp av en variabel ($id) som var kopplad till ":id."
*/
 
 
/*mark done button
 
Det här är ifsatsen till din check knapp. Den påminner om förgående knapp, deleteknappen,i sitt utförande. Precis samma process förutom att här säger vi till databasen att UPDATE. Alltså uppdatera det som kicklas på i checkknappen till true (complete = 1). */
if(isset($_GET['check_task'])) {
                    $id = $_GET['check_task'];
                    $complete = $pdo-> prepare("UPDATE todo SET completed = 1 WHERE id = :id");
                    $complete->execute(array(":id" => $id ));
                    header('location: index.php');
}
 
/*completed list
 
Här sker hämtningen av alla TRUES (complete = 1) från databasen. För att sedan kunna skickas till DONELISTAN i din html när du klickar på CHECK i din html. Denna utförande är kopplad till FOREACH loopen i din html där DONELISTAN är. Och fungerar precis på samma sätt som den FOREACH LOOPEN jag förklarade högre upp (den som printade ut det du skrev i inputfältet till din hemsida.
 
*/
$completed = $pdo->prepare("SELECT * FROM todo WHERE completed = 1");
$completed ->execute();
$list_already_done = $completed -> fetchALL(PDO::FETCH_ASSOC);
 
?>