<!DOCTYPE html>
<html>
   <head>
      <link rel="stylesheet" href="styles.css">
   </head>
   <body>
      <h1 class="title">Tavendo WebMQ - Push from PHP</h1>
      <form action="action.php" method="post">
         <h1>User Form</h1>
         <p>
            Your name:
            <input type="text" name="name" value="Bob Ross" />
         </p>
         <p>
            Your age:
            <input type="text" name="age" value="66" />
         </p>
         <p>
            <input type="submit" value="Submit Form"/>
            <input type="hidden" name="topic" value="<?php echo $_POST['topic']; ?>"/>
            <input type="hidden" name="pushendpoint" value="<?php echo $_POST['pushendpoint']; ?>"/>
         </p>
      </form>
   </body>
</html>
