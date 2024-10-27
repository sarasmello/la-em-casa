<?php
define('DB_SERVER', 'localhost'); 
define('DB_USERNAME', 'root');    
define('DB_PASSWORD', '');    
define('DB_NAME', 'controle_estoque');

//criar a conexão
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>