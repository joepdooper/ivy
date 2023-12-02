<div style="max-height:48px;width:auto;">
  <img src="https://dooper.io/ivy/logo.svg" alt="ivy logo" height="48">
</div>

**ivy**, another sleek simple fast PHP framework with an effortless template and plugin environment

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

#### 5. Login and update your profile

To access your account, navigate to `yourserver.com/admin/login` and use the credentials `admin@localhost.test` and `00000`. Upon successful login, you will be directed to your profile page, where you can modify your email address.

To change your password, open the `.env` file and update it with your email credentials. After making the changes, proceed to `yourserver.com/admin/logout` to log out, and then go to `yourserver.com/admin/reset` to initiate the password reset process.
