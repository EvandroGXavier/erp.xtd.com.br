#!/bin/bash

PHP83="/www/server/php/83/bin/php"
PROJECT="/www/wwwroot/erp.xtd.com.br"

echo "🚀 Forçando execução com PHP 8.3 no Laravel..."

cd $PROJECT

# Limpa cache do Laravel
$PHP83 artisan view:clear
$PHP83 artisan config:clear
$PHP83 artisan route:clear

# Recompila caches
$PHP83 artisan config:cache

# Permissões (evita problemas com bootstrap/cache e storage)
chown -R www:www $PROJECT
chmod -R 775 $PROJECT/storage $PROJECT/bootstrap/cache

echo "✅ Laravel limpo, cache recompilado e permissões corrigidas com PHP 8.3!"
