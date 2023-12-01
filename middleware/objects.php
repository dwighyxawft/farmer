<?php
class Objects {
    public $host;
    public $user;
    public $pass;
    public $dbms;
    public $query;
    public $home;
    public $connect;
    public $statement;

    function __construct(){
        $this->host = "localhost";
        $this->user = "root";
        $this->pass = "";
        $this->dbms = "farmer";
        $this->home = "http://localhost/farmer/";
        $this->connect = mysqli_connect($this->host, $this->user, $this->pass, $this->dbms);
        if($this->connect){
            session_start();
        }
        else{
            echo mysqli_connect_error($this->connect);
        }
    }

    function execute_query(){
        $this->statement = mysqli_query($this->connect, $this->query);
        if(!$this->statement){
            return false;
        }
        return true;
    }
    function total_rows(){
        $this->execute_query();
        return mysqli_num_rows($this->statement);
    }
    function query_result(){
        $this->execute_query();
        return mysqli_fetch_assoc($this->statement);
    }
    function query_array(){
        $this->execute_query();
        return mysqli_fetch_array($this->statement, MYSQLI_ASSOC);
    }
    function query_all(){
        $this->execute_query();
        return mysqli_fetch_all($this->statement, MYSQLI_ASSOC);
    }
    function redirect($url){
        $link = '<script>location.href = "'.$this->home.$url.'"</script>';
        return $link;
    }
    function user_session_private(){
        if(isset($_SESSION["user_id"])){
          echo $this->redirect("templates/dashboard.php");
        }
    }
    function user_session_public(){
        if(!isset($_SESSION["user_id"])){
          echo $this->redirect("templates/login.php");
        }
    }



}


?>