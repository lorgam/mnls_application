# MNLS Application

## Setup
The application comes with a `docker compose` environment, simly drop the API in the api folder remember to rename the file to index.php and execute `docker-compose up -d`.

The application is in the src folder, by default it makes the petition to http://localhost:8888/ but you can change it by setting an environment variable called `API_LOCATION` or by changig the value of the constant `DEFAULT_LOCATION` in `src/index.php (line 7)` with the route of the API location. Remember that the route of the API should always end with a slash.
