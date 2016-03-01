<?php

// 6. Начать создавать класс MySQLDB в котором реализовать методы addUser, findUser и все остальные.
// (по аналогии с тем что было в ранее в классе FilDB но уже для работы с БД, а не файлом)
// Конструктор должен принимать настройки для подключения.

class MySQLDB
{
    //поля
    private $settingToConnect1;
    private $settingToConnect2;

    //конструктор принимающий настройки для подключения
    public function __construct($driver, $dbName, $ipHost, $dbUserName)
    {
        $this->settingToConnect1 = $driver . ":" . "dbname=" . $dbName . ";" . "host=" . $ipHost;
        $this->settingToConnect2 = "$dbUserName";
    }

    //МЕТОДЫ КЛАССА

    //найти пользователя
    public function findUser($username, $password)
    {
        // подключаемся к БД
        try {
            $pdo = new PDO($this->settingToConnect1, $this->settingToConnect2);
        } catch (PDOException $e) {
            echo "Connection error!";
            var_dump($e->getMessage());
        }

        // делаем запрос по пользователю
        try {
            $pdoStatement = $pdo->query("SELECT * FROM user WHERE username='" . $username . "' AND password='" . $password . "'");// для возвращения результата от запроса
            $data = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
//            var_dump($data);
        } catch (PDOException $e) {
            echo "query ERROR!";
            echo $e->getMessage();
        }

        if (!empty($data)) {
            return true;
        } else {
            return false;
        }
    }

    //найти UserName пользователя
    public function findUserName($username)
    {
        // подключаемся к БД
        try {
            $pdo = new PDO($this->settingToConnect1, $this->settingToConnect2);
        } catch (PDOException $e) {
            echo "Connection error!";
            var_dump($e->getMessage());
        }

        // делаем запрос по UserName пользователю
        try {
            $pdoStatement = $pdo->query("SELECT * FROM user WHERE username='" . $username . "'");// для возвращения результата от запроса
            $data = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
//            var_dump($data);
        } catch (PDOException $e) {
            echo "query ERROR!";
            echo $e->getMessage();
        }

        if (!empty($data)) {
            return true;
        } else {
            return false;
        }
    }

    //добавить пользователя
    public function addUser($username, $password)
    {
        try {
            $pdo = new PDO($this->settingToConnect1, $this->settingToConnect2);
        } catch (PDOException $e) {
            echo "Connection error!";
            var_dump($e->getMessage());
        }

        try {
            $q = "INSERT INTO `user` (`username`, `password`) VALUES ('" . $username . "', '" . $password . "')";
            $pdo->query($q);
//            echo $q;

//            INSERT INTO `user` (`id`, `username`, `password`) VALUES (NULL, 'abr', '555');
//            INSERT INTO `user` (`username`, `password`) VALUES ('abr', '555')

        } catch (PDOException $e) {
            echo "query ERROR!";
            echo $e->getMessage();
        }
        return true;
    }

    // добавить фото
    public function addPhoto($username, $photoURI, $description)
    {
        try {
            $pdo = new PDO($this->settingToConnect1, $this->settingToConnect2);
        } catch (PDOException $e) {
            echo "Connection error!";
            var_dump($e->getMessage());
        }

        try {
            $q = "INSERT INTO `photo` (`username`, `photoURI`, `description`, `dateTime`) VALUES ('" . $username . "', '" . $photoURI . "', '" . $description . "', NOW())";
            $pdo->query($q);
            echo $q;

        } catch (PDOException $e) {
            echo "query ERROR!";
            echo $e->getMessage();
        }
        return true;
    }

    // получить фото
    public function getPhoto($username, $photoId)
    {
        try {
            $pdo = new PDO($this->settingToConnect1, $this->settingToConnect2);
        } catch (PDOException $e) {
            echo "Connection error!";
        }

        try {
            $q = "SELECT * FROM photo WHERE username='" . $username . "' AND id='" . $photoId . "'";
            $pdoStatement = $pdo->query($q);// для возвращения результата от запроса
            $data = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "query ERROR!";
            echo $e->getMessage();
        }

        if (!empty($data)) {
            return [
                'photoURI'=> $data[0]['photoURI'],
                'description'=> $data[0]['description'],
                'dateTime'=> $data[0]['dateTime']
            ];
        } else {
            return false;
        }
    }

//    получить все фото (пока без пагинации для этого добавить  $page, $perPage в getPhotos()   )
    public function getPhotos($username)
    {
        try {
            $pdo = new PDO($this->settingToConnect1, $this->settingToConnect2);
        } catch (PDOException $e){
            echo "Connection error!";
            $e->getMessage();
        }

        try {
            $q = "SELECT * FROM photo WHERE username='".$username."'";
            $pdoStatement = $pdo->query($q);
            $data = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            echo "query ERROR!";
            $e->getMessage();
        }
        return $data;
}

    //удаление фотографий
    public function deletePhoto($username, $id)
    {
        try {
            $pdo = new PDO($this->settingToConnect1, $this->settingToConnect2);
        } catch (PDOException $e) {
            echo "Connection error!";
            var_dump($e->getMessage());
        }

        try {
            $q = "DELETE FROM `photo` WHERE id='".$id."' AND username='".$username."'";
            $pdo->query($q);
        } catch (PDOException $e) {
            echo "query ERROR!";
            echo $e->getMessage();
        }
        return true;
    }

    //PostCount
    public function postCount($username)
    {
        try {
            $pdo = new PDO($this->settingToConnect1, $this->settingToConnect2);
        } catch (PDOException $e) {
            echo "Connection error!";
            var_dump($e->getMessage());
        }

        try {
            $q = "SELECT COUNT(*) count FROM `photo` WHERE username='".$username."'";
            $pdoStatement = $pdo->query($q);// для возвращения результата от запроса
            $data = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "query ERROR!";
            echo $e->getMessage();
        }

        return $data[0]['count'];
    }

}

$test = new MySQLDB("mysql", "usersandphotos", "127.0.0.1", "root");

//var_dump($test->findUser('Andrey', 123));
//var_dump($test->findUserName("Miron"));
//var_dump($test->addUser("asterisk3", 555));
//var_dump($test->addPhoto('Marina', 'D:db5.jpg', '5'));
//var_dump($test->getPhoto('Andrey', '1'));
//var_dump($test->deletePhoto('Marina', '16'));
//var_dump($test->postCount('Marina'));
//var_dump($test->getPhotos('Andrey'));
