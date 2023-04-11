# PROYECTO ADUANA -> WEBSERVICES + MVC
__________________________________________
## Descripción General:
Generar un web service bajo demanda el cual recibe los datos de una póliza/manifiesto de productos y los procese los datos calculando el valor del arancel según el valor del producto y marcar el paquete (verde/rojo) de manera aleatoria y genere un pdf el cual se envía por correo electrónico hacia logística.
__________________________________________

## Funcionalidades Necesarias

* Marcar paquetes (productos ingresados) de un color aleatorio [verde / rojo] 
* Definir el arancel de cada tipo de producto [5% - 15%]
    * Solicitar datos de los productos a tienda [Grupo Jonathan]
* Generar manifiesto de importación
    * Solicitar datos de póliza a Logística [Grupo k]
    
    ------------[DATOS - MANIFIESTO - RECIBIDO - ESENCIAL]----------
    - Nombre Persona - Cliente (comprador)
    - Descripción del producto
    - Valor del producto
* Enviar Manifiesto Procesado a por un web servicie a Logística
    * Generar Mail adjuntado PDF del manifiesto
    
    ------------[DATOS - MANIFIESTO - ENVIAR - ESENCIAL]----------
    - Nombre Persona - Cliente (comprador)
    - Descripción del producto
    - Valor del producto
    - Percentage
    - Aracel
__________________________________________

### Notas Adicionales:
Configuración de la variable BASE_URL -> ./system/config.php -> línea: 8 -> define('BASE_URL','TúDirectorio');
