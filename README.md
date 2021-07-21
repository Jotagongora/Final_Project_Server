# Red Social Gamimg

El proyecto trata sobre una red social en la que compartir publiacaciones sobre juegos a los que estés jugando en el momento o hayas jugado previamente, dar tu opinión a otros
jugadores y subir fotos sobre tus partidas. ¡Comparte tu sabiduría con los demás que seguro te lo agradecerán!.

## Comenzando 🚀

_Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas._

Mira **Instalación** para conocer como desplegar el proyecto.


### Advertencia 📋

_Estas indicaciones te aseguran el funcionamiento en Linux, si tu sistema operativo es otro algún punto puede variar.
Necesitarás PHP 7.2.5 o superior y Composer._

### Instalación 🔧

_1: Instalar XAMPP/LAMP/MAMP._

_2: Instalar Symfony CLI para hacerlo más sencillo y el gestor de paquetes composer._

```
wget https://get.symfony.com/cli/installer -O - | bash
```

_3: Clonar el repositorio del proyecto._

```
git clone https://github.com/Jotagongora/Final_Project_Server.git
```
_4: Actualizar las dependencias._

```
composer update
```
```
composer install
```
_5: Una vez hecho esto, crear un archivo .env.local en la raíz del proyecto y copia lo siguiente._

```
Final_Project_Server/.env.local
```
```
DATABASE_URL="mysql://tu_usuario_xamp:tu_contraseña@127.0.0.1:3306/tu_base_de_datos?serverVersion=5.7"
```
_6: Crea la base de datos y sincronizala con el proyecto._

```
symfony console doctrine:database:create
```

```
symfony console doctrine:migrations:migrate
```
_7: Instalar lexik._

```
composer require lexik/jwt-authentication-bundle
```
```
symfony console lexik:jwt:generate-keypair
```
_8: Para finalizar ejecuta el siguiente comando para inciar el servidor._

```
symfony serve -d
```

## Construido con 🛠️

* [LexikJWT]
* [Symfony 5]

## Autores ✒️

_Quería mencionar a las siguientes personas, ya que sin ellas no podría haber empezado este proyecto._

* **Zacarías Calabría** - *Mentor de PHP y Symfony* -
* **Jesús Álvarez** - *Mentor en general sobre todo el mundillo de desarrollo web*


## Expresiones de Gratitud 🎁

_Si te gusta el proyecto y quieres agradecerlo._

* Comenta a otros sobre este proyecto 📢
* Invita a un café ☕ si nos vemos algún día 🤓. 
* Da las gracias públicamente.
