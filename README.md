1. - git clone git@github.com:gitjorginho/TestTecnicoPHPJorgeAlanSantos.git agenda

1. - cd agenda

1. composer install

4- copie o araquivo .env.example e renomei para .env

5- no terminal execute `php artisan key:generate `

6- cria uma base de dados chamada laravel

7- no arquivo env configure o banco

    DB\_CONNECTION=mysql

    DB\_HOST=127.0.0.1

    DB\_PORT=3306

    DB\_DATABASE=laravel

    DB\_USERNAME=root

    DB\_PASSWORD=

8- no terminal execute `php artisan migrate`

9- no terminal execute `php artisan db:seed`

10- cofigura no arquivo .env com os dados de smtp

    MAIL\_MAILER=smtp

    MAIL\_HOST=smtp.mailtrap.io

    MAIL\_PORT=2525

    MAIL\_USERNAME=null

    MAIL\_PASSWORD=null

    MAIL\_ENCRYPTION=null

    MAIL\_FROM\_ADDRESS=null

    MAIL\_FROM\_NAME="${APP\_NAME}"

    EMAIL=     #email que vai receber os contatos

11- no terminal execute `php artisan serve`

12- em outro instacia do terminal

9- entra na pasta spa  `cd agenda\spa`

10- no terminal execute `npm i`

11- npm run serve

Pronto provavelmente o servidor abrirar em http://localhost:8080/


Para realizar os testes unitarios

1. - no terminal execute `php artisan test`


*Se o dominio do servidor for diferente de  http://127.0.0.1:8000

Observacao: no arquivo agenda\spa\vue.config.js.js  configura o dominio do servidor

proxy: 'http://127.0.0.1:8000'   # COLOCA O DOMINIO DO SERVIDOR PHP

