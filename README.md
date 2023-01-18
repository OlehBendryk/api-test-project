

## How to run this?

The instructions assume that you have already installed [Docker](https://docs.docker.com/installation/) and [Docker Compose](https://docs.docker.com/compose/install/). 

- Clone this repository
    
    ```git clone https://github.com/OlehBendryk/api-test-project.git```
    
- Move to the directory 

    ```cd api-test-project```
    
- Update your depencencies
    
    ```composer update```
    
- Build all containers 
    
    ```docker-compose build```

- Run all containers

    ```docker-compose up```

- Move to inside docker container
    
    ```docker exec -it api-test-project bash```

- Run migration and seeder

    ```php artisan migrate --seed```
    
    
- App local link
    
    ```api.localtest.me```

