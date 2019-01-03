<?php

class DemoLib
{


    public function Register($name, $email, $username, $password, $level)
    {
        try {
            $conn = db();
            $query = $conn->prepare("INSERT INTO authentication(name, email, username, password, level) VALUES (:name,:email,:username,:password,:level)");
            $query->bindParam("name", $name, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->bindParam("password", $password, PDO::PARAM_STR);
            $query->bindParam("level", $level, PDO::PARAM_STR);
            $query->execute();
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
 
    public function isUsername($username)
    {
        try {
            $conn = db();
            $query = $conn->prepare("SELECT user_id FROM authentication WHERE username=:username");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

     public function isEmail($email)
    {
        try {
            $conn = db();
            $query = $conn->prepare("SELECT user_id FROM authentication WHERE email=:email");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function Login($username, $password, $level, $email)
    {
        try {
            $conn = db();
            $query = $conn->prepare("SELECT staffid FROM staff_tb WHERE (username=:username OR email=:email) AND password=:password AND level=:level");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->bindParam("password", $password, PDO::PARAM_STR);
            $query->bindParam("level", $level, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->staffid;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function UserDetails($staffid)
    {
        try {
            $conn = db();
            $query = $conn->prepare("SELECT * FROM staff_tb WHERE staffid=:staffid");
            $query->bindParam("staffid", $staffid, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function leave($workid)
    {
      try {
        $conn = db();
        $query = $conn->prepare("SELECT leaveid FROM leavetb WHERE workid=:workid");
        $query->bindParam("workid", $workid, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
          $result = $query->fetch(PDO::FETCH_OBJ);
          return $result->leaveid;
        } else {
          return false;
        }
      } catch (PDOException $e) {
        exit($e->getMessage());
      }
    }
    public function LeaveDetails($leaveid)
    {
        try {
            $conn = db();
            $query = $conn->prepare("SELECT * FROM leavetb WHERE leaveid=:leaveid");
            $query->bindParam("leaveid", $leaveid, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}