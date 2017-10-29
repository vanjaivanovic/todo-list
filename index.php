<?php

require 'database.php';
require 'addtodo.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
                    <meta charset="UTF-8">
                    <title>Todo list</title>
                    <link rel="stylesheet" type="text/css" href="style.css">
                    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
                   
                   
 
 
 
</head>
 
 
  <body>
    
     <div class="container">
    <div class="row">
        <div class="col-xs-6">
            <div class="todolist not-done">
             <h1>Todos</h1>
             <form action="index.php" method="POST">
                    <p><?php echo $message ?></p>
                    <input type="text" name="title" class="task_input">
                    <button type="submit" class="add_btn" name="submit">Add Task</button>
</form>
              <table>
              <thead>
              <tr>
              <th></th> 
              <th></th>
              <th></th>
          </tr>
      </thead>
 
                 <tbody>
                    <?php foreach ($mytodolist as $task) {
                    ?>
                                       <tr>
                                                           <td></td>
                                                           <td class="task"><p><?= $task['title']; ?></p></td> <!--här printas den ut. Och det som printas ut är 'title' columnen från databasen. -->
                                                           <td class="check">
                                                                              <a href="index.php?check_task=<?php echo $task['id']; ?>">Check</a>
                                                           </td>
                                                           <td class="delete">
                                                                              <a href="index.php?delete_task=<?php echo $task['id']; ?>">Delete</a>
                                                           </td>
                                       </tr>
                   
                    <?php } ?> <!--stänger foreach-->
 
        </tbody>
    </table>
   
        
      <hr>
 
        <div class="col-xs-6">
                    <div class="donelist">
           
             <h1>Already Done</h1>
             <table>
                   
                                       <tbody>
                                                           <?php foreach ($list_already_done as $checked) {
                                                           ?>  <!-- Här sker foreach loopen som är kopplad till sista utförande i PHP filen. $list_already_done håller alla objekt lagrade och as $checked hämtar endast en av dem. Foreach loopen loopar sig alltså igenom en ARRAY och kommer göra det tills det inte finns något mer att hämta. Här hämtas alltså de som har complete=1 i din databas-->
                                       <tr>
                                                           <td></td>
                                                           <td id="done-items" class="list-unstyled">
                                                                              <p><?= $checked['title']; ?></p></td>
                                                           <td class="delete">
                                                                              <a href="index.php?delete_task=<?php echo $checked['id']; ?>">Delete</a>
                                                           </td>
                                       </tr>
                                      
                                       <?php } ?> <!--stänger foreach loop-->
 
                                       </tbody>
                    </table>
 
               
           </div> <!--stänger col-->
        </div> <!--stänger donelist-->
 
   </div><!--stänger todolist-->
   </div> <!--stänger col-->        
           
       
</div> <!--stänger row-->
</div> <!--stänger container-->
 
<footer>
<a href="">My github</a>
</footer>


 
 

 
 
</body>
 
 
</html>