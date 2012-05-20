<!DOCTYPE html>
<html>
   <body>
      <?php
         require('../../autobahnpush/autobahnpush.php');

         $server = "http://127.0.0.1:8080";
         $appkey = "foobar";
         $appsecret = "secret";
         $client = new AutobahnPushClient($server, $appkey, $appsecret);

         $data = array("name" => $_POST['name'], "age" => $_POST['age']);
         $topic = "http://example.com/topic1";

         $result = $client->push($topic, $data);
         if ($result !== null)
         {
            echo "Push failed: " . $result;
         }
         else
         {
            echo "Push succeeded";
         }
      ?>
   </body>
</html>
