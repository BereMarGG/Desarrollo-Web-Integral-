--Tabla categoría
CREATE TABLE categoria(
       idcategoria INT PRIMARY KEY AUTO_INCREMENT,
       nombre VARCHAR(50) NOT NULL UNIQUE,
       descripcion VARCHAR(256),
       estado BIT DEFAULT(1)
);
INSERT INTO categoria (nombre, descripcion, estado)
VALUES
('Acuáticos', 'Vehículos diseñados para desplazarse sobre el agua, velocidad máxima de 100 km/h', 1),
('Aéreos', 'Vehículos capaces de volar, velocidad máxima de 900 km/h', 1),
('Eléctricos', 'Vehículos impulsados por baterías recargables, velocidad máxima de 150 km/h', 1),
('Pesados', 'Vehículos de gran tamaño para transporte de mercancías, velocidad máxima de 120 km/h', 1),
('Deportivos', 'Vehículos diseñados para alto rendimiento y velocidad, velocidad máxima de 400 km/h', 1),
('Todo Terreno', 'Vehículos capaces de circular en cualquier tipo de terreno, velocidad máxima de 200 km/h', 1),
('Agrícolas', 'Vehículos utilizados en actividades agrícolas, velocidad máxima de 60 km/h', 1),
('Motocicletas', 'Vehículos de dos ruedas para desplazamientos rápidos, velocidad máxima de 250 km/h', 1),
('Turismo', 'Vehículos diseñados para largas distancias y comodidad, velocidad máxima de 220 km/h', 1),
('Industriales', 'Vehículos utilizados en la industria para transporte o carga pesada, velocidad máxima de 80 km/h', 1);

SELECT * FROM categoria;

--Tabla artículo
CREATE TABLE articulo(
       idarticulo INT PRIMARY KEY AUTO_INCREMENT,
       idcategoria INT NOT NULL,
       codigo VARCHAR(50),
       nombre VARCHAR(100) not null unique,
       precio_venta DECIMAL(11,2) not null,
       stock INT NOT NULL,
       descripcion VARCHAR(256),
       estado bit DEFAULT(1),
       FOREIGN KEY (idcategoria) REFERENCES categoria(idcategoria)
);

INSERT INTO articulo (idcategoria, codigo, nombre, precio_venta, stock, descripcion, estado)
VALUES
(3, 'AQ-001', 'Lancha de Recreo', 500000.00, 5, 'Lancha pequeña para actividades recreativas en agua.', 1),
(3, 'AQ-002', 'Moto Acuática', 75000.00, 8, 'Moto de agua con capacidad para dos personas.', 1),
(3, 'AQ-003', 'Yate de Lujo', 1500000.00, 2, 'Yate de lujo con camarotes y sistema de navegación avanzada.', 1),

(4, 'AR-001', 'Helicóptero Ligero', 3000000.00, 2, 'Helicóptero para uso personal o empresarial.', 1),
(4, 'AR-002', 'Avión Ultraligero', 900000.00, 4, 'Avión pequeño para vuelos recreativos.', 1),
(4, 'AR-003', 'Drone Profesional', 12000.00, 10, 'Drone con cámara 4K y autonomía de vuelo de 30 minutos.', 1),

(5, 'EL-001', 'Auto Eléctrico', 450000.00, 7, 'Vehículo con motor eléctrico y autonomía de 400 km.', 1),
(5, 'EL-002', 'Patineta Eléctrica', 15000.00, 20, 'Patineta eléctrica con velocidad máxima de 25 km/h.', 1),
(5, 'EL-003', 'Monociclo Eléctrico', 20000.00, 12, 'Monociclo con motor eléctrico para movilidad urbana.', 1),

(6, 'PS-001', 'Tráiler de Carga', 2000000.00, 3, 'Vehículo pesado para transporte de mercancías.', 1),
(6, 'PS-002', 'Excavadora', 3500000.00, 2, 'Máquina para excavación de terrenos en construcción.', 1),
(6, 'PS-003', 'Bulldozer', 2800000.00, 1, 'Máquina pesada para movimiento de tierra.', 1),

(7, 'DP-001', 'Superdeportivo', 2000000.00, 1, 'Vehículo de lujo con motor de alto rendimiento.', 1),
(7, 'DP-002', 'Moto GP', 850000.00, 3, 'Motocicleta de competición con diseño aerodinámico.', 1),
(7, 'DP-003', 'Kart Profesional', 120000.00, 10, 'Kart para competencias en circuitos cerrados.', 1),

(8, 'TT-001', 'Jeep Wrangler', 800000.00, 5, 'Vehículo 4x4 ideal para caminos difíciles.', 1),
(8, 'TT-002', 'Camioneta ATV', 120000.00, 8, 'Vehículo todo terreno compacto para actividades recreativas.', 1),
(8, 'TT-003', 'Moto Enduro', 180000.00, 6, 'Motocicleta diseñada para terrenos irregulares.', 1),

(9, 'AG-001', 'Tractor', 500000.00, 3, 'Vehículo agrícola para labranza de tierras.', 1),
(9, 'AG-002', 'Cosechadora', 900000.00, 2, 'Máquina especializada en recolección de cosechas.', 1),
(9, 'AG-003', 'Arado', 50000.00, 15, 'Herramienta para preparar el terreno de cultivo.', 1),

(10, 'MC-001', 'Moto Urbana', 60000.00, 12, 'Motocicleta para desplazamientos en ciudad.', 1),
(10, 'MC-002', 'Moto Touring', 300000.00, 4, 'Motocicleta para viajes largos y cómodos.', 1),
(10, 'MC-003', 'Moto Deportiva', 250000.00, 6, 'Motocicleta de alto rendimiento y diseño aerodinámico.', 1),

(11, 'TR-001', 'Auto Sedán', 400000.00, 10, 'Vehículo cómodo para familias.', 1),
(11, 'TR-002', 'Minivan', 600000.00, 5, 'Vehículo espacioso para hasta 8 pasajeros.', 1),
(11, 'TR-003', 'Camper', 1200000.00, 3, 'Vehículo para viajes con equipamiento de camping.', 1),

(12, 'IN-001', 'Montacargas', 500000.00, 6, 'Vehículo industrial para carga y descarga.', 1),
(12, 'IN-002', 'Plataforma Elevadora', 750000.00, 3, 'Equipo para trabajos en alturas.', 1),
(12, 'IN-003', 'Camión Cisterna', 1300000.00, 2, 'Camión especializado para transporte de líquidos.', 1);

--Tabla persona
create table persona(
       idpersona INT PRIMARY KEY AUTO_INCREMENT,
       tipo_persona VARCHAR(20) NOT NULL,
       nombre VARCHAR(100) NOT NULL,
       tipo_documento VARCHAR(20),
       num_documento VARCHAR(20),
       direccion VARCHAR(70),
       telefono VARCHAR(20),
       email VARCHAR(50)
);

--Tabla rol
create table rol(
       idrol INT PRIMARY KEY AUTO_INCREMENT,
       nombre VARCHAR(30) NOT NULL,
       descripcion VARCHAR(100),
       estado BIT DEFAULT(1)
);

INSERT INTO rol (nombre, descripcion)
VALUES('ADMIN', 'Usuario de tipo administrador con permisos para modificar cualquier cosa de la página.'),
('CLIENTE', 'Usuario de tipo cliente con los permisos básicos para poder navegar por la página');

--Tabla usuario
create table usuario(
       idusuario INT PRIMARY KEY AUTO_INCREMENT,
       idrol INT NOT NULL,
       nombre VARCHAR(100) NOT NULL,
       tipo_documento VARCHAR(20),
       num_documento VARCHAR(20),
       direccion VARCHAR(70),
       telefono VARCHAR(20),
       email VARCHAR(50) NOT NULL,
       password VARCHAR(255) NOT NULL,
       estado BIT DEFAULT(1),
       FOREIGN KEY (idrol) REFERENCES rol (idrol)
);

--Tabla ingreso
create table ingreso(
       idingreso INT PRIMARY KEY AUTO_INCREMENT,
       idproveedor INT NOT NULL,
       idusuario INT NOT NULL,
       tipo_comprobante VARCHAR(20) NOT NULL,
       serie_comprobante VARCHAR(7),
       num_comprobante VARCHAR(10) NOT NULL,
       fecha DATETIME NOT NULL,
       impuesto DECIMAL(4,2) NOT NULL,
       total DECIMAL(11,2) NOT NULL,
       estado VARCHAR(20) NOT NULL,
       FOREIGN KEY (idproveedor) REFERENCES persona (idpersona),
       FOREIGN KEY (idusuario) REFERENCES usuario (idusuario)
);

--Tabla detalle_ingreso
create table detalle_ingreso(
       iddetalle_ingreso INT PRIMARY KEY AUTO_INCREMENT,
       idingreso INT NOT NULL,
       idarticulo INT NOT NULL,
       cantidad INT NOT NULL,
       precio DECIMAL(11,2) NOT NULL,
       FOREIGN KEY (idingreso) REFERENCES ingreso (idingreso) ON DELETE CASCADE,
       FOREIGN KEY (idarticulo) REFERENCES articulo (idarticulo)
);

--Tabla venta
create table venta(
       idventa INT PRIMARY KEY AUTO_INCREMENT,
       idcliente INT NOT NULL,
       idusuario INT NOT NULL,
       tipo_comprobante VARCHAR(20) NOT NULL,
       serie_comprobante VARCHAR(7),
       num_comprobante VARCHAR(10) NOT NULL,
       fecha_hora DATETIME NOT NULL,
       impuesto DECIMAL(4,2) NOT NULL,
       total DECIMAL(11,2) NOT NULL,
       estado VARCHAR(20) NOT NULL,
       FOREIGN KEY (idcliente) REFERENCES persona (idpersona),
       FOREIGN KEY (idusuario) REFERENCES usuario (idusuario)
);

--Tabla detalle_venta
create table detalle_venta(
       iddetalle_venta INT PRIMARY KEY AUTO_INCREMENT,
       idventa INT NOT NULL,
       idarticulo INT NOT NULL,
       cantidad INT NOT NULL,
       precio DECIMAL(11,2) NOT NULL,
       descuento DECIMAL(11,2) NOT NULL,
       FOREIGN KEY (idventa) REFERENCES venta (idventa) ON DELETE CASCADE,
       FOREIGN KEY (idarticulo) REFERENCES articulo (idarticulo)
);

DELIMITER //

CREATE TRIGGER after_usuario_insert
AFTER INSERT ON usuario
FOR EACH ROW
BEGIN
    INSERT INTO persona (idpersona, tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, email)
    VALUES (NEW.idusuario, 'Cliente', NEW.nombre, NEW.tipo_documento, NEW.num_documento, NEW.direccion, NEW.telefono, NEW.email);
END;
//

DELIMITER ;


INSERT INTO venta (idcliente, idusuario, tipo_comprobante, serie_comprobante, num_comprobante, fecha_hora, impuesto, total, estado)
VALUES (5, 5, 'FACTURA', 'A001', '123456', '2024-11-25 08:59:35', 0.18, 600000, 'PENDIENTE');


//SUBIR LA BD A GITHUB