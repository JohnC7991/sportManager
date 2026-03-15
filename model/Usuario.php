<?php

class Usuario{

    private $conexion;

    public function __construct($conexion){
        $this->conexion = $conexion;
    }

    public function login($email,$password){

        $sql = $this->conexion->prepare("SELECT * FROM usuarios WHERE email = :email AND habilitado = 1");
        $sql->bindParam(":email",$email);
        $sql->execute();

        if($sql->rowCount()>0){

            $usuario = $sql->fetch(PDO::FETCH_ASSOC);

            if(password_verify($password,$usuario['contrasena'])){

                return $usuario;

            }else{

                return false;
            }

        }else{
            return false;
        }

    }

    public function registrar($id, $tipo_documento, $id_escuela, $nombres, $apellidos, $email, $password, $telefono){
        
        // Encriptar la contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $id_rol = 2; // Asumimos rol 2 para usuarios registrados desde la web
        $habilitado = 1;

        try{
            $sql = $this->conexion->prepare("INSERT INTO usuarios (id, tipo_documento, id_escuela, nombres, apellidos, email, contrasena, telefono, id_rol, habilitado) VALUES (:id, :tipo_documento, :id_escuela, :nombres, :apellidos, :email, :contrasena, :telefono, :id_rol, :habilitado)");
            $sql->bindParam(":id", $id);
            $sql->bindParam(":tipo_documento", $tipo_documento);
            $sql->bindParam(":id_escuela", $id_escuela);
            $sql->bindParam(":nombres", $nombres);
            $sql->bindParam(":apellidos", $apellidos);
            $sql->bindParam(":email", $email);
            $sql->bindParam(":contrasena", $passwordHash);
            $sql->bindParam(":telefono", $telefono);
            $sql->bindParam(":id_rol", $id_rol);
            $sql->bindParam(":habilitado", $habilitado);
            
            return $sql->execute();
        }catch(PDOException $e){
            return false;
        }
    }

}

?>