// docker run -p 8080:8080 \
//   -v /var/run/docker.sock:/var/run/docker.sock \
//   --name jenkins \
//   jenkins/jenkins:lts

// Second step:
// Use bash command to get into the container:
// docker exec -it -u root:root jenkins bash

// Third step:
// Install docker inside the container"
// apt-get update && \
// apt-get -y install apt-transport-https \
//      ca-certificates \
//      curl \
//      gnupg2 \
//      software-properties-common && \
// curl -fsSL https://download.docker.com/linux/$(. /etc/os-release; echo "$ID")/gpg > /tmp/dkey; apt-key add /tmp/dkey && \
// add-apt-repository \
//    "deb [arch=amd64] https://download.docker.com/linux/$(. /etc/os-release; echo "$ID") \
//    $(lsb_release -cs) \
//    stable" && \
// apt-get update && \
// apt-get -y install docker-ce
pipeline {
    agent any

    stages {
        stage('Create Network') {
            steps {
                script {
                    sh '''
                    docker network create mailing_service || true
                    '''
                }
            }
        }

        stage('Build Laravel Application') {
            steps {
                script {
                    sh '''
                    docker build -t laravel_application -f dockerfiles/laravel.dockerfile .
                    '''
                }
            }
        }

        stage('Build Nginx Container') {
            steps {
                script {
                    sh '''
                    docker build -t nginx_service -f dockerfiles/nginx.dockerfile .
                    '''
                }
            }
        }

        stage('Start Services') {
            steps {
                script {
                    sh '''
                    docker run -d --name MYSQL_Database_Service --network mailing_service -v /my/own/datadir:/var/lib/mysql mysql:latest
                    docker run -d --name Mailpit_Service --network mailing_service -p 8025:8025 -p 1025:1025 axllent/mailpit
                    '''
                }
            }
        }

        stage('Run Laravel Application') {
            steps {
                script {
                    sh '''
                    docker run -d --name Laravel_Application --network mailing_service -v $(pwd)/.env:/var/www/.env -p 8000:8000 laravel_application sh -c "php artisan key:generate && php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000"
                    '''
                }
            }
        }

        stage('Run Nginx') {
            steps {
                script {
                    sh '''
                    docker run -d --name Nginx_Service --network mailing_service -p 80:80 nginx_service
                    '''
                }
            }
        }

        stage('Run Laravel Scheduler') {
            steps {
                script {
                    sh '''
                    docker run -d --name Laravel_Scheduler --network mailing_service -v $(pwd)/.env:/var/www/.env laravel_application sh -c "php artisan schedule:work"
                    '''
                }
            }
        }
    }
}

