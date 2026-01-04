# Dokploy Demo App

A simple full-stack web application designed for deployment on [Dokploy](https://dokploy.com).

## Stack

- **Frontend**: Vue.js 3 + Vite (served via Nginx)
- **Backend**: Yii2 PHP Framework (Apache)
- **Database**: PostgreSQL 15

## Project Structure

```
├── docker-compose.yml              # Main compose file for local development
├── docker-compose.dokploy.yml      # Main compose file for Dokploy
├── .env.example                    # Environment variables template
├── frontend/                       # Vue.js application
│   ├── Dockerfile
│   ├── nginx.conf
│   └── src/
└── backend/                        # Yii2 PHP application
    ├── Dockerfile
    ├── composer.json
    ├── config/
    └── web/
```

## Local Development

### Prerequisites

- Docker and Docker Compose installed
- Git

### Quick Start

1. Clone the repository:

   ```bash
   git clone <your-repo-url>
   cd deploy-poc
   ```

2. Copy environment file:

   ```bash
   cp .env.example .env
   ```

3. Build and run:

   ```bash
   docker-compose up --build
   ```

4. Access the application:
   - Frontend: http://localhost
   - Backend API: http://localhost:8080/api
   - Health Check: http://localhost:8080/api/health
   - PostgreSQL: localhost:5433

## Dokploy Deployment

### Step 1: Push to Git

Push this repository to GitHub, GitLab, or Bitbucket.

### Step 2: Create Project in Dokploy

1. Log in to your Dokploy dashboard
2. Go to **Projects** → **Create Project**
3. Select **Docker Compose**
4. Connect your Git repository
5. Set the compose file path to `docker-compose.dokploy.yml`

### Step 3: Configure Environment

In Dokploy, add these environment variables:

```
DB_NAME=app_db
DB_USER=app_user
DB_PASSWORD=your_secure_password
```

### Step 4: Configure Domain (Optional)

1. Go to your service settings in Dokploy
2. Add your domain under **Domains**
3. Dokploy will automatically provision SSL via Let's Encrypt

### Step 5: Deploy

Click **Deploy** and Dokploy will:

- Pull your code
- Build Docker images
- Start all services
- Configure networking and SSL

## API Endpoints

| Endpoint          | Description                       |
| ----------------- | --------------------------------- |
| `GET /api`        | API information                   |
| `GET /api/health` | Health check with database status |

## Environment Variables

| Variable      | Description              | Default        |
| ------------- | ------------------------ | -------------- |
| `DB_NAME`     | PostgreSQL database name | `app_db`       |
| `DB_USER`     | PostgreSQL username      | `app_user`     |
| `DB_PASSWORD` | PostgreSQL password      | `app_password` |
| `APP_ENV`     | Application environment  | `production`   |
| `APP_DEBUG`   | Enable debug mode        | `false`        |

## Notes

- For local development, the network is auto-created by docker-compose
- For Dokploy deployment, use `docker-compose.dokploy.yml` which uses the external `dokploy-network`
- Data is persisted in a Docker volume (`postgres_data`)
- Avoid setting `container_name` in docker-compose for Dokploy compatibility
