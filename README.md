### Vídeo explicando o código: https://www.youtube.com/watch?v=wUdoHM-oWxc
---
## Como rodar:
## Após ter clonado o repositório e selecionar o diretório, rode os seguintes comandos na pasta back-end:
1. **"composer install"**
2. **"cp .env.example .env" (Edite o arquivo .env com suas configurações)**
3. **"php artisan key:generate"**
4. **"php artisan storage:link"**
5. **"php artisan migrate"**
6. **"php artisan db:seed" (opcional)**
7. **"php artisan serve"**
---
## Depois de ter rodado os comandos no back-end, rode os seguintes comandos na pasta front-end:
1. **"npm install"**
2. **"cp .env.example .env" (Edite o arquivo .env com suas configurações)**
3. **"npm run dev"**

**obs: algo que esqueci de comentar é sobre a navbar e a sidebar serem importadas em todas as views. Descobri de "ultima hora" que esses componentes estavam sendo "mostrados" nas views de registro e login mesmo que a importação delas não fossem feitas. Mas reconheço que seria melhor usar um layout separado para essas views.** 
