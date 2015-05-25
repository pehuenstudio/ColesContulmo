<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_config.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/_code/includes/_conexion.php";
//echo __FILE__."<br/>";
class Persona {
    private $run;
    private $nombre1;
    private $nombre2;
    private $apellido1;
    private $apellido2;
    private $sexo;
    private $id_direccion;

    private $avatar;
    private $email;
    private $estado = "1";

    public function set_apellido1($apellido1)
    {
        $this->apellido1 = $apellido1;
    }
    public function get_apellido1()
    {
        return $this->apellido1;
    }
    public function set_apellido2($apellido2)
    {
        $this->apellido2 = $apellido2;
    }
    public function get_apellido2()
    {
        return $this->apellido2;
    }
    public function set_avatar($avatar)
    {
        $this->avatar = $avatar;
    }
    public function get_avatar()
    {
        return $this->avatar;
    }
    public function set_email($email)
    {
        $this->email = $email;
    }
    public function get_email()
    {
        return $this->email;
    }
    public function set_estado($estado)
    {
        $this->estado = $estado;
    }
    public function get_estado()
    {
        return $this->estado;
    }
    public function set_nombre1($nombre1)
    {
        $this->nombre1 = $nombre1;
    }
    public function get_nombre1()
    {
        return $this->nombre1;
    }
    public function set_nombre2($nombre2)
    {
        $this->nombre2 = $nombre2;
    }
    public function get_nombre2()
    {
        return $this->nombre2;
    }
    public function set_run($run)
    {
        $this->run = $run;
    }
    public function get_run()
    {
        return $this->run;
    }
    public function set_sexo($sexo)
    {
        $this->sexo = $sexo;
    }
    public function get_sexo()
    {
        return $this->sexo;
    }
    public function set_id_direccion($id_direccion)
    {
        $this->id_direccion = $id_direccion;
    }
    public function get_id_direccion()
    {
        return $this->id_direccion;
    }


    public function set_identidad($run, $nombre1, $nombre2, $apellido1, $apellido2, $sexo, $id_direccion, $email) {
        $this->set_run($run);
        $this->set_nombre1($nombre1);
        $this->set_nombre2($nombre2);
        $this->set_apellido1($apellido1);
        $this->set_apellido2($apellido2);
        $this->set_sexo($sexo);
        $this->set_id_direccion($id_direccion);
        $this->set_email($email);
    }

    public function to_matriz(){
        $matriz = array(
            "run" => $this->get_run(),
            "nombre1" => $this->get_nombre1(),
            "nombre2" => $this->get_nombre2(),
            "apellido1" => $this->get_apellido1(),
            "apellido2" => $this->get_apellido2(),
            "sexo" => $this->get_sexo(),
            "id_direccion" => $this->get_id_direccion(),
            "avatar" => $this->get_avatar(),
            "email" => $this->get_email(),
            "estado" => $this->get_estado()
        );
        return $matriz;
    }


}
?> 