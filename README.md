## PHP Simple Framework
### definition
- some months ago i spent some times on making a simple php framework, so i wroted a simple router and controller ...
- couple of week ago i asked to write an interview task (a simple reservation system)
. so i get it a little better. <a href="https://github.com/mrezagolestan/sabaidea_task">Repo Link</a>
- in previous days, i had a review on that, tried to add `PHPUnit` `unit` `feature` testing, so i realized there's a lot of issue. for instance: i needed to add `IoC Container` officially, and a lot improvements.

so this is result.

### Prerequisites:
1. Makefile
2. Docker
3. Docker-compose

### Step 1:
Copy Example `.env` file 
```bash
$ cp .env.example .env
```

### Step 2:
set `.env` values as expected

### Step 3:
In order to build & run docker containers, run below command:
```bash
$ make up
```

### Step 4:
In Order to make project ready, run below command:

```bash
$ make provision
```

now you can access to project via browser ( `link provided after make up command` )

you can stop project by running
```bash
$ make down
```

### Description
- <b>IoC container & Dependency Injection</b>: binding `concrete` class for `abstract`. able to set an object creation `singleton` (create once). 
- <b>Kernel</b>: run every instance by expected kernel, currently `HTTP Kernel` but `CLI Kernel` can be added
- <b>HTTP Router</b>: an effecient router system + `Router Facade` for simplicity. designed for maximum performance when `PHP Swoole` add to framework (quick match current request with expected route).
- <b>Request wrapper</b>: for security & code style simplicity
- <b>PDO DB wrapper</b>: `MySQL`
- <b>Config</b>: read from `.env` `json` file
- <b>Controller</b>
- <b>Repository</b>
- <b>Views</b>: with `layout` `include view` `section` helpers
- <b>Controller</b>
- <b>Testing</b>: `unit` `feature` testing with, `HTTP Call` & `Database Refresh` Trait. 