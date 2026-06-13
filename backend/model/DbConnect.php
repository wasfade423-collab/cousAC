<?php
include("config/database.php");
class DbConnect
{
    protected $database;
    protected $dbConnect;

    public function __construct()
    {
        $this->database = new Database();
        $this->dbConnect = $this->database->dbConnect();
        if (is_string($this->dbConnect)) {
            echo json_encode($this->dbConnect);
        }
    }
}
