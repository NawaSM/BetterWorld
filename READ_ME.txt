
## Setup Instructions

Follow these steps to set up the BetterWorld project on your computer:

### Prerequisites

- PHP 7.4 or higher
- MySQL
- Composer
- XAMPP or similar local server environment

### Installation

1. Clone the repository

2. Navigate to the project directory

3. Install PHP dependencies using Composer:
composer install

4. Install Brevo PHP SDK:

composer require getbrevo/brevo-php "1.x.x"
For detailed instructions on installing and using Brevo, refer to their [official GitHub repository](https://github.com/getbrevo/brevo-php).

5. Import the database schema:
- Start your MySQL server
- Create a new database named `betterworld`
- Import the `betterworld.sql` file into your newly created database

### Running the Application

1. Start your local server environment (e.g., XAMPP)
2. Navigate to `http://localhost/BetterWorld` in your web browser

## Database Schema

The `betterworld.sql` file contains the following tables:

- `users`: Stores information about registered volunteers
- `organizations`: Stores information about registered organizations
- `opportunities`: Contains details of volunteer opportunities
- `applications`: Tracks volunteer applications for opportunities
- `volunteer_history`: Records the history of volunteer participation

For a detailed view of the schema, please refer to the `betterworld.sql` file.

## Troubleshooting

If you encounter any issues during setup:

1. Ensure all prerequisites are correctly installed
2. Delete the vendor folder and the composer.lock file and reattempt the instructions
3. Verify that your local server environment is running
4. Make sure all required PHP extensions are enabled in your `php.ini` file

