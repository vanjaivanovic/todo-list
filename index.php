
 <?php
$pdo = new PDO(
"mysql:host=localhost;dbname=tasks;chartset=utf8",
"root",
"root"
);
 
$add_task = "";
 
if (isset($_POST['submit'])) {
    $title = $_POST['title'];

    if(!empty($title)) {
                       $add_task = "Your task has been added. Do not wait for the perfect moment, just do it!";
    }if(empty($title)) {
                       $add_task = "You must fill in the task.";
    } else {
    $statement = $pdo->prepare("INSERT INTO todo (title) VALUES ('$title')");
    $statement ->execute();

    //header('location: index.php');
}
}
 
$tasks = $pdo->prepare("SELECT * FROM todo WHERE completed = 0 ORDER BY title DESC");
$tasks ->execute();
$todolist = $tasks -> fetchALL(PDO::FETCH_ASSOC);
 
if(isset($_GET['delete_task'])) {
   $id = $_GET['delete_task'];
   $delete = $pdo->prepare("DELETE FROM todo WHERE id = :id");
   $delete->execute(array(":id" => $id ));
   header('location: index.php');
}
 
 
if(isset($_GET['mark_complete'])) {
  $id = $_GET['mark_complete'];
  $complete = $pdo-> prepare("UPDATE todo SET completed = 1 WHERE id = :id");
  $complete->execute(array(":id" => $id ));
  header('location: index.php');
}
 
$completed = $pdo->prepare("SELECT * FROM todo WHERE completed = 1 ORDER BY completed DESC");
$completed ->execute();
$completedlist = $completed -> fetchALL(PDO::FETCH_ASSOC);
 
 
?>



<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <title>Todo list</title>
      <link rel="stylesheet" type="text/css" href="style.css">
</head>
  <body>
     <div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="todolist not-done">
             <h1>Todos</h1>
            <form action="index.php" method="POST">
            <p><?php echo $add_task ?></p>
            <input type="text" name="title" class="task_input">
            <button type="submit" class="add_btn" name="submit">Add Task</button>
  </form>
                    
                    <hr>
                    <ul id="sortable" class="list-unstyled">
                    <li class="ui-state-default">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="" />Take out the </label>
                        </div>
                    </li>
                    <li class="ui-state-default">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="" />Buy bread</label>
                        </div>
                    </li>
                    <li class="ui-state-default">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="" />Teach penguins to fly</label>
                        </div>
                    </li>
                </ul>
                <div class="todo-footer">
                    <strong><span class="count-todos"></span></strong> Items Left
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="todolist">
             <h1>Already Done</h1>
                <ul id="done-items" class="list-unstyled">
                    <li>Some item <button class="remove-item btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-remove"></span></button></li>
                    
                </ul>
            </div>
        </div>
    </div>
</div>