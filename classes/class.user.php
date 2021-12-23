<?php

class User{

    private $db;
    
    public function __construct($db){
        $this->db = $db; 
    }


    public function is_logged_in(){
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            return true;
        }        
    }


    public function create_hash($value)
    {
        return $hash = crypt($value, '$2a$12.substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22)');


    }

    private function verify_hash($password,$hash)
    {
        return $hash == crypt($password, $hash);
    }

    private function get_user_hash($username){    

        try {

            //echo $this->create_hash('demo');

            $stmt = $this->db->prepare('SELECT password FROM sahil_blog_users WHERE username = :username');
            $stmt->execute(array('username' => $username));
            
            $row = $stmt->fetch();
            return $row['password'];

        } catch(PDOException $e) {
            echo '<p class="error">'.$e->getMessage().'</p>';
        }
    }

    
    public function login($username,$password){
        $hashed = $this->get_user_hash($username);
        
        if($this->verify_hash($password,$hashed) == 1){
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $stmt = $this->db->prepare('SELECT u_group FROM sahil_blog_users WHERE username = :username');
            $stmt->execute(array('username' => $username));
            $row = $stmt->fetch();
            $_SESSION['group']=$row["u_group"];
            return true;
        }    
    }
        
    public function logout(){
        session_destroy();
    } 
}

?>