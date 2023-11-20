# Funds Service by Thiago Alves

This service was created in order to manage fund records.

By [clicking here](https://drive.google.com/file/d/1hMMh2leEIIfFs8zhtudUhTgAT62cseXU/view), you have access to the ER
diagram of the service's entities.

## Dependencies

- Docker: >= 20;
- Docker Compose: >= 1.29;

## Setup

Execute the following command on your terminal to get the project started:

```
docker-compose up --build
```

Wait for Docker to finish all the processes. That happens when you see the message below:

```
funds-service-php-worker | Ready to go!
```

## Automated tests

Use the following commands to execute the automated tests:

**Access to the application container:**

```
docker exec -it funds-service-php bash
```

**Run the tests:**

```
composer tests
```

## Testing the API

[Click here](https://documenter.getpostman.com/view/2046871/2s9Ye8gFSi) to have access to API documentation
where you can understand how the API methods work.

Every time a fund is created or updated, the events and processes to check if there is any duplicate data are
executed. You can follow those processes in your terminal by just looking at the `funds-service-php-worker` container
activities.

