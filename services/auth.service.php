<?php


class AuthService{

	public function regitrarUsuario($usuario) {
		$usuarioRegistrado = Auth::RegistrarUsuario($usuario);
		Roles::agregarUsuario($usuarioRegistrado["id_usuario"]);
		return $usuarioRegistrado;
	}

	public function acceder($usuario) {
		$usuarioRegistrado = Auth::accederUsuario($usuario);
		if ($usuarioRegistrado != null && password_verify($usuario["password"], $usuarioRegistrado["password"])) {
			return true;
		}
		return false;
			
	}

}