<a href="https://travis-ci.org/simonbowen/laravel-isams"><img src="https://travis-ci.org/simonbowen/laravel-isams.svg?branch=master" /></a>

# laravel-isams
Package to integrate iSAMs data connections in laravel

# Intro
ISAMs an official and an unofficial interface to the underlying data in the system. The former a XML file that can be 
requested over HTTP, the latter a manual SQL connection to the iSAMS MSSSQL database.

This package aims to allow you to use either but maintain the same interface.

# Setup

## Config Example

```php
<?php

return [
  'isams' => [
    'driver' => 'xml', // Set to db to use MSSQL connection,
    'xml' => [
      'url' => 'http://url/for/isams/xml',
      'cache' => null, // Set cache time for XML file (defaults to 60 minutes)
    ],
    'db' => [
      'connection' => 'sqlsrv', // Specify the database connection you wish to use from the database.php config file
    ]
  ]
];
