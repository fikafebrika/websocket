# WEBSOCKET USING RATCHET LIBRARY

## How to Use Properties and Method from websocket/db/DBConnect.php

### Properties from Class DbConnect
Adjust the connection properties based on your database setting that you're using
```Ruby
class DbConnect {
  private $host = 'localhost';
  private $dbName = 'websocket';
  private $user = 'root';
  private $pass = '';
}
```
Calling the properties to your function simply by adding this using PDO, for example:
```Ruby
$conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName, $this->user, $this->pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $conn;
```

### Method from class DbConnect
```Ruby
public function connect() {
      try {
        $conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbName, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
      } catch( PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
      }
}
```
For example, if you want to make your file accessing database, you can use connect() method from DbConnect Class, just like code below:
```Ruby
require_once("DbConnect.php");
$db = new DbConnect();
$this->dbConn = $db->connect();
```
Insert code above to your function.

## TRY THE WEBSOCKET

### How to Run
Run the code below using command prompt
```Ruby
php /bin/server.php
```

### Thank You!
