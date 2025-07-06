# Campus Mystery Challenge

A PHP-based interactive adventure game set on a mysterious campus. Users register, log in, and make choices that affect the outcome of the story. Game state is tracked using a MySQL database.

## Features
- User authentication (register/login/logout)
- Session-based game progression
- Game state saved to MySQL
- Branching storylines based on user choices
- Clean, consistent theming with CSS

## Setup
1. Clone this repo to your PHP server directory.
2. Create a MySQL database and import the required tables.
3. Update `config.php` with your DB credentials.
4. Access the site via your browser (e.g., `http://localhost/project-folder/`).

## Folder Structure
- `index.php` – Homepage
- `register.php`, `login.php`, `logout.php` – User auth
- `game.php`, `process_choice.php` – Main game logic
- `config.php` – DB connection
- `styles.css` – Site styling
