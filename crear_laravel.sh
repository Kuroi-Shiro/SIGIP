#!/bin/bash

if [ -z "$1" ]; then
  echo "⚠️ Error: Debes indicar el nombre del proyecto."
  echo "Uso: ./crear_laravel.sh nombre-del-proyecto"
  exit 1
fi

PROYECTO=$1
DB_NAME=$(echo "$PROYECTO" | tr '-' '_')

echo "🚀 Configurando la base de datos: $DB_NAME"

sudo mariadb -u root -e "
CREATE DATABASE IF NOT EXISTS $DB_NAME;
CREATE USER IF NOT EXISTS 'dev_user'@'localhost' IDENTIFIED BY 'password123';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO 'dev_user'@'localhost';
FLUSH PRIVILEGES;
"
echo "✅ Base de datos configurada."

echo "📁 Creando carpeta 'codigo'..."
mkdir -p codigo
cd codigo || exit

echo "📥 Instalando Laravel..."
composer create-project laravel/laravel "$PROYECTO"

cd "$PROYECTO" || exit
echo "🔑 Configurando permisos y variables de entorno..."
chmod -R 775 storage bootstrap/cache
cp .env.example .env

sed -i "s/^DB_CONNECTION=.*/DB_CONNECTION=mariadb/" .env
sed -i "s/^# DB_HOST=.*/DB_HOST=127.0.0.1/" .env
sed -i "s/^# DB_PORT=.*/DB_PORT=3306/" .env
sed -i "s/^# DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
sed -i "s/^# DB_USERNAME=.*/DB_USERNAME=dev_user/" .env
sed -i "s/^# DB_PASSWORD=.*/DB_PASSWORD=password123/" .env
sed -i "s/^DB_HOST=.*/DB_HOST=127.0.0.1/" .env
sed -i "s/^DB_PORT=.*/DB_PORT=3306/" .env
sed -i "s/^DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
sed -i "s/^DB_USERNAME=.*/DB_USERNAME=dev_user/" .env
sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=password123/" .env

echo "🔐 Generando clave y migrando..."
php artisan key:generate
php artisan migrate

echo "📦 Compilando assets..."
npm install
npm run build

cd ../../

echo "🐙 Subiendo el proyecto a tu repositorio de GitHub..."
git add .
git commit -m "🚀 Estructura inicial: Creada carpeta codigo con proyecto Laravel '$PROYECTO'"
git push

echo "🎉 ¡Terminado! Tu proyecto está en 'codigo/$PROYECTO' y subido a GitHub."
