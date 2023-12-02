<div style="max-height:48px;width:auto;">
  <img src="https://dooper.io/ivy/logo.svg" alt="ivy logo" height="48">
</div>

**ivy**, another sleek simple fast PHP framework with an effortless template and plugin environment

## Install

#### 1. Navigate to your project folder

Open terminal and navigate to your parent project folder:

```bash
cd path/to/your/project
```

#### Download ivy files

Use Composer to create a new project with **ivy**:

```bash
composer create-project joepdooper/ivy
```

#### Set up the database

Create a database for **ivy** and import the provided `ivy.sql` file:

```bash
mysql -u your_database_username -p your_database_name < ivy.sql
```

Rename the `example.env` file to `.env` and update it with your database credentials.

#### Install packages

Install the necessary dependencies to kickstart your project:

```bash
npm install
```

or

```bash
yarn install
```
