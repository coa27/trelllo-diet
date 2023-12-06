<?php

$rutas = explode("/", $_SERVER['REQUEST_URI']);
$rutas = array_filter($rutas);

switch ($rutas[2]) {

	/*********
		TABLEROS
		********/
	case "tableros":

		/*********
		TABLEROS ESPECIFICOS
		********/
		if (isset($rutas[3])) {

			/*********
			METODOS HTTP
			********/
			switch ($_SERVER["REQUEST_METHOD"]) {
				case "DELETE":
					$service = new TablerosService();
					$service->eliminarTablero($rutas[3]);

					$json = array(
						"statusCode" => "204",
						"detalle" => "Tablero eliminado"
					);
				
					echo json_encode($json, http_response_code($json["statusCode"]) );

					return;
				case "GET":
					$service = new TablerosService();
					$tablero = $service->obtenerTablero( $rutas[3] );

					$json = array(
						"statusCode" => "200",
						"detalle" => $tablero
					);
				
					echo json_encode($json, http_response_code($json["statusCode"]) );
					return;

				default: 
					$json = array(
						"statusCode" => "400",
						"detalle" => "ESTAS EN EL TABLERO " . $rutas[3] . " y no hay soporte para este metodo"
					);
				
					echo json_encode($json, http_response_code($json["statusCode"]) );
					return;

			}
		}


		/*********
		TABLEROS GENERAL 
		
		METODOS HTTP
		********/
		switch ($_SERVER["REQUEST_METHOD"]) {
			case "POST":

				$tablero = $_POST["nombre"];
				$service = new TablerosService();
				$tablero = $service->crearTablero($tablero);

				$json = array(
					"statusCode" => "201",
					"detalle" => $tablero
				);
			
				echo json_encode($json, http_response_code($json["statusCode"]) );
				return;

			case "GET":
				$service = new TablerosService();
				$tableros = $service->obtenerTableros();

				$json = array(
					"statusCode" => "200",
					"detalle" => $tableros
				);
			
				echo json_encode($json, http_response_code($json["statusCode"]) );
				return;

			case "PUT":
				$datos = file_get_contents("php://input");
				$datos = json_decode($datos, true);
				$tablero = array(
					"id_tablero"=> $datos["id_tablero"],
					"nombre"=> $datos["nombre"]
				);

				$service = new TablerosService();
				$tableros = $service->actualizarTablero($tablero);


				$json = array(
					"statusCode" => "200",
					"detalle" => $tableros
				);
			
				echo json_encode($json, http_response_code($json["statusCode"]) );
				return;
			default: 
				$json = array(
					"statusCode" => "404",
					"detalle" => "ESTAS EN TABLEROS Y NO HAY SOPORTE PARA ESE METODO"
				);
			
				echo json_encode($json, http_response_code($json["statusCode"]) );
				return;
		}

	/*********
		TAREAS
		********/
	case "tareas":
		if (isset($rutas[3])){

		} else{

			$json = array(
				"statusCode" => "400",
				"detalle" => "URL incorrecta. vuelve a verificarla"
			);
		
			echo json_encode($json, http_response_code($json["statusCode"]) );
			return;

		}
		return;

	/*********
	AUTH
	********/
	case "auth":
		switch ($_SERVER["REQUEST_METHOD"]) {
			case "POST":

				switch( $rutas[3] ) {
					case "registro":
						$datos = file_get_contents("php://input");
						$datos = json_decode($datos, true);
						$usuario = array(
							"email"=> $datos["email"],
							"apodo"=> $datos["apodo"],
							"password"=> $datos["password"],
							"imagen_url"=> $datos["imagen_url"],
						);
		
		
						$service = new AuthService();
						$usuario = $service->regitrarUsuario($usuario);
		
						$json = array(
							"statusCode" => "201",
							"detalle" => $usuario
						);
					
						echo json_encode($json, http_response_code($json["statusCode"]) );
						return;
					case "acceder":
						$datos = file_get_contents("php://input");
						$datos = json_decode($datos, true);
						$usuario = array(
							"email"=> $datos["email"],
							"password"=> $datos["password"],
						);

						$service = new AuthService();
						$valor = $service->acceder($usuario);
						if ($valor){
							$json = array(
								"statusCode" => "200",
								"detalle" => "login exitoso"
							);
						
							echo json_encode($json, http_response_code($json["statusCode"]) );
							return ;
						}
						$json = array(
							"statusCode" => "401",
							"detalle" => "Credenciales erroneas"
						);
					
						echo json_encode($json, http_response_code($json["statusCode"]) );
						return;
					default:
						return;
				}
			default:
				$json = array(
					"statusCode" => "404",
					"detalle" => "NO HAY SOPORTE PARA EL METODO QUE INTENTAS ACCEDER EN LA SECCION DE AUTH"
				);
				
				echo json_encode($json, http_response_code($json["statusCode"]) );
				return;
		}

	default: 
		$json = array(
			"statusCode" => "404",
			"detalle" => "NOT FOUND"
		);
		
		echo json_encode($json, http_response_code($json["statusCode"]) );

}