<p align="center">
    <a href="https://www.derbyweb.dev/" target="_blank"><img src="https://www.derby-web-design-agency.co.uk/Resources/Theme/Frontend/images/logo.png" width="400" alt="UBL Designs Logo"></a>
    <br>
    <a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo"></a>
</p>


# UBL Ticker Features

Ticketing system to handle support for customers/clients:

- Admin and customer user options.
- Ability to add hours worked on each ticket.
- Ability to assign an hourly rate with a default rate or by the individual client.
- Add tasks to each ticket that the client/customer and admin can keep track of.
- Ability to upload images in not only the tickets but each and every reply.
- Ability to turn off hourly rate and tasks for tickets.
- Ability to add your company logo to the ticketing system.
- Built using Laravel 10.
- Designed using Tailwind.
- Uses Font Awesome Free

# Functionality 

Only admins can see all the settings and every ticket, customers can only see their tickets raised. 
Customers are the only ones who can create tickets.


# Screenshots

### Login Screen
<img src="https://www.derby-web-design-agency.co.uk/git/login.jpg" alt="Login Screen">

### Customer Dashboard
<img src="https://www.derby-web-design-agency.co.uk/git/dashboard.jpg" alt="Dashboard">

### Creating A Ticket With An Error Report
<img src="https://www.derby-web-design-agency.co.uk/git/ticket-submit.jpg" alt="Dashboard">

### Customer Ticket View - With Reply & Images - With Tasks Enabled
<img src="https://www.derby-web-design-agency.co.uk/git/client-ticket.jpg" alt="Dashboard">

### Admin Ticket View - With Reply - With Hourly Rate Enabled - With Tasks Enabled
<img src="https://www.derby-web-design-agency.co.uk/git/admin-ticket.jpg" alt="Dashboard">

# Installation guide

- Download package
- Change the .env.example to .env and enter your details within the file.
- Make sure you change the app name to the name you want the ticketing system to be called, and use - for spaces.
- Open the terminal and type: composer install
- Then type: composer update
- Then type: php artisan migrate --seed
- Now generate a new Laravel key by typing: php artisan key:generate
- If you have npm installed already you will need to type: npm i
- Installation complete


# Initial Login Information

- Admin login: admin@admin.com - Password: password
- Customer login: customer@customer.com - Password: password

Once you log in go to website settings, upload a log and choose the settings to use
