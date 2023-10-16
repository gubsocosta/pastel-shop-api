# Pastel Shop API

## Descrição
Esta aplicação tem como o objetivo gerenciar pedidos de uma pastelaria

## Dependências
- docker 25.0.5
- php 8.2
- composer 2.6.2
- laravel 10.x

## Iniciando a aplicação
Crie o arquivo `.env`

```shell
$ cp .env.example .env
```

Instale as dependências via docker:

```shell
$ docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

Suba os containers:

```shell
$ ./vendor/bin/sail up --force-recreate -d
```

Gere o `app_key` com o comando:

```shell
$ ./vendor/bin/sail artisan key:generate
```

Execute a aplicação:

```shell
$ ./vendor/bin/sail artisan serve
```
A aplicação estará sendo executada na porta 8000.

Caso queira parar a aplicação, execute o comando abaixo:


```shell
$ ./vendor/bin/sail artisan stop
```


Para ver a executar dos testes de unidade, execute o comando abaixo:

```shell
$ ./vendor/bin/sail test
```

Para remover os containers:
```shell
$ ./vendor/bin/sail down --remove-orphans
```
