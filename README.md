# Welcome to Soggies!
Soggies is a software design and development project from the final of my web development course. Completed in approximately 3 days, Soggies served as my exploration into PHP and Apache server management, alongside the use of AJAX (dynamic data loading and UI updates).

## Status
Soggies will not receive further updates and is not intended for future hosting. 

If you would like to experiment with Soggies' code nonetheless, run:
```bash 
git clone https://github.com/luciniv/Soggies-estore.git
cd Soggies-estore
```

### Note for password retreival:
Soggies stores sensitive information in private files on its Apache server. .env reads are also available for php. An example is listed as the second code excerpt.

File reading:
```php
$InputFile = fopen("file.pwd", "r");
$password = fgets($InputFile, 100);
fclose($InputFile);
```
.env usage:
```php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$password = $_ENV['PASSWORD'];
```

## Tech stack
- **Frontend:** HTML, CSS, JavaScript, AJAX
- **Backend:** PHP
- **Database:** MySQL 8
- **Hosting:** Apache

## Repository structure
```
/src        -> PHP files (+ HTML)
/includes   -> Reusable HTML components for PHP
/scripts    -> Frontend JavaScript and backend linking AJAX
/assets     -> Static resources (icons, logos, etc.)
```

## Design notes
- PHP backend to validate form input and keep data secure
- MySQL database for product information, customer data, and tracking sales
- AJAX for real-time cart updates and username availability responses
- Dynamic page element creation (enabled with PHP, sourced from my database)
- A frontend handled with HTML, CSS, and JavaScript

### Future implementations? Improvements?
- Connection with payment processing systems
- Emailing system for blogs, sales, and premium codes
- Input menu for suggestions, breed requests, etc
- Blog page, info pages for each breed sold

## Site previews
![Landing page](https://media.licdn.com/dms/image/v2/D4E2DAQHr8k60G_SzmA/profile-treasury-image-shrink_800_800/profile-treasury-image-shrink_800_800/0/1737700418017?e=1759532400&v=beta&t=T2zyzmx8IbW54dgT-89iutgIsVT5kvvKgHRlCpjS0Lc)


![Login page](https://media.licdn.com/dms/image/v2/D4E2DAQG-xvtC7ANlOA/profile-treasury-image-shrink_800_800/profile-treasury-image-shrink_800_800/0/1737700485092?e=1759532400&v=beta&t=2aOgCaJHrfmZL3rcMA_Hz6vPRf0Ceq3Pt6pRrq9JOXk)