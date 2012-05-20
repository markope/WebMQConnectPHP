<!DOCTYPE html>
<html>
   <body>
      <?php
         require('../../autobahnpush/autobahnpush.php');

         $client = new AutobahnPushClient("http://127.0.0.1:8080");
         $data = array("name" => $_POST['name'], "age" => $_POST['age']);

         echo $client->push("http://example.com/topic1", $data);
      ?>
   </body>
</html>
