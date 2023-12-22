<div style="max-height:48px;width:auto;">
  <img src="https://dooper.io/ivy/logo.svg" alt="ivy logo" height="48">
</div>

**ivy**, another sleek simple fast CMS with an effortless template and plugin environment

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

#### 4. Install packages

Install the necessary dependencies with [npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm) or [yarn](https://yarnpkg.com/) to kickstart your project:

```bash
npm install
```

or

```bash
yarn install
```

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
