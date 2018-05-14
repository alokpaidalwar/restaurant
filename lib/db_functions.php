<?php
date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

class db {
        private $conn;
        private $host;
        private $user;
        private $password;
        private $baseName;
        private $port;
        private $Debug;
    
     /** constructor to initialize vairables **/ 
    function __construct($params=array()) {
        $this->conn = false;
        $this->host = 'localhost'; //hostname
        $this->user = 'root'; //username
        $this->password = ''; //password
        $this->baseName ='restaurant'; //name of your database
        $this->port = '3306';
        $this->debug = true;
        $this->connect();
    }
 
     /** destructor to disconnect **/ 
    function __destruct() {
        $this->disconnect();
    }
    
     /** connect to database **/
    function connect() {
        if (!$this->conn) {
            try {
                $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->baseName.'', $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));  
            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
 
            if (!$this->conn) {
                $this->status_fatal = true;
                echo 'Connection BDD failed';
                die();
            } 
            else {
                $this->status_fatal = false;
            }
        }
        return $this->conn;
    }
 
    /** disconnect the connection with database **/ 
    function disconnect() {
        if ($this->conn) {
            $this->conn = null;
        }
    }
    
     /** to execute Select query to get one values **/
    function getOne($query) {
        $result = $this->conn->prepare($query);
        $ret = $result->execute();
        if (!$ret) {
           echo 'PDO::errorInfo():';
           echo '<br />';
           echo 'error SQL: '.$query;
           die();
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $reponse = $result->fetch();
        
        return $reponse;
    }

    /** to execute Select query to get more than one values **/
    function getAll($query) {
        $result = $this->conn->prepare($query);
        $ret = $result->execute();
        if (!$ret) {
           echo 'PDO::errorInfo():';
           echo '<br />';
           echo 'error SQL: '.$query;
           die();
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $reponse = $result->fetchAll();
        
        return $reponse;
    }
    
    /** to execute any query other than SELECT**/
    function execute($query) {
        $response = $this->conn->exec($query);
        
        return $response;
    }

    /** Check Login values **/
    function check($value){
        $value = trim($value);
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        $value = strtr($value,array_flip(get_html_translation_table(HTML_ENTITIES)));
        $value = strip_tags($value);
        $value = htmlspecialchars ($value);
        return $value;
    } 

    /** Encrypting password @param password, returns salt and encrypted password **/
    function hashSSHA($password) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }   

    /** Decrypting password @param salt, password returns hash string **/
    function checkhashSSHA($salt, $password) {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
        return $hash;
    }


    /** Validate User Login details**/
    function validateUser($username,$password){
        // checking for injection
        $username=$this->check($username);
        $query=$this->getOne("SELECT * FROM users_info WHERE username='$username'");
        // verifying user password
        $salt = $query['salt'];
        $encrypted_password = $query['password'];
        $hash = $this->checkhashSSHA($salt, $password);
        // check for password equality
        if ($encrypted_password == $hash) {
            // user authentication details are correct
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $query['user_id']; 
            return true;
        } else {
            // user authentication details are wrong
            return null;
        }
    }


    /** New User Registration **/
    function registerUser($username,$password,$fullname) {
        //check if user already exist with same username
        $alreadyExist=$this->getOne("SELECT user_id FROM users_info WHERE username = '$username'");
        if($alreadyExist!=null){
            return null;
        }else{
            $uuid = uniqid('', true);
            $hash = $this->hashSSHA($password);
            $encrypted_password = $hash["encrypted"]; // encrypted password
            $salt = $hash["salt"]; // salt
            $this->execute("INSERT INTO users_info VALUES('','$username','$encrypted_password','$fullname','$salt',NOW())");
            $result = $this->getOne("SELECT * FROM users_info WHERE username = '$username'");
            return $result;
        }
    }

    /** Add new order **/
    function addOrder($user_id,$item_id,$quantity,$total){
        $result= $this->execute("INSERT INTO orders VALUES('','$item_id','$user_id','$quantity','$total',NOW())");
        return $result;
    }
    
    /** Get sum of total sale according to date **/
    function getLineChartData(){
        $result = $this->getAll("SELECT DATE(datetime) as date, SUM(total_amount) as total FROM orders 
                WHERE user_id = '".$_SESSION['user_id']."' GROUP BY DATE(datetime) ORDER BY DATE(datetime)");
        return $result;
    }

    /** Get sum of quantity according to items **/
    function getPieChartData(){
        $result = $this->getAll("SELECT menu.item_name, SUM(quantity) as quantity FROM orders 
                        JOIN menu ON orders.item_id= menu.item_id  WHERE user_id = '".$_SESSION['user_id']."' 
                        GROUP BY orders.item_id ORDER BY orders.item_id");
        return $result;
    }
   
    /** Get sum of total sale according to items **/
    function getBarChartData(){
        $result = $this->getAll("SELECT menu.item_name, SUM(total_amount) as total FROM orders 
                        JOIN menu ON orders.item_id= menu.item_id  WHERE user_id = '".$_SESSION['user_id']."' 
                        GROUP BY orders.item_id ORDER BY orders.item_id");
        return $result;
    }
}
