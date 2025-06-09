Manual de uso de la página web:
1. Se debe pegar el proyecto (La carpeta: Pagina) en la carpeta htdocs de Xamp.
2. Se deben de sustituir algunos de los archivos de configuración, para de esta manera permitir el envio de correos:
	- En la carpeta del proyecto, se encuentra una carpeta llamada "ArchivosDeConfiguraciónXampp", en ella hay dos archivos de configuración.
	- Se debe de sustituir el archivo de php.ini de esta carpeta, por el archivo de configuración de xampp situado en
	  /xampp/php/php.ini. Y lo mismo con sendmail.ini, por el archivo de configuración de xampp situado en /xampp/sendmail/sendmail.ini.
Una vez tengamos el entorno preparado, iniciamos los servicios de apache y MySQL de xampp. 
Importante, el correo de empresa del taller es turboenginework@gmail.com y su contraseña _a91403002T.
3. Impoortar la base de datos a MyPhpAdmin, el archivo SQL se encuentra en la carpeta "BaseDatos" del proyecto.

Para acceder a la web, abrimos un navegador y en la barra superior escribimos la siguiente url "http://localhost/pagina/front/admin.php",
esto nos llevará al index de la web.

Usuario AdminMikel, contraseña mikel-03.

Ahora que estamos en el index, podemos navegar para conocer el taller. En el menu superior encontraremos la opción de iniciar sesión.
Primero accederemos a la página con el usuario AdminMikel, ya que cuando un administrador accede a la web, se ejecuta el script que genera las citas. 
El programa esta pensado para que se generen las citas cuando un administrador accede a la web, pero esta condiciónado para que solo se generen las
citas los días 15 o superior, la fecha esta programa como 15 de junio para que de esta manera se generen las citas.
Ahora que ya hemos generado las citas en la base de datos, cerramos sesión. Para ello encontraremos el botón en el menú superior.
Volveremos al login y encontremos una opción para registrarnos, se rellena el formulario y se creará el nuevo usuario en la base de datos. Una vez
nos registramos, nos devuelve al login y podemos iniciar sesión con nuestro usuario recien creado.

Visión cliente:
Al iniciar sesión nos encontraremos el mismo index, pero con tres opciones nuevas en el menú superior "citas", "presupuestos" y "perfil":
	- Citas: En citas podemos reservar las citas que se encuentren disponibles mediante los select.
	- Presupuestos: Podemos solicitar presupuestos, rellenando los campos del formulario.
Ahora podremos consultar las citas y presupuestos solicitados desde nuestro perfil. Para ello accedemos al apartado de perfil y encontraremos dos botones
"ver mis citas" y "ver mis presupuestos":
	- En mis citas, nos encontraremos un tabla con todas las citas que hayamos solicitado, junto a un botón que nos permitirá cancelar la cita que deseemos.
	- En mis presupuestos, encontraremos una tabla con los presupuestos que hayamos solicitado. Si el presupuesto a sido respondido por un administrador,
	  nos encontraremos un botón para ver el PDF del presupuesto.
Volviendo al apartado de "perfil", debajo de los botones "ver mis citas" y "ver mis presupuestos", encontraremos un formulario el cual nos permite
modificar datos de nuestro usuario.

Visión administrador:
Volveremos a iniciar sesión como administradores, para ello usamos el usuario AdminMikel con contraseña mikel-03. 
En el panel del administrador encontraremos las siguientes opciones en el menú superior "gestión usuarios", "gestión citas" y "gestión presupuestos":
	- Gestión Usuario, según entremos nos encontraremos una tabla con todos los usuarios que esten registrados en la web, junto a un botón
	  el cual nos permite borrar la cuenta de ese usuario. Si el usuario es borrado por el admin, se mandará un correo al cliente, informandole
	  que su usuario ha sido borrado.
	- Gestión Citas, nos muestra una tabla con todas las citas solicitadas por los diferentes usuarios, junto a un botón por si deseamos cancelar
	  alguna cita. Si la cita es cancelada por el admin, se envía un correo al cliente notificándole.
	- Gestion Presupuestos, una vez más muestra una tabla con todos los presupuestos solicitados por los usuarios, junto a dos botones "eliminar"
	  y "responder". Si eliminamos el presupuesto, se envía un correo al cliente para notificarle y si respondemos, nos lleva a un formulario
	  el cual nos permite responder al presupuesto del cliente, una vez enviado el formulario, se envía un correo al cliente, para notificarle
	  de que su presupuesto ya ha sido respondido.

Por último podemos volver a logearnos como cliente, para acceder al apartado de "Ver mis presupuestos", ya que ahora que el admin nos ha respondido el 
presupuesto, encontraremos el botón activo para ver el pdf del presupuesto.
