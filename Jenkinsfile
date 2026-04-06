pipeline {
    agent any

    environment {
        APP_NAME = "laravel11-frontend-auth"
        IMAGE_NAME = "georgewneto/laravel11-frontend-auth:latest"
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build Image') {
            steps {
                script {
                    // Constrói a imagem usando o Dockerfile do projeto
                    sh "docker build -t ${IMAGE_NAME} ."
                }
            }
        }

        stage('Deploy (Replace Container)') {
            steps {
                script {
                    // 1. Para e remove o container antigo (se existir)
                    sh "docker stop ${APP_NAME} || true && docker rm ${APP_NAME} || true"

                    // 2. Sobe o novo container
                    // Ajuste as portas e o link com o banco de dados conforme necessário
                    sh """
                        docker run -d --name ${APP_NAME} --restart unless-stopped -p 8010:8010 --env-file /home/georgewneto/Projetos/frontend-auth/.env ${IMAGE_NAME}
                    """
                }
            }
        }

        stage('Post-Deploy Tasks') {
            steps {
                // Cria a pasta jwt com permissões corretas
                sh "docker exec ${APP_NAME} mkdir -p /var/www/storage/jwt"

                // Copia as chaves JWT para o container
                sh "docker cp /home/georgewneto/Projetos/frontend-auth/storage/jwt/jwt-private.key ${APP_NAME}:/var/www/storage/jwt/"
                sh "docker cp /home/georgewneto/Projetos/frontend-auth/storage/jwt/jwt-public.key ${APP_NAME}:/var/www/storage/jwt/"

                // Define permissões corretas nos arquivos JWT
                sh "docker exec ${APP_NAME} chmod 644 /var/www/storage/jwt/jwt-private.key"
                sh "docker exec ${APP_NAME} chmod 644 /var/www/storage/jwt/jwt-public.key"
                sh "docker exec ${APP_NAME} chown -R www-data:www-data /var/www/storage/jwt"

                // Cria a pasta de logs e o arquivo laravel.log
                sh "docker exec ${APP_NAME} mkdir -p /var/www/storage/logs"
                sh "docker exec ${APP_NAME} touch /var/www/storage/logs/laravel.log"
                sh "docker exec ${APP_NAME} chmod 666 /var/www/storage/logs/laravel.log"
                sh "docker exec ${APP_NAME} chown -R www-data:www-data /var/www/storage/logs"

                // Garante o arquivo SQLite quando DB_CONNECTION=sqlite
                sh '''
                    docker exec ${APP_NAME} sh -c '
                        if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
                            mkdir -p /var/www/database
                            touch /var/www/database/database.sqlite
                            chmod 664 /var/www/database/database.sqlite
                        fi
                    '
                '''

                // Roda as migrações dentro do novo container
                sh "docker exec ${APP_NAME} php artisan migrate --force"
                sh "docker exec ${APP_NAME} php artisan config:cache"
            }
        }

        stage('Cleanup') {
            steps {
                // Remove imagens antigas "soltas" para não lotar o disco
                sh "docker image prune -f"
            }
        }
    }
}
