NuvolaProyect
Problema Propuesto Por la empresa Nuvola<br>
NOTA: Archivo de postman anexado en el proyecto 'PruebaProyecto.postman_collection.json'
<h3>Desarrollado por Jose Acevedo </h3>
<h5> Peticiones </h5>
 <h5>Crud de Personas:</h5><br>
 Create Persona: 'http://**/api/persona'
        <h5>Parametros</h5>
        <ul>
            <li>nombre</li>
            <li>apellido</li>
            <li>email</li>
            <li>direccion</li>
            <li>telefono</li>
        </ul>
        <h5>Metodo: </h5><i> POST </i>
        <br>
        Read Persona: 'http://**/api/persona/*id*'
        <h5>Parametros</h5>
        <ul>
            <li>id</li>
        </ul>
        <h5>Metodo: </h5><i> GET </i>
        <br>
        Update Persona: 'http://**/api/persona/*id*'
        <h5>Parametros</h5>
        <ul>
            <li>id</li>
            <li>nombre</li>
            <li>apellido</li>
            <li>email</li>
            <li>direccion</li>
            <li>telefono</li>
        </ul>
        <h5>Metodo: </h5><i> PUT </i>
        Delete Persona: 'http://**/api/persona/*id*'
        <h5>Parametros</h5>
        <ul>
            <li>id</li>
        </ul>
        <h5>Metodo: </h5><i> DELETE </i>   
    <h5>Filtros de Personas:</h5><br>
        Filtrar Persona por email: 'http://**/api/persona/searchBy/email'
        <h5>Parametros</h5>
        <ul>
            <li>value = 'email'</li>
        </ul>
        <h5>Metodo: </h5><i> GET </i>
        <br>
        Filtrar Persona por nombres: 'http://**/api/persona/searchBy/nombres'
        <h5>Parametros</h5>
        <ul>
            <li>value = 'nombre o apellido'</li>
        </ul>
        <h5>Metodo: </h5><i> GET </i>
        <br>
        Filtrar Persona por rango de fecha de creacion con respecto a a la actual: 'http://**/api/persona/searchBy/created'
        <h5>Parametros</h5>
        <ul>
            <li>fecha</li>
        </ul>
        <h5>Metodo: </h5><i> GET </i>
        <br>
    <h5>XML Para Vuelos:</h5><br>
        Create Vuelo: 'http://**/api/vuelo'
        <h5>Parametros</h5>
        <ul>
            <li>fecha_viaje</li>
            <li>pais</li>
            <li>ciudad</li>
            <li>email</li>
        </ul>
        <h5>Metodo: </h5><i> POST </i>
        <h5>Content-type: </h5><i> Aplication/XML </i>
        <br>
    <h5>Listado de vuelos:</h5><br>
        Read vuelo de x persona: 'http://**/api/vuelo/'
        <h5>Parametros</h5>
        <ul>
            <li>sin parametros</li>
        </ul>
        <h5>Metodo: </h5><i> GET </i>
        <br>
        Read vuelo de x persona: 'http://**/api/vuelo/listar/*email*'
        <h5>Parametros</h5>
        <ul>
            <li>email</li>
        </ul>
        <h5>Metodo: </h5><i> GET </i>
        <br>
   Formato XML:
        
            <?xml version="1.0"?>
            <Persona>
                <Vuelo>
                    <fecha_viaje>06/09/2019</fecha_viaje>
                    <pais>Colombia</pais>
                    <ciudad>Barranquilla</ciudad>
                    <email>amoen@example.net</email>
                </Vuelo>
                <Vuelo>
                    <fecha_viaje>06/09/2019</fecha_viaje>
                    <pais>Colombia</pais>
                    <ciudad>Barranquilla</ciudad>
                    <email>amoen@example.net</email>
                </Vuelo>
                <Vuelo>
                    <fecha_viaje>06/09/2019</fecha_viaje>
                    <pais>Colombia</pais>
                    <ciudad>Barranquilla</ciudad>
                    <email>amoen@example.net</email>
                </Vuelo>
            </Persona>
   
