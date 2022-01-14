create database lotoplusdb DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

use lotoplusdb;

/*
usuarios. Se almacenarán los datos de los usuarios registrados en la aplicación. Los datos relevantes para cada usuario serán:
======================================================
idusuario: Identificador de usuario (valor auto-incremental, clave primaria)
nombre: Nombre real del usuario
apellidos: Apellidos del usuario
nomusu: Nombre de usuario del usuario
clave: Contraseña (se debe almacenar encriptada, con la función password_hash() y comprobada con password_verify())
email: Email del usuario
tel: teléfono móvil del usuario
ganancias: Importe inicial de las ganancias del usuario en el momento de darse de alta en la plataforma
fechanac: Fecha de nacimiento
imgusu: Imagen de perfil del usuario
tipocu: Tipo de cuenta (Gratuita | Suscripción)
marketing: Permite marketing (S | N)
tipousu: Tipo de usuario (normal | administrador)
validada: Indica si la cuenta está validada (S | N)

*/
create table usuarios(
idusuario int unsigned primary key auto_increment,
nombre varchar(40) NOT NULL,
apellidos varchar(60) NOT NULL,
nomusu varchar(30) NOT NULL UNIQUE,
clave varchar(255) NOT NULL,
email varchar(100) NOT NULL,
tel varchar(9) NOT NULL,
ganancias decimal DEFAULT 0,
fechanac date NOT NULL,
imgusu varchar(200),
tipocu varchar(20) DEFAULT "Gratuita",
marketing char(1) DEFAULT "S",
tipousu char(1) DEFAULT "n",
validada char(1) DEFAULT 'N'
) engine=innodb;

/*
sorteos. Se almacenará la información de los sorteos
======================================================
idsorteo: Identificador de sorteo (valor auto-incremental, clave primaria)
nsorteo: Identificador público del sorteo. Será el identificador que se empleará en el documento XML que debe procesar la aplicación para gestionar las participaciones premiadas
fsorteo: Fecha en la que se celebra el sorteo
descrip: Descripción del sorteo

*/
create table draw(
draw_id int unsigned primary key auto_increment,
draw_number varchar(100) NOT NULL unique,
draw_date date NOT NULL,
info VARCHAR(300)
) engine=innodb;
/*
premios. Se almacenará la información de los premios
=====================================================
idpremio: Identificador del premio (valor auto-incremental, clave primaria)
idsorteo: Identificador de sorteo (clave ajena que apunta a la tabla sorteos)
numero: número premiado
premio: Importe correspondiente al número premiado, por euro (por ejemplo, si el premio es de 10 € por euro, a una participación de 5 € que resulte premiada,  le corresponderá un premio de 5x10 = 50€)

*/
create table prizes(
prize_id int unsigned primary key auto_increment,
draw_id int unsigned,
number int unsigned NOT NULL,
prize decimal DEFAULT 0,
FOREIGN KEY (draw_id) References sorteos(draw_id)
) engine=innodb;

/*
participaciones. Se almacenará la información de las participaciones de los usuarios (por simplificación, la información relevante de una participación será sólo el número, no teniendo en cuenta la serie ni la fracción)
=====================================================================================
idpart: Identificador de la participación (valor auto-incremental, clave primaria)
idprop: Identificador del usuario al que pertenece la participación (clave ajena que apunta a la tabla usuarios)
idsorteo: Identificador del sorteo al que pertenece la participación (clave ajena que apunta a la tabla sorteos)
numero: número de la participación (con la que se participa en el sorteo)
importe: Importe jugado en la participación
captura: Imagen (nombre del fichero) fotografiada o escaneada de la participación. El alumno puede decidir si aceptar distintos formatos o sólo uno (PDF, PNG, JPG, GIF, etc.)
*/
create table participations(
participation_id int unsigned primary key auto_increment,
user_id int unsigned NOT NULL,
draw_id int unsigned NOT NULL,
number int unsigned NOT NULL,
amount decimal DEFAULT 0,
snapshot VARCHAR(200),
FOREIGN KEY (user_id) References users(user_id),
FOREIGN KEY (draw_id) References draw(draw_id)
) engine=innodb;


