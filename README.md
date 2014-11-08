# PHP Xml validator

Validate Xml against a xsd schema file.

## Installation

### Library

    $ git clone https://github.com/seromenho/XmlValidator.git

### Composer

    $ composer require seromenho/xml-validator:dev-master

## Usage

```php
<?php

$xml = "<sample>my xml string</sample>";
$xsd = "path_to_xsd_file.xsd";

// Validate
$xmlValidator = new XmlValidator($xml, $xsd);
try{
    $xmlValidator->validate($xml,$xsd);
    
    // Check if is valid
    if(!$xmlValidator->isValid()){
        
        // Do whatever with the errors.
        foreach($xmlValidator->errors as $error){
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