# adm-dashboard
Dashboard de control de registros en la bd

# Requisitos
* PHP >= 8.2
* Composer >= 2.5.5
* Laravel 10
* MySQL >= 8.0
* 
# Instalación
Clonamos el repositorio
```bash
git clone git@github.com:Derlisd/dashboard-ti.git
```
Instalamos las dependencias:
```bash
cd adm-ti
composer install
```
Inicializamos el proyecto por primera vez:
```bash
cp .env.example .env
php artisan key:generate
```

HashID - Crear APP_SALT dentro de nuestro entorno
* Abrir .env
* Pegar al final la siguiente linea
* Solicitar  API_AUDITORIA , API_USER, API_PASS
```bash
API_AUDITORIA=
API_USER=
API_PASS=
```

Arrancamos los servicios Laravel
```bash
php artisan serve
```


