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

        stage('Image Build') {
            steps {
                // Construction de l'image Docker directement
                sh 'docker build -t isi-burger:${BUILD_NUMBER} .'
                sh 'docker tag isi-burger:${BUILD_NUMBER} isi-burger:latest'

                echo 'Image Docker construite avec succès'
            }
        }

        stage('Run Container') {
            steps {
                // Exécuter un conteneur pour tester l'image
                sh 'docker run --name test-container-${BUILD_NUMBER} -d isi-burger:latest'
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
