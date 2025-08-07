pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'awedni100/symfony-recrute'
    }

    stages {
        stage('Build Docker Image') {
            steps {
                echo '🔨 Construction de l\'image Docker...'
                sh 'docker build -t ${DOCKER_IMAGE} .'
            }
        }

        stage('Login to DockerHub') {
            steps {
                echo '🔐 Connexion à DockerHub...'
                withCredentials([
                    usernamePassword(
                        credentialsId: 'DOCKERHUB_CREDENTIALS',
                        usernameVariable: 'DOCKERHUB_USER',
                        passwordVariable: 'DOCKERHUB_PASS'
                    )
                ]) {
                    sh 'echo ${DOCKERHUB_PASS} | docker login -u ${DOCKERHUB_USER} --password-stdin'
                }
            }
        }

        stage('Push Docker Image') {
            steps {
                echo '📤 Poussée de l\'image vers DockerHub...'
                sh 'docker push ${DOCKER_IMAGE}'
            }
        }
    }
}
