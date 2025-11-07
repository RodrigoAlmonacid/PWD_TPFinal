Base de datos para el TP final: nombre= 'baseTPFinal'

CREATE TABLE usuario(
    id_usuario bigint(20) AUTO_INCREMENT PRIMARY KEY,
    nom_usuario varchar(50) NOT NULL,
    pass_usuario varchar(255) NOT NULL,
    email_usuario varchar(50) NOT NULL,
    desHabilitado_usuario timestamp
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE rol(
    id_rol bigint(20) AUTO_INCREMENT PRIMARY KEY,
    descripcion_rol varchar(50) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE usuariorol(
    id_usuario bigint(20),
    id_rol bigint(20),
    PRIMARY KEY(id_usuario, id_rol),
    FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    FOREIGN KEY(id_rol) REFERENCES rol(id_rol)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE menu(
    id_menu bigint(20) AUTO_INCREMENT PRIMARY KEY,
    nom_menu varchar(50) NOT NULL,
    descripcion_menu varchar(128) NOT NULL,
    id_padre bigint(20) NOT NULL,
    desHabilitado_menu timestamp
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE menurol(
    id_menu bigint(20),
    id_rol bigint(20),
    PRIMARY KEY(id_menu, id_rol),
    FOREIGN KEY(id_menu) REFERENCES menu(id_menu)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    FOREIGN KEY(id_rol) REFERENCES rol(id_rol)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE compra(
    id_compra bigint(20) AUTO_INCREMENT PRIMARY KEY,
    fecha_compra timestamp NOT NULL,
    id_usuario bigint(20),
    FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE producto(
    id_producto bigint(20) AUTO_INCREMENT PRIMARY KEY,
    nom_producto varchar(512) NOT NULL,
    stock_producto int(11) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE compraitem(
    id_compraitem bigint(20) AUTO_INCREMENT PRIMARY KEY,
    id_producto bigint(20),
    id_compra bigint(20),
    cantidad_compraitem int(11) NOT NULL,
    FOREIGN KEY(id_producto) REFERENCES producto(id_producto)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    FOREIGN KEY(id_compra) REFERENCES compra(id_compra)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE compraestadotipo(
    id_compraestadotipo bigint(20) AUTO_INCREMENT PRIMARY KEY,
    descripcion_compratipo varchar(50) NOT NULL,
    detalle_compratipo varchar(255) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE compraestado(
    id_compraestado bigint(20) PRIMARY KEY,
    id_compra bigint(20),
    id_compraestadotipo bigint(20),
    fecha_inicio timestamp NULL DEFAULT NULL,
    fecha_fin timestamp  NULL DEFAULT NULL,
    FOREIGN KEY(id_compraestadotipo) REFERENCES compraestadotipo(id_compraestadotipo)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    FOREIGN KEY(id_compra) REFERENCES compra(id_compra)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;