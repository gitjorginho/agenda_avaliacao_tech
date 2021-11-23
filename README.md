1. - git clone https://github.com/gitjorginho/agenda_avaliacao_tech agenda

2. - cd agenda

3. composer install

4- copie o araquivo .env.example e renomei para .env

5- no terminal execute `php artisan key:generate `

6- cria uma base de dados mysql chamada laravel 

7- no arquivo env configure o banco

    DB\_CONNECTION=mysql

    DB\_HOST=127.0.0.1

    DB\_PORT=3306

    DB\_DATABASE=laravel

    DB\_USERNAME=root

    DB\_PASSWORD=

8- no terminal execute `php artisan migrate`

9- no terminal execute `php artisan serve`

10- em outro instacia do terminal

11- entra na pasta spa  `cd agenda\spa`

12- no terminal execute `npm i`

13- npm run serve

Pronto provavelmente o servidor abrirar em http://localhost:8080/


*Se o dominio do servidor for diferente de  http://127.0.0.1:8000

Observacao: no arquivo agenda\spa\vue.config.js.js  configura o dominio do servidor

proxy: 'http://127.0.0.1:8000'   # COLOCA O DOMINIO DO SERVIDOR PHP

