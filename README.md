# bowling
Bowling game

### Create docker container to run
```bash
docker run -d -p 80:80 --restart unless-stopped -v $(pwd)/bowling:/var/www/html --name php7 chialab/php:7.2-apache
```

### Execute composer update to download dependecies e.g phpunit
```bash
# execure container
docker exec -ti php7 bash

# navigate to /var/www/html
cd /var/www/html
# download dependencies
composer update
```

### We can run the code through browser or inside the docker container

```bash
# navigate to /var/www/html
cd /var/www/html 

# execute the code 
php play.php
```

```
// sample output
Player 1 score   Array
(
    [0] => 7
    [1] => 16
    [2] => 26
    [3] => 41
    [4] => 46
    [5] => 54
    [6] => 63
    [7] => 71
    [8] => 78
    [9] => 96
)
Player 2 score   Array
(
    [0] => 19
    [1] => 28
    [2] => 38
    [3] => 53
    [4] => 58
    [5] => 77
    [6] => 86
    [7] => 94
    [8] => 101
    [9] => 118
)
```
### Or just simply run in browser
```
localhost/play.php
```


### to run test cases using phpunit
```bash
# navigate /var/www/html
vendor/phpunit/phpunit/phpunit unit_tests/TestFrame.php

vendor/phpunit/phpunit/phpunit unit_tests/TestGame.php
```