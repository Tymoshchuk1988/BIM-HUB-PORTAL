#!/bin/bash
echo "📖 Створення OpenAPI документації..."

cat > docs/api/openapi.yaml << 'OPENAPI_EOF'
openapi: 3.0.0
info:
  title: BIM Hub Portal API
  description: API для BIM Hub Portal - Building Information Modeling platform
  version: 2.0.0
  contact:
    name: BIM Hub Team
    email: dev@bimhub.gov.ua

servers:
  - url: https://bimhub.site/api
    description: Production server

paths:
  /:
    get:
      summary: Отримати інформацію про API
      tags: [API]
      responses:
        '200':
          description: Інформація про API
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ApiInfo'
  
  /status:
    get:
      summary: Отримати статус системи
      tags: [System]
      responses:
        '200':
          description: Статус системи
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/SystemStatus'
  
  /projects:
    get:
      summary: Отримати список проектів
      tags: [Projects]
      responses:
        '200':
          description: Список проектів
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ProjectList'
    
    post:
      summary: Створити новий проект
      tags: [Projects]
      security:
        - BearerAuth: []
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/ProjectCreate'
      responses:
        '201':
          description: Проект створено
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/ProjectResponse'
  
  /projects/{id}:
    get:
      summary: Отримати проект по ID
      tags: [Projects]
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: integer
      responses:
        '200':
          description: Деталі проекту
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/Project'
    
    put:
      summary: Оновити проект
      tags: [Projects]
      security:
        - BearerAuth: []
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: integer
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/ProjectUpdate'
      responses:
        '200':
          description: Проект оновлено
    
    delete:
      summary: Видалити проект
      tags: [Projects]
      security:
        - BearerAuth: []
      parameters:
        - name: id
          in: path
          required: true
          schema:
            type: integer
      responses:
        '200':
          description: Проект видалено
  
  /auth/login:
    post:
      summary: Авторизація користувача
      tags: [Authentication]
      requestBody:
        required: true
        content:
          application/json:
            schema:
              $ref: '#/components/schemas/LoginRequest'
      responses:
        '200':
          description: Успішна авторизація
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/LoginResponse'

components:
  securitySchemes:
    BearerAuth:
      type: http
      scheme: bearer
      bearerFormat: JWT
  
  schemas:
    ApiInfo:
      type: object
      properties:
        status:
          type: string
          example: "success"
        data:
          type: object
    
    SystemStatus:
      type: object
      properties:
        system:
          type: string
          example: "online"
        database:
          type: string
          example: "connected"
        server_time:
          type: string
          format: date-time
    
    Project:
      type: object
      properties:
        id:
          type: integer
        name:
          type: string
        description:
          type: string
        status:
          type: string
          enum: [planning, design, construction, completed]
        progress_percentage:
          type: integer
          minimum: 0
          maximum: 100
    
    ProjectList:
      type: object
      properties:
        projects:
          type: array
          items:
            $ref: '#/components/schemas/Project'
        count:
          type: integer
        total:
          type: integer
    
    LoginRequest:
      type: object
      required:
        - email
        - password
      properties:
        email:
          type: string
          format: email
        password:
          type: string
          format: password
    
    LoginResponse:
      type: object
      properties:
        user:
          type: object
        token:
          type: string
        token_type:
          type: string
          example: "Bearer"
        expires_in:
          type: integer
OPENAPI_EOF

echo "✅ OpenAPI документація створена"
echo "🌐 Доступно за: https://bimhub.site/docs/api/openapi.yaml"
