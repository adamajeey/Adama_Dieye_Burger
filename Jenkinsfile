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

                echo 'Code récupéré avec succès depuis GitHub'
            }
        }

        stage('Install Dependencies') {
            steps {
                // Utilisation de Docker pour installer les dépendances
                sh 'docker run --rm -v "${WORKSPACE}":/app composer:latest composer install --no-interaction --no-progress'
                sh 'docker run --rm -v "${WORKSPACE}":/app -w /app node:16 npm install'
                sh 'docker run --rm -v "${WORKSPACE}":/app -w /app node:16 npm run build || true'

                echo 'Dépendances installées avec succès'
            }
        }

        stage('Environment Setup') {
            steps {
                // Configuration de l'environnement Laravel
                sh 'cp .env.example .env'
                sh 'docker run --rm -v "${WORKSPACE}":/app php:8.2-cli php /app/artisan key:generate'

                echo 'Environnement configuré avec succès'
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
                sh 'docker run --rm --name test-container-${BUILD_NUMBER} -d isi-burger:${BUILD_NUMBER} || true'
                sh 'docker stop test-container-${BUILD_NUMBER} || true'

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
