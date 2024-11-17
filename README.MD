
# Documentación

## Resumen
Esta API provee información sobre los vehículos de una tienda de autos de lujo. Los usuarios de esta API podrán consultar los vehículos disponibles, así como agregar modelos, agregar vehículos y actualizar estos últimos.

## Cómo instalar

1) Descargar y descomprimir la carpeta comprimida en la carpeta htdocs de XAMPP.

2) Iniciar XAMPP e ir a TPE-WEB-III-main. El modelo se encargará de crear la base de datos si no existe, y llenarla con los datos necesarios si está vacía.


## URL BASE
http://localhost/TPE-WEB-III-main/api

## Endpoints

### 1. Listar todos los vehículos.
**Descripción**: Lista todos los vehículos disponibles.

**Método**: `GET`

**Endpoint**: `/vehicle`

**Ejemplo de uso**:

`http://localhost/TPE-Web-Parte-III-main/api/vehicle`

**Respuesta**:
```json
[
    {
        "AutoId": 1,
        "Marca": "Marca1",
        "ModeloId": 1,
        "Kilometraje": 0,
        "Precio": "230000.00",
        "Nombre": "Modelo1",
        "Anio": 2020,
        "Capacidad": 2,
        "Combustible": "Gasolina"
    },
    {
        "AutoId": 2,
        "Marca": "Marca2",
        "ModeloId": 2,
        "Kilometraje": 3000,
        "Precio": "230000.00",
        "Nombre": "Modelo2",
        "Anio": 2020,
        "Capacidad": 2,
        "Combustible": "Gasolina"
    }
]
```

### 2. Obtener un vehículo por su id.
**Descripción**: Obtiene un vehículo por su número de ID.

**Método**: `GET`

**Endpoint**: `/vehicle/:id`

**Parámetros**:
| Nombre |  Tipo  |        Descripción         | Requerido |
|--------|--------|----------------------------|-----------|
|   id   |  int   | Número de ID del vehículo  | Sí        |

**Ejemplo de uso**:

`http://localhost/TPE-Web-Parte-III-main/api/vehicle/2`

**Respuesta**:
```json
{
    "AutoId": 2,
    "Marca": "Marca2",
    "ModeloId": 2,
    "Kilometraje": 3000,
    "Precio": "220000.00",
    "Nombre": "Modelo2",
    "Anio": 2020,
    "Capacidad": 2,
    "Combustible": "Gasolina"
}
```

**Mensajes de error**:
* ***ID inválido*** `(400 Bad Request)`
```json
{
  "message:" "El parámetro id sólo acepta números enteros."
}
```
Si no se especifica un valor entero en el campo ID, la API retornará este mensaje.


### 3. Agregar un vehículo.
**Descripción**: Agrega un vehículo a la base de datos.

**Método**: `POST`

**Endpoint**: `/vehicle`

**Ejemplo de uso**: `http://localhost/TPE-Web-Parte-III-main/api/vehicle`

**Body**:
```json
{
    "marca": "Marca2",
    "modelo": "Modelo2",
    "kilometraje": 0,
    "precio": 100000.00
}
```

**Respuesta**:
```json
{
  "message": "Vehículo agregado"
}
```

**Mensajes de error**:

* ***Campo sin completar*** `(400 Bad Request)` 
```json
{
  "message": "Falta el campo marca/modelo/kilometraje/precio."
}
```
Al agregar un vehículo, deben completarse todos los campos. De otro modo, se mostrará un mensaje de acuerdo a lo que falte completar.


* ***Valor de kilometraje inválido*** `(400 Bad Request)` 
```json
{
  "message": "El campo kilometraje sólo acepta el 0 (cero) y números enteros positivos"
}  
```
El campo "kilometraje" sólo acepta como valores el 0 (cero) y números enteros positivos.


* ***Valor de precio inválido*** `(400 Bad Request)`
```json
{
  "message": "El campo precio sólo acepta números enteros o de coma flotante positivos"
}  
```
El campo "precio" sólo acepta como valores el 0 (cero), y números enteros o de coma flotante positivos.


* ***Valores negativos en kilometraje y/o precio*** `(400 Bad Request)`
```json
{
  "message": "No se permiten valores negativos en el campo kilometraje/precio"
}
```
Ambos campos requieren valores positivos.


* ***El modelo no existe*** `(400 Bad Request)`

```json
{
  "message": "No se puede agregar el vehículo; El modelo especificado (ejemplo_modelo) no existe."
}
```
Si se desea agregar un nuevo vehículo con un nuevo modelo, se debe primero agregar el modelo y luego el vehículo asociado a dicho modelo.


### 4. Agregar un modelo
**Descripción**: Añade un nuevo modelo de vehículo a la base de datos.

**Método**: `POST`

**Endpoint**: `/model`

**Ejemplo de uso**: `http://localhost/TPE-Web-Parte-III-main/api/model`

**Body**:
```json
{
    "nombre": "Modelo3",
    "anio": 2024,
    "capacidad": 2,
    "combustible": "Gasolina"
}
```

**Respuesta**:

```json
{
  "message": "Modelo agregado"
}
```

**Mensajes de error**:

*  ***Campo sin completar***  `(400 Bad Request)`
```json
{
  "message": "Falta el campo nombre/anio/capacidad/combustible"
}
```
Al agregar un modelo, deben completarse todos los campos. De otro modo, se mostrará un mensaje de acuerdo a lo que falte completar.

* ***Valor de anio/capacidad inválido*** `(400 Bad Request)`
```json
{
  "message": "El campo anio/capacidad sólo acepta el 0 (cero) y números enteros positivos"
}
```
Los campos anio y capacidad sólo aceptan el 0 (cero) y números enteros positivos.

* ***Valor de año mayor a la fecha actual o menor a 1880*** `(400 Bad Request)`
```json
{
  "message": "El campo anio no acepta valores superiores a (Año actual) o inferiores a 1880."
}
```
El campo anio no acepta años en el futuro, así como tampoco acepta años inferiores a 1880 (Año cercano al primer automóvil patentado)

* ***Valor de capacidad menor a 1*** `(400 Bad Request)`
```json
{
  "message":"No se permiten valores menores a 1 en el campo capacidad."
}
```
El campo capacidad representa los asientos que posee el vehículo. Por esa razón, no se permiten valores menores a 1.

* ***El modelo ya existe*** `(400 Bad Request)`
```json
{
  "message":"El modelo especificado (ejemplo_modelo) ya existe."
}
```
Si se intenta ingresar un modelo que ya existe en la base de datos, se mostrará este mensaje. Se debe tener en cuenta que la API no maneja el campo nombre de manera case sensitive.

## Autores: Nikos Lettos, Juan Martín López