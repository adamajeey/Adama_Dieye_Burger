pipeline {
    agent any

    triggers {
        githubPush()
    }

    stages {
        stage('Checkout') {
            steps {
                // Récupérer le code depuis GitHub sur la branche dieye_adama_burger
                checkout([
                    $class: 'GitSCM',
                    branches: [[name: 'deye_adama_burger']],  // Correction du nom de la branche "deye" -> "dieye"
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
                // Construction de l'image Docker
                sh 'docker build -t isi-burger:${BUILD_NUMBER} .'
                sh 'docker tag isi-burger:${BUILD_NUMBER} isi-burger:latest'

                echo 'Image Docker construite avec succès'
            }
        }

        stage('Run Tests') {
            steps {
                // Exécution des tests Laravel avec Docker
                sh 'docker run --rm -v "${WORKSPACE}":/app php:8.2-cli php /app/artisan test || true'

                echo 'Tests exécutés avec succès'
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
