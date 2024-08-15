// docker run -p 8080:8080 \
//   -v /var/run/docker.sock:/var/run/docker.sock \
//   --name jenkins \
//   jenkins/jenkins:lts

// Second step:
// Use bash command to get into the container:
// docker exec -it -u root:root jenkins bash

// Third step: (run in wsl)
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

// if got permission error do this (run in wsl):
// sudo chmod 666 /var/run/docker.sock

// to install docker-compose inside the jenkins container (run in wsl)
// sudo curl -L "https://github.com/docker/compose/releases/download/$(curl -s https://api.github.com/repos/docker/compose/releases/latest | grep 'tag_name' | cut -d\" -f4)/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
// sudo chmod +x /usr/local/bin/docker-compose

pipeline {
    agent any

    stages {
        stage('Create Network') {
            steps {
                script {
                    sh 'docker network create mailing_service || true'
                }
            }
        }

        stage('Build Laravel Application') {
            steps {
                script {
                    sh 'docker-compose build'
                }
            }
        }

        stage('Start Services') {
            steps {
                script {
                    sh 'docker-compose up -d'
                }
            }
        }

        stage('Run Laravel Migrations') {
            steps {
                script {
                    sh '''
                    docker-compose exec -T laravel php artisan migrate
                    '''
                }
            }
        }

        stage('Run Selenium Tests') {
            steps {
                script {
                    // Install npm dependencies
                    sh 'npm install'
                    // Run the test script
                    sh 'node testsendingemail.spec.js'
                }
            }
        }

        stage('Clean Up') {
            steps {
                script {
                    sh 'docker-compose down'
                }
            }
        }
    }
}


