<?php
class MysqlObjectDatabase
{
    private $conn;
    public function __construct($host, $port, $username, $password, $database)
    {
        $this->conn = new mysqli($host, $username, $password, $database, $port);
    }


    /**
     * @throws Exception
     */
    public function query($sql)
    {
        $result = $this->conn->query($sql);

        if ($result === false) {
            throw new Exception("Query failed: " . $this->conn->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function execute($sql)
    {
        if ($this->conn->query($sql) === false) {
            throw new Exception("Execution failed: " . $this->conn->error);
        }

        return $this->conn->affected_rows;
    }

    public function __destruct()
    {
        $this->conn->close();
    }



}
