<!DOCTYPE html>
<html>
   <head>
      <link rel="stylesheet" href="styles.css">
   </head>
   <body>
      <h1 class="title">Tavendo WebMQ - Push from PHP</h1>

      <form action="client.php" target="_blank" method="post">
         <h1>Real-time Client</h1>
         <p>
            WebSocket Service:
            <input type="text" name="wsuri" size="40" value="wss://autobahn-euwest.tavendo.de" />
         </p>
         <p>
            Topic:
            <input type="text" name="topic" size="60" value="http://autobahn.tavendo.de/public/demo/topic1" />
         </p>
         <p>
            <input type="submit" value="Open" />
         </p>
      </form>

      <form action="form.php" target="_blank" method="post">
         <h1>User Form</h1>
         <p>
            Push Service:
            <input type="text" name="pushendpoint" size="40" value="http://autobahn-euwest.tavendo.de:8080" />
         </p>
         <p>
            Topic:
            <input type="text" name="topic" size="60" value="http://autobahn.tavendo.de/public/demo/topic1" />
         </p>
         <p>
            <input type="submit" value="Open" />
         </p>
      </form>

   </body>
</html>
