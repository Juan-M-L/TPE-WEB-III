-- Tabla Modelo.
CREATE TABLE Modelo (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL UNIQUE,
    Anio INT NOT NULL,
    Capacidad INT NOT NULL,
    Combustible VARCHAR(50) NOT NULL
);

-- Tabla Auto.
CREATE TABLE Auto (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Marca VARCHAR(50) NOT NULL,
    ModeloId INT NOT NULL,
    Kilometraje INT NOT NULL,
    Precio NUMERIC(10,2) NOT NULL
);

ALTER TABLE Auto
ADD FOREIGN KEY (ModeloId)
REFERENCES Modelo(Id);

-- Tabla Usuario
CREATE TABLE Usuario (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(255) UNIQUE NOT NULL,
    Contrasenia CHAR(60) NOT NULL
);


-- Inserción de datos en Modelo
INSERT INTO Modelo (Nombre, Anio, Capacidad, Combustible) VALUES
('488 GTB', 2020, 2, 'Gasolina'),
('Portofino', 2021, 4, 'Gasolina'),
('Huracan', 2020, 2, 'Gasolina'),
('Aventador', 2021, 2, 'Gasolina'),
('Panamera', 2022, 4, 'Híbrido'),
('Taycan', 2023, 4, 'Eléctrico'),
('Continental GT', 2020, 4, 'Gasolina'),
('Flying Spur', 2022, 4, 'Gasolina');


-- Inserción de datos en Auto
INSERT INTO Auto (Marca, ModeloId, Kilometraje, Precio) VALUES
('Ferrari', 1, 5000, 250000.00),
('Ferrari', 2, 3000, 220000.00),
('Ferrari', 1, 1000, 230000.00),
('Ferrari', 2, 200, 500000.00),
('Ferrari', 1, 1500, 270000.00),
('Lamborghini', 3, 4000, 200000.00),
('Lamborghini', 4, 2500, 400000.00),
('Lamborghini', 3, 10000, 220000.00),
('Lamborghini', 4, 500, 350000.00),
('Lamborghini', 3, 8000, 180000.00),
('Porsche', 5, 6000, 150000.00),
('Porsche', 6, 12000, 80000.00),
('Porsche', 5, 3000, 120000.00),
('Porsche', 6, 500, 130000.00),
('Porsche', 5, 7000, 90000.00),
('Bentley', 7, 4000, 220000.00),
('Bentley', 8, 8000, 180000.00),
('Bentley', 7, 3000, 250000.00),
('Bentley', 8, 10000, 300000.00),
('Bentley', 7, 200, 400000.00);

-- Inserción de datos en Usuario
INSERT INTO Usuario (Nombre, Contrasenia) VALUES
("webadmin", "$2y$10$jdxoVOfYq4YCF0T5vZzMA.pNvZR740p2Gh7vHuKRPBtfEPsWRPESy"),
("lautaro", "$2y$10$G.gksJ1/efgFSCfFtkqdT.AcApAKlT.ZqfVvp/lk4TXGQ5BqncCaa"),
("maria", "$2y$10$o4djgrVe5jZUYtp4dGDJ5ORnpU/NZ3AazVCX9ZuVjjiBnAoZyoaie"),
("lucas", "$2y$10$GHq10SylWH0r6GgVCmL/besES7bkBV9Ip0xbrfRfHG1BTNY9EaA2y");
--Contraseñas:
--webadmin -> admin
--lautaro -> 1234
--maria -> 1234
--lucas -> 1234
