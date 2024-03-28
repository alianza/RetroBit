# RetroBit
Server and application for IOT project Jan-Willem van Bremen 500779265

## Intro
The application I have created to work with the Internet Of Things device I have created for Embedded Technology uses the XAMPP (Cross platform/Apache + MariaDB + PHP + Perl) PHP development environment as back-end and for the WebServer component, database storage and hosting the front-end component of the application.

The IOT device communicates it’s so-called ‘Activations’ to the WebServer which stores it in the database to be displayed in the front-end component to the user. To get a better understanding of what these ‘activations’ are, I will provide some context to my Individual Internet Of Things project.

The product is aimed at people with hearing damage or deaf people that have trouble hearing things at home in relation to home appliances. Like for instance an oven-timer, doorbell or (smoke)alarm. The IOT device is able to be RetroFitted to all kinds of home appliances, and is able to detect when these appliances go off with the use of a sound sensor. It triggers when the detected sound exceeds a certain threshold which is configurable in the Application and saved in the database. When the device is triggered it sends a so-called ‘activation’ to the WebServer with some data about the activation. This triggers a notification in the WebApplication in for instance your mobile phone to alert you of the home appliance activating and the RetroBit itself will emit a configurable Audio and visual Alert using lighting and speakers. The term used to refer to the IOT device in question from now on will be ‘RetroBit’ which is also the product name.

In the Application past and current activations can be viewed and removed. New activations will trigger notifications to be sent to the client through the web browser. The RetroBit configuration can be changed in the Application too.

The IOT device also retrieves data from the WebServer component to set it’s configuration according to the settings set in the Application.

**![](https://lh6.googleusercontent.com/ZHQQyl8GmYn-QVF-a6SO_ihCeFNdTDIPr_YMPnYYeYIkOCyt3TBAXWjuNUK5nb2BElM68iczjFuUCUMxN-0K784m5JGi3W7Sg3X4j5Qk2EmJfvdXI5HnRhiZAytM-7ZQexxKHzTP)**
**![](https://lh4.googleusercontent.com/A6NCOruZ-ThMYr9lHghq_KdB2NwTX97x9u97ZVSs6LcT5elfmxeTczE6POY54FnVMlBY_Uh4DYSW8PbM9SD67ISfYql_dT8eD6O0URhrK9Lum-79ZQ7-NaDyRZ6do_nSXm7VCoHa)**
**![](https://lh5.googleusercontent.com/bJ0aya9_i93UtTOYmN9xecAD9McxaePuPqkSW1eduNrvXP0ehtVl8zBknnQoVmWaGHkheLGBcJ_0wrDF2zfQ_oVm4FoHRTxdpeJbMaIawn6mS98rwubCV2RJhXZ3cpiGODBNg-Zd)**
**![](https://lh3.googleusercontent.com/hQKbwrTSpSDauPxHE_dFNiTUV6JULdQA3X8lB39zduMZrHvZUzgz2VFUZW3YkYELRamKfiOCdp5CeWALVBR0O5eJfzgBdvNqSsy72ggrWlZuJjvrhYmKi-Z79rK1haZ1iwXIQFps)**
**![](https://lh6.googleusercontent.com/tY3_--YSAIPpPNLxr-QIvvjRQgWI_BPixtvtG1kBevoBBtX0HrH3I5IcMYPzKQOFNYdS6gr9lVzyY5epTvIyDICG807A1VhIbgSH61A1DR9bObRX3YOBEXZz8js0Up8vtKtW9l8F)**

