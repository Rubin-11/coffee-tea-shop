#!/bin/bash
set -e

# Скрипт запускает сидеры Phinx в правильном порядке

CMD="sudo docker compose exec php ./vendor/bin/phinx seed:run -e development -s"

$CMD UsersSeeder
$CMD CategoriesSeeder
$CMD ProductsSeeder
$CMD AttributesSeeder
$CMD AttributeValuesSeeder
$CMD ProductAttributesSeeder
$CMD ReviewsSeeder
$CMD UserAddressesSeeder
