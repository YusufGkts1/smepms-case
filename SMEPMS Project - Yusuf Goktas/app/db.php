<?php
class DB{
    protected string $serverName;
    protected string $userName;
    protected string $passCode;

    private function dbConnection() {
        $this -> serverName = 'localhost';
        $this -> userName = 'root';
        $this -> passCode = '';

        // Create connection
        $conn = new mysqli('localhost', 'root', '', 'smepms');
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    public function save($id, $name, $width, $height, $length){

        $conn = $this->dbConnection();
        $name = $conn->real_escape_string($name);

        $date = date('d-m-y h:i:s');
        if ($id)
        {
            $sql = "UPDATE boxes SET name='$name' , width = '$width', height = '$height', length = '$length', updated_on = '$date' WHERE id = '$id'";
        }else{
            $sql = "INSERT INTO boxes (name, width, height, length, created_on, updated_on) 
                    VALUES ('$name', '$width', '$height', '$length', '$date', '$date')";
        }

        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $id = $conn->insert_id;
        $conn->close();
        return $id;
    }

    public function delete($id)
    {
        $conn = $this->dbConnection();

        $sql = "DELETE FROM boxes WHERE id = '$id'";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
         $conn->close();

    }

    public function getAllBoxes()
    {
        $conn = $this->dbConnection();
        $sql = "SELECT * FROM boxes";
        $response = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

        $conn->close();
        return $response;
    }
    public function getBoxById($id)
    {
        $conn = $this->dbConnection();
        $sql = "SELECT * FROM boxes WHERE id = '$id'";
        $response = $conn->query($sql)->fetch_assoc();

        $conn->close();
        return $response;
    }
}


