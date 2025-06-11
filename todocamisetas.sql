-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS todocamisetas;
USE todocamisetas;

-- Tabla de clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_comercial VARCHAR(100) NOT NULL,
    rut_id VARCHAR(50) NOT NULL,
    direccion VARCHAR(150) NOT NULL,
    categoria ENUM('Regular','Preferencial') NOT NULL,
    contacto VARCHAR(100) NOT NULL,
    porcentaje_oferta DECIMAL(5,2) NOT NULL
);

-- Tabla de camisetas
CREATE TABLE camisetas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    club VARCHAR(100) NOT NULL,
    pais VARCHAR(50) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    color VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    tallas_disponibles TEXT, -- Se almacenarán en formato JSON
    detalles TEXT,
    codigo_producto VARCHAR(50) NOT NULL,
    precio_oferta DECIMAL(10,2),
    cliente_id INT, -- Opcional, si deseas relacionar directamente con un cliente
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- Tabla de tallas
CREATE TABLE tallas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Si existe una relación muchos a muchos entre camisetas y tallas, puedes crear una tabla pivote:
CREATE TABLE camisetas_tallas (
    camiseta_id INT,
    talla_id INT,
    PRIMARY KEY (camiseta_id, talla_id),
    FOREIGN KEY (camiseta_id) REFERENCES camisetas(id) ON DELETE CASCADE,
    FOREIGN KEY (talla_id) REFERENCES tallas(id) ON DELETE CASCADE
);
