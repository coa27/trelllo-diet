<?php

class Auth {

	static function RegistrarUsuario($usuario) {
		try{
			$con = Conexion::conectar();

			$statement = $con->prepare("INSERT INTO usuarios (email, password, apodo, imagen_url) VALUES (:email, :password, :apodo, :imagen_url)");
			$password = password_hash($usuario["password"], PASSWORD_DEFAULT);

			$statement->bindParam(":email", $usuario["email"], PDO::PARAM_STR);
			$statement->bindParam(":password", $password, PDO::PARAM_STR);
			$statement->bindParam(":apodo", $usuario["apodo"], PDO::PARAM_STR);
			$statement->bindParam(":imagen_url", $usuario["imagen_url"], PDO::PARAM_STR);

			$statement->execute();

			// La api busca devolver el ultimo objeto agregado, por lo que requerimos el id del objeto recien creado para obtener todos sus valores.
			$id = $con->lastInsertId();
			$statement = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE id_usuario = :id");
			$statement->bindParam(":id", $id, PDO::PARAM_INT);
			$statement->execute();

			//se devuelve el objeto recien creado
			return $statement->fetch(PDO::FETCH_ASSOC);

		}catch(PDOException $e){
			print_r(Conexion::conectar()->errorInfo());
		}

		return null;
	}

	static function accederUsuario($usuario) {
		try{
			$statement = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE email = :email");

			$statement->bindParam(":email", $usuario["email"], PDO::PARAM_STR);
			$statement->execute();
			if ($statement->rowCount() > 0){
				return $statement->fetch(PDO::FETCH_ASSOC);
			}else{
				return null;
			}
		}catch(PDOException $e){
			print_r(Conexion::conectar()->errorInfo());
		}

		return null;
	}

}