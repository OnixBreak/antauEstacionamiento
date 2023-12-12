--Estas son las lineas que utilicé para crear la base de datos.--

CREATE TABLE usuarios (
  'id' int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  'usuario' varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  'pass' varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  'nombreCompleto' varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  'cargo' varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  'fecha_registro' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE entradas (
  'folio_entradas' int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  'empleado_registro' varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  'fecha_entrada' date NOT NULL,
  'hora_entrada' time NOT NULL,
  'color_marca' varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  'placa' varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  'tipo_vehiculo' varchar(1) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE salidas (
  'id_consecutivo' int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  'folio_entrada' int NOT NULL,
  'atendio' varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  'usuario_cobro' varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  'fecha_entrada' varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  'hora_entrada' varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  'color_marca' varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  'placas' varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  'tipo_vehiculo' varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  'salida' varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  'total' int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE cortes (
  'id_corte' int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  'usuario_corte' varchar(50) NOT NULL,
  'fecha_corte' varchar(25) NOT NULL,
  'hora_corte' varchar(25) NOT NULL,
  'autos_ingresados' int NOT NULL,
  'dinero_corte' int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE respaldo (
  'id_respaldo' int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  'res_id_folio' int NOT NULL,
  'fecha_registro' varchar(15) NOT NULL,
  'res_hora_entrada' varchar(15) NOT NULL,
  'res_hora_salida' varchar(15) NOT NULL,
  'res_usuario_ingreso' varchar(25) NOT NULL,
  'res_usuario_cobro' varchar(25) NOT NULL,
  'res_placas' varchar(25) NOT NULL,
  'res_color_marca' varchar(40) NOT NULL,
  'res_tipo' varchar(2) NOT NULL,
  'res_cobrado' int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



