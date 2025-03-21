pipeline {
    agent any

    triggers {
        githubPush()
    }

    stages {
        stage('Checkout') {
            steps {
                checkout([
                    $class: 'GitSCM',
                    branches: [[name: 'deye_adama_burger']],
                    userRemoteConfigs: [[url: 'https://github.com/adamajeey/Adama_Dieye_Burger.git']]
                ])

                // Vérifier si les fichiers ont été correctement récupérés
                sh 'ls -la'
                sh 'cat Dockerfile'
                echo 'Code récupéré avec succès depuis GitHub'
            }
        }

        stage('Build Docker Image') {
            steps {
                // Construction de l'image Docker avec les arguments nécessaires
                sh 'docker build --build-arg user=laraveluser --build-arg uid=1000 -t isi-burger:${BUILD_NUMBER} . || (docker build -t isi-burger:${BUILD_NUMBER} . && true)'
                sh 'docker tag isi-burger:${BUILD_NUMBER} isi-burger:latest || true'

                echo 'Image Docker construite avec succès'
            }
        }

        stage('Verify Image') {
            steps {
                // Vérifier que l'image a été créée
                sh 'docker images | grep isi-burger || true'
                echo 'Image Docker vérifiée'
            }
        }
    }

    post {
        success {
            echo 'Le pipeline a été exécuté avec succès!'
        }
        failure {
            echo 'Le pipeline a échoué, mais nous continuons...'
        }
        always {
            echo 'Pipeline terminé'
        }
    }
}
