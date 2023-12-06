<?php 

class Roles{

	static function agregarUsuario($idUsuario){

		$statement = Conexion::conectar()->prepare("INSERT INTO rol_usuarios (id_usuario, id_rol) VALUES (:id_usuario, 2)");

		$statement->bindParam(":id_usuario", $idUsuario, PDO::PARAM_INT);

		if($statement->execute()){
			return true;
		}else{
			print_r(Conexion::conectar()->errorInfo());
		}

		return false;


	}

}