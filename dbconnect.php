<?php
    class DbConnect {
        private $server = "localhost";
        private $dbname = "jwtapi";
        private $user = "root";
        private $password = "G0disgre@t";
        public function connect()
        {
            try {
                $conn = new PDO('mysql:host=' .$this->server . ';dbname=' . $this->dbname,$this->user,$this->password);
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch (\Exception $e) {
                header("Content-Type:application/json");
                echo json_encode(['error' => ['from' => 'Database connection','message' => $e->getMessage()]]);exit;
            }
        }
    }
?>