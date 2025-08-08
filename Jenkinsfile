pipeline {
  agent any
  environment {
    IMAGE_REPO   = 'rohitsvv/php-app'
    MANIFEST     = 'k8s/php-deployment.yaml'
    GIT_USER     = 'rkachale'
    GIT_EMAIL    = 'rohit.kachale@somaiya.edu'
    TAG          = "${new Date().format('yyyyMMdd_HHmmss')}_${env.GIT_COMMIT?.take(7) ?: 'local'}"
  }
  stages {
    stage('Checkout') { steps { checkout scm } }

    stage('Build & Push Image') {
      steps {
        script {
          docker.withRegistry('https://index.docker.io/v1/', 'dockerhub-kiaar') {
            def img = docker.build("${IMAGE_REPO}:${TAG}")
            img.push()
          }
        }
      }
    }

    stage('Update Manifests & Push') {
        steps {
            withCredentials([usernamePassword(credentialsId: 'github-kiaar', usernameVariable: 'GIT_USER', passwordVariable: 'GIT_PASS')]) {
            sh """
                set -e
                sed -i 's|^\\s*image:\\s*${IMAGE_REPO}:.*|        image: ${IMAGE_REPO}:${TAG}|' ${MANIFEST}
                git config user.name "${GIT_USER}"
                git config user.email "${GIT_EMAIL}"
                git add ${MANIFEST}
                git commit -m "ci: deploy ${IMAGE_REPO}:${TAG}"
                git push https://${GIT_USER}:${GIT_PASS}@github.com/${GIT_USER}/kiaar HEAD:main
            """
            }
        }
    }

  }
  post {
    success { echo "Updated ${MANIFEST} to ${IMAGE_REPO}:${TAG}. Argo CD will sync." }
  }
}
