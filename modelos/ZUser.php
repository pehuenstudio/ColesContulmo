<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";

class ZUser {
    private $id;
    private $name;
    private $username;
    private $usergroup;
    private $email;
    private $password;

    public function get_email()
    {
        return $this->email;
    }
    public function set_email($email)
    {
        $this->email = $email;
    }
    public function get_id()
    {
        return $this->id;
    }
    public function set_id($id)
    {
        $this->id = $id;
    }
    public function get_name()
    {
        return $this->name;
    }
    public function set_name($name)
    {
        $this->name = $name;
    }
    public function get_password()
    {
        return $this->password;
    }
    public function set_password($password)
    {
        $this->password = $password;
    }
    public function get_username()
    {
        return $this->username;
    }
    public function set_username($username)
    {
        $this->username = $username;
    }
    public function get_usergroup()
    {
        return $this->usergroup;
    }
    public function set_usergroup($usergroup)
    {
        $this->usergroup = $usergroup;
    }


    public function set_identidad($name, $username, $usergroup, $email, $password){
        $this->set_name($name);
        $this->set_username($username);
        $this->set_usergroup($usergroup);
        $this->set_email($email);
        $this->set_password($password);
    }
}
?>