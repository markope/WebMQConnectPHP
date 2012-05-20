AutobahnPushPHP
===============

Autobahn.ws Push for PHP allows to push out messages from PHP
application to WebSocket clients in real-time.


Getting started with PHP on Windows
-----------------------------------

1. Download PHP for Windows from http://windows.php.net/download/

2. Unpack PHP to C:/php543

3. Copy C:/php543/php.ini-development to C:/php543/php.ini

4. Edit C:/php543/php.ini for:

   extension_dir = "ext"
   extension=php_curl.dll

5. Clone AutobahnPushPHP:

   git clone git://github.com/tavendo/AutobahnPushPHP.git

6. Start the example:

   cd AutobahnPushPHP/examples/ex1
   php -S localhost:8000

7. Open http://localhost:8000/index.php in a first tab of your browser.

8. Open http://localhost:8000/client.php in a second tab of your browser.
