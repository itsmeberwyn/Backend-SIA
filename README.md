# GC PANEL

#### Inventory with P.O.S and Donor Information System for blood banks

A system keeping an eye on stock count, and on transactions; it also stores the information of and donor

## Tech Stack

**Client:** Angular, Bootstrap4

**Server:** Php, MySQL

## Members

- [@Berwyn Felismenia](https://github.com/luci-000)
- [@John Romeo Perez](https://github.com/luci-000)
- [@Melmark Dela Cruz](https://github.com/luci-000)
- [@Angelica Estrada](https://github.com/luci-000)
- [@Angelo Natad](https://github.com/luci-000)
- [@Mark Russel Trapsi](https://github.com/luci-000)
- [@Renzo Santos](https://github.com/luci-000)

## Run Locally

#### Frontend

Clone the project

```bash
  https://github.com/fafbpat/sia-project.git
```

Go to the project directory

```bash
  cd [project-name]
```

Install dependencies

```bash
  npm install
```

Start the server

```bash
  ng serve --o
```

#### Backend

Clone the project

```bash
  https://github.com/FelismeniaBerwyn/Backend-SIA.git
```

Create database and import MySQL database

```bash
  sia_project_db.sql
  Start XAMPP to run the server
```

How to:

```bash
  Go to the file directory and create an .env file in the root folder
```

```bash
  Place the following inside the .env file and be sure to put the database name in __DBASE_

  __DBASE_=sia_project_db #example name sia_project_db
  __USER_=root
  __PASSWORD_=
  __SERVER_=localhost
  __CHARSET_=utf8mb4
```

#### REST API

Use plural form for the resource names

```bash
/users, /users/{id}
```

Use camelCase for the method names

```bash
getUser(){
  return users();
}
```

Use self-explanatory, simple names

```bash
$users

/users, /users/{id}

{
  "email":"kamotee@gmail.com",
  "username":"kamotee",
}
```

Use reasonable HTTP status codes

```bash
• 200 for general success
• 201 for successful creation
• 400 for bad requests from the client
• 401 for unauthorized requests
• 403 for missing permissions
• 404 for missing resources
• 429 for too many requests
• 5xx for internal errors (these should be avoided at all costs)
```

Return created resources upon POST

```bash
Request: POST
{
  "email":"kamotee@gmail.com",
  "username":"kamotee",
}

Response
{
  "id": "123",
  "email":"kamotee@gmail.com",
  "username":"kamotee",
}
```
