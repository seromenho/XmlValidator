# PHP Xml validator

[![Build Status](https://travis-ci.org/seromenho/XmlValidator.svg)](https://travis-ci.org/seromenho/XmlValidator)
[![Packagist](https://img.shields.io/packagist/dt/seromenho/xml-validator.svg)](https://packagist.org/packages/seromenho/xml-validator)

Validate Xml against a xsd schema file.

## Installation

### Library

    $ git clone https://github.com/seromenho/XmlValidator.git

### Composer

    $ composer require seromenho/xml-validator:dev-master

## Usage

```php
<?php
require "./vendor/autoload.php";
use XmlValidator\XmlValidator;

$xml = "<sample>my xml string</sample>";
$xsd = "path_to_xsd_file.xsd";

// Validate
$xmlValidator = new XmlValidator($xml, $xsd);
try{
    $xmlValidator->validate($xml,$xsd);
    
    // Check if is valid
    if(!$xmlValidator->isValid()){
        
        // Do whatever with the errors.
        foreach ($xmlValidator->errors as $error) {
            /*echo sprintf('[%s %s] %s (in %s - line %d, column %d)',
                $error->level, $error->code, $error->message, 
                $error->file, $error->line, $error->column
            ); */
        }
    }
} catch (\InvalidArgumentException $e){
    // catch InvalidArgumentException
}

```

Based on [XmlUtils](https://github.com/symfony/symfony/blob/master/src/Symfony/Component/Config/Util/XmlUtils.php) from Symfony config component.