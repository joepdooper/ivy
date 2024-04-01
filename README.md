<div style="max-height:48px;width:auto;color:#F40">
  <img src="https://dooper.io/ivy/templates/ivy/images/logo.svg" alt="ivy logo" height="48">
</div>

Yet another sleek simple fast CMS with an effortless template and plugin environment

[![Composer](https://img.shields.io/badge/Composer-222)](https://getcomposer.org/)
[![npm](https://img.shields.io/badge/npm-222)](https://www.npmjs.com/)
[![PHP](https://img.shields.io/badge/PHP-v8.1.0-222)](https://www.php.net/)

## Install

#### 1. Navigate to your project folder

Open terminal and navigate to your project folder:

```bash
cd path/to/your/ivy/project
```

#### 2. Download ivy files

Use [Composer](https://getcomposer.org/) to create a new project with **ivy**:

```bash
composer create-project joepdooper/ivy .
```

#### 3. Set up the database

Create a database for **ivy** and import the provided `ivy.sql` file:

```bash
mysql -u your_database_username -p your_database_name < ivy.sql
```

Rename the `example.env` file to `.env` and update it with your database credentials.

## Login

#### Accessing the backend

To access the "backend" for the first time, follow these steps:

1. Navigate to `yourserver.com/admin/login` (user icon)
2. Use the credentials `admin@localhost.test` and `00000`
3. Upon successful login, you will be directed to the profile page with *super_admin* rights

#### Changing email and password

Open the `.env` file and update it with your email credentials. If you've modified the `.env` file, follow these steps:

1. Upon login, on the profile page, modify and submit your email address to initiate the email change process
2. After successfully changing your email address, go to `yourserver.com/admin/logout` to log out (logout icon)
3. Finally, navigate to `yourserver.com/admin/reset` to initiate the password reset process


## Documentation

[Documentation](https://dooper.io/ivy) coming up
