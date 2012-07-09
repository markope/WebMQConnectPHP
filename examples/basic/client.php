<!DOCTYPE html>
<html>
   <head>
      <link rel="stylesheet" href="styles.css">

      <!-- AutobahnJS client library -->
      <script src="http://autobahn.s3.amazonaws.com/js/autobahn.min.js"></script>

      <script>

         // Tavendo WebMQ WebSocket/WAMP URL
         var wsuri = "<?php echo $_POST['wsuri']; ?>";

         // The topic we use
         var topic = "<?php echo $_POST['topic']; ?>";

         // will hold our WebSocket/WAMP client session
         var session = null;

         window.onload = function() {
            
            // connect upon window load
            connect();
         };

         function connect() {

            // connect to WebMQ
            ab.connect(wsuri,

               // called when connection has been established
               function (sess) {
                  log("connected", wsuri);
                  session = sess;

                  // continue with authentication ..
                  onConnect();
               },

               // called when connection was lost, failed or on reconnects
               function (code, reason, detail) {
                  log("connection lost", code, reason, detail);
               }
            );
         }

         // authenticate as "anonymous"
         function onConnect() {
            session.authreq().then(function () {
               session.auth().then(onAuth, log);
            }, log);
         }

         // we are now authenticated
         function onAuth(permissions) {
            log("authenticated", permissions);

            // subscribe to our topic
            session.subscribe(topic, onEvent);
            log("subscribed", topic);
         };

         // we have received an event on our topic
         function onEvent(topic, event) {
            log("event", topic, event);
         };

         function log() {
            var l = document.getElementById("evts")
            for (var i = 0; i < arguments.length; ++i) {
               if (i > 0) {
                  l.innerHTML += ", ";
               }
               l.innerHTML += JSON.stringify(arguments[i]);
            }
            l.innerHTML += "\n";
         };
      </script>
   </head>
   <body>
      <h1 class="title">Tavendo WebMQ - Push from PHP</h1>
      <pre id="evts"></pre>
   </body>
</html>
