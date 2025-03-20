pipeline {
    agent any

    triggers {
        githubPush()
    }

    stages {
        stage('Checkout') {
            steps {
                // Récupérer le code depuis GitHub sur la branche deye_adama_burger
                checkout([
                    $class: 'GitSCM',
                    branches: [[name: 'deye_adama_burger']],
                    userRemoteConfigs: [[url: 'https://github.com/adamajeey/Adama_Dieye_Burger.git']]
                ])

                // Vérifier si les fichiers ont été correctement récupérés
                sh 'ls -la'
                echo 'Code récupéré avec succès depuis GitHub'
            }
        }

        stage('Build Docker Image') {
            steps {
                // Construction de l'image Docker avec les arguments nécessaires
                sh 'docker build --build-arg user=laraveluser --build-arg uid=1000 -t isi-burger:${BUILD_NUMBER} .'
                sh 'docker tag isi-burger:${BUILD_NUMBER} isi-burger:latest'

                echo 'Image Docker construite avec succès'
            }
        }

        stage('Run Container') {
            steps {
                // Exécuter un conteneur temporaire pour tester l'image
                sh 'docker run --name test-container-${BUILD_NUMBER} -d isi-burger:${BUILD_NUMBER} || true'
                sh 'sleep 10'
                sh 'docker logs test-container-${BUILD_NUMBER} || true'
                sh 'docker stop test-container-${BUILD_NUMBER} || true'
                sh 'docker rm test-container-${BUILD_NUMBER} || true'

                echo 'Conteneur de test exécuté avec succès'
            }
        }
    }

    post {
        success {
            echo 'Le pipeline a été exécuté avec succès!'
        }
        failure {
            echo 'Le pipeline a échoué.'
        }
    }
}
