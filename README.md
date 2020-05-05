## MS Core Package
[![Build Status](https://travis-ci.org/msllp/core.png?branch=master)](https://www.millionsllp.com)
[![Total Downloads](https://poser.pugx.org/msllp/core/downloads.png)](https://www.millionsllp.com)
[![Latest Stable Version](https://poser.pugx.org/msllp/core/v/stable)](https://www.millionsllp.com)
[![Latest Unstable Version](https://poser.pugx.org/msllp/core/v/unstable)](https://www.millionsllp.com)
[![License](https://poser.pugx.org/msllp/core/license)](https://www.millionsllp.com)

A simple MS Core implementation for Laravel 5.8 +.

## Installation

Install the package through [Composer](http://getcomposer.org/). 

Run the Composer require command from the Terminal:

    composer require msllp/core
 
## Configuration
If you're using Laravel 5.8+, this is all there is to do. 

open your `config/app.php` file.

Add a new line to the `providers` array:
    
    \MS\Provider\MSCoreServiceProvider::class,
    
## MS Folder Architect
   
    MS      (MS Root Folder)
    - B     (For Backend)
     | - L    (L for Layouts)
     | - M    (M for Modules)
    
    - L     (For Frontend)
     | - L    (L for Layouts)
     | - M    (M for Modules)
    
    - DB
     | - Master