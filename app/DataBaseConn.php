<?php

class DataBaseConn
{
    private string $host;
    private string $user;
    private string $pw;
    private string $db;
    private int $port;

    private $mysqli;

    /**
     * @param string $host
     * @param string $user
     * @param string $pw
     * @param string $db
     */
    public function __construct(string $host, string $user, string $pw, string $db, int $port )
    {
        $this->host = $host;
        $this->user = $user;
        $this->pw = $pw;
        $this->db = $db;
        $this->port = $port;
        $this->mysqli = new mysqli(hostname: $this->host, username: $this->user, password: $this->pw, database: $this->db, port: $this->port);

        if ($this->mysqli->connect_errno) {
            echo "FAILED CONNECTION";
        }
    }

    public function __destruct() {
        $this->mysqli->close();
    }

    public function schema(){

        $dropTableQuery = "DROP TABLE IF EXISTS jo";

        if ($this->mysqli->query($dropTableQuery) === TRUE) {
            echo 'Tabela została usunięta lub nie istniała.';
        } else {
            echo 'Błąd podczas usuwania tabeli: ' . $this->mysqli->error;
        }

        $createTableQueryAgain = "
            CREATE TABLE jo (
                kolumna1 INT,
                kolumna2 INT,
                kolumna3 INT
            )
        ";

        if ($this->mysqli->query($createTableQueryAgain) === TRUE) {
            echo 'Tabela została ponownie utworzona.';
        } else {
            echo 'Błąd podczas ponownego tworzenia tabeli: ' . $this->mysqli->error;
        }

    }

    public function put(string $table, $columns, $values)
    {
        $query = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ");";

        $allOk = false;

        if ($this->mysqli->query($query) === TRUE) {
            echo "ADDED RECORD OK";
            $allOk = true;
        } else {
            echo "ERROR: " . $this->mysqli->error;
        }

        return $allOk;
    }

    public function update(string $table, $set, $conditions)
    {
        $query = "UPDATE " . $table . " SET " . $set . " WHERE " . $conditions . ";";

        $allOk = false;

        if ($this->mysqli->query($query) === TRUE) {
            echo "UPDATE RECORD OK";
            $allOk = true;
        } else {
            echo "ERROR: " . $this->mysqli->error;
        }

        return $allOk;
    }

    public function get(string $table, $columns, $arrayOptions)
    {


        $query = "SELECT " . $columns . " FROM " . $table . " WHERE " . $arrayOptions . ";";

        $result = $this->mysqli->query($query);

        $allOk = false;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                print_r($row);
            }
            $allOk = true;
        } else {
            echo "Brak wynikow";
        }

        return $allOk;
    }

    public function delete(string $table, string $conditions)
    {

        $query = "DELETE FROM " . $table . " WHERE " . $conditions . ";";

        $result = $this->mysqli->query($query);

        $allOk = false;
        if ($result) {
            echo "Usunieto rekordy";
            $allOk = true;
        } else {
            echo "Brak wynikow";
        }

        return $allOk;
    }


}


?>