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

// if got permission error do this:
// sudo chmod 666 /var/run/docker.sock
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

        stage('Build and Start Services') {
            steps {
                script {
                    sh 'docker-compose up -d --build'
                }
            }
        }

        stage('Verify Services') {
            steps {
                script {
                    sh 'docker-compose ps'
                }
            }
        }
    }

    post {
        always {
            script {
                // Clean up services
                sh 'docker-compose down'
            }
        }
    }
}

