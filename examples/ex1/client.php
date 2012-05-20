<!DOCTYPE html>
<html>
   <head>
      <!-- <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script> -->
      <script src="http://autobahn.ws/public/autobahn.min.js"></script>

      <script>

         var session = null;

         window.onload = function() {
            //ab._Deferred = jQuery.Deferred;
            connect();
            ab.log(ab.version());
         };

         // connect to Autobahn.ws
         function connect() {

            // Autobahn.ws Server URI
            var wsuri = "ws://localhost";

            ab.connect(wsuri,

               function (sess) {
                  session = sess;
                  ab.log("connected!");
                  onConnect0();
               },

               function (code, reason, detail) {

                  session = null;
                  switch (code) {
                     case ab.CONNECTION_UNSUPPORTED:
                        window.location = "http://autobahn.ws/unsupportedbrowser";
                        break;
                     case ab.CONNECTION_CLOSED:
                        window.location.reload();
                        break;
                     default:
                        ab.log(code, reason, detail);
                        break;
                  }
               },

               {'maxRetries': 60, 'retryDelay': 2000}
            );
         }

         // authenticate as "anonymous"
         //
         function onConnect0() {
            session.authreq().then(function () {
               session.auth().then(onAuth, ab.log);
            }, ab.log);
         }

         // authenticate as "heinz"
         //
         function onConnect1() {
            session.authreq("heinz").then(function (challenge) {

               // direct sign or AJAX to 3rd party
               var signature = session.authsign(challenge, "geheim");

               session.auth(signature).then(onAuth, ab.log);
            }, ab.log);
         }

         // authenticate as "foobar", providing extra data
         //
         function onConnect2() {

            var extra = {user: 'otto', role: 'author', age: 24};
            session.authreq("foobar", extra).then(function (challenge) {

               // direct sign or AJAX to 3rd party
               var signature = session.authsign(challenge, "secret");

               session.auth(signature).then(onAuth, ab.log);
            }, ab.log);
         }

         var myTopic = "http://example.com/topic1";

         function onAuth(permissions) {
            ab.log("authenticated!", permissions);
            session.subscribe(myTopic, onMyEvent);
         };

         function onMyEvent(topic, event) {
            ab.log("MyEvent", topic, event);
         };

         function publishToMyTopic() {
            //ab.log("clicked");
            session.publish(myTopic, "Hello, world!");
         };
      </script>
   </head>
   <body>
      <h1>Autobahn.ws Test Client</h1>
      <button onclick="publishToMyTopic();">Publish!</button>
   </body>
</html>
