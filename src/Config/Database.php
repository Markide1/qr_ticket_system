<?php
namespace App\Config;

class Database {
    private $host = "127.0.0.1";  
    private $db_name = "qr_ticket_system";
    private $username = "root";
    private $password = "";
    private $socket = "/opt/lampp/var/mysql/mysql.sock";

    protected $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Check if socket should be used
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            
            // Uncomment the next line if you're using a socket:
            // $dsn .= ";unix_socket=" . $this->socket;

            $this->conn = new \PDO(
                $dsn,
                $this->username,
                $this->password
            );

            // Set error mode to exception for better debugging
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            
            return $this->conn;
        } catch (\PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
            return null;
        }
    }
}
