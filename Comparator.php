<?php

class Comparator
{
    /**
     * @param string $dbHostname
     * @param string $dbName
     * @param string $dbUsername
     * @param string $dbPassword
     * @return array
     */
    public function loadInternalData(string $dbHostname, string $dbName, string $dbUsername, string $dbPassword) {
        try {

            $conn = new PDO("mysql:host=$dbHostname;dbname=$dbName", $dbUsername, $dbPassword);

            $sth = $conn->prepare("SELECT * FROM my_data");
            $sth->execute();
            $result = $sth->fetchAll();
            return $result;

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return [];
        }
    }

    /**
     * @param string $jsonDataFilePath
     * @return array
     */
    public function loadExternalData(string $jsonDataFilePath) {
        $data = file_get_contents($jsonDataFilePath);

        return json_decode($data);
    }

    public function check() {

        $dbData = $this->loadInternalData("localhost", "test", "root", "");

        $jsonData = $this->loadExternalData("data.json");

        foreach ($jsonData as $jsonItem) {
            foreach ($dbData as $dbItem) {
                if($dbItem["name"] == $jsonItem->name) {
                    print($jsonItem->id . "\n");
                    break;
                }
            }
        }
    }
}