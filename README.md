**Escolano Théo**

Requis :

- PHP >= 8.0
- Composer
- Un serveur MySQL
- Un serveur mail

Installation :

- Installer les dépendances


        composer install


- Exécuter le script SQL "**symfony.sql**" situé à la racine du répertoire sur une nouvelle base de donnée.
- Configurer le fichier .env avec les variables d'environnement pour le mailer et la base de donnée


        MAILER_DSN="smtp://user:password@127.0.0.1:25"
        DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"


- Exemple de configuration du serveur nginx (HTTPS)
    
    
    
        server {
            listen 80;
            listen [::]:80;
            server_name symfony.moulmandev.fr www.symfony.moulmandev.fr;
            return 302 https://$server_name$request_uri;
        }

        server {
            # SSL configuration

            listen 443 ssl http2;
            listen [::]:443 ssl http2;
            ssl        on;
            ssl_certificate         /etc/ssl/moulmandev.fr/certs/cert.pem;
            ssl_certificate_key     /etc/ssl/moulmandev.fr/private/key.pem;

            server_name symfony.moulmandev.fr www.symfony.moulmandev.fr;

            root /var/www/symfony.moulmandev.fr/hello-symfony/public/;
            index index.php index.html index.htm;

            location / {
                try_files $uri $uri/ /index.php$is_args$args;
            }

            location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
            }

            error_page 404 /404.php;

            add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
            add_header X-Content-Type-Options "nosniff" always;
        }

- Exemple de configuration du serveur apache2 (HTTP)

        
        <VirtualHost *:80> 
            DocumentRoot "/var/www/symfony-click-go/public"
            ServerName symfony.moulmandev.fr
            ServerAlias *.symfony.moulmandev.fr
            <Directory "/var/www/symfony-click-go/public">
                AllowOverride All
                Require all granted
            </Directory>
        </VirtualHost>
