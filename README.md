library-helper
====================

library-helper is an __unofficial__ helper for the various API's offered by LibraryThing. It was built to make it even easier to start using the API's.

This was put together quickly, so there are still many features that I would like to add and things I would like to change. Also Let me know if you find any bugs.

Including:
* Allow setting the title, isbn, etc on when you intiate the class.
* Any missing methods.
* Real Documentation (Beyond examples)
* Better Error Handling (Exceptions?)
* Caching (File, Memcache, etc)
* Rate Limtiting

Getting started.
---------------------

library-helper is very simple to use. Just include the helper and intiate the library-helper class. For some methods you will also need a developer key. You can get one here: https://www.librarything.com/services/keys.php

```php
<?php
require libraryhelper.php;

$libraryhelper = new LibraryHelper('DEVLOPER-KEY');
?>
```

Methods
---------------------

### get_work

Pull down information on a specific work. You are able to look up works with either: id, isbn, lccn, oclc, or the name. Only one is required. Also they must be sent to the array in key => value pairs. (Such as 'isbn' => 'ISBN-NUMBER').

__Example__

```php
<?php

require libraryhelper.php;

$libraryhelper = new LibraryHelper('DEVLOPER-KEY');

$search = array('id' => 14);

$work = $libraryhelper->get_work($search);

print_r($works);

?>
```

### get_cover_url

Get the image URL for the books cover. First paremeter is the ISBN number, the second is the size (optional). Allowed sizes are small, medium, and large.

__Example__
```php
<?php

require libraryhelper.php;

$libraryhelper = new LibraryHelper('DEVLOPER-KEY');

$cover_url = $libraryhelper->get_cover_url('ISBN-NUMBER', 'size')

print_r($cover_url);

?>
```

### get_book_language

Get the language of the book. First paremter is the ISBN number. Set the second paremeter to true to get the full name instead of the language code.

__Example__ 
```php
<?php

require libraryhelper.php;

$libraryhelper = new LibraryHelper('DEVLOPER-KEY');

$language = $libraryhelper->get_book_language('ISBN-NUMBER', true)

print_r($language);

?>
```

### what_work

Take an ISBN number and/or a title/author and return the LibraryThing work number.

__Example__
```php
<?php

require libraryhelper.php;

$libraryhelper = new LibraryHelper('DEVLOPER-KEY');

$search = array('title' => 'The Mermaids Singing', 'author' => 'Carey, Lisa');

$work = $libraryhelper->what_work($search);

print_r($work);

?>
```

### isbn_check

Check and validate an ISBN number. If valid it returns the ISBN10 and ISBN13 form.

__Example__
```php
<?php

require libraryhelper.php;

$libraryhelper = new LibraryHelper('DEVLOPER-KEY');

$isbn = $libraryhelper->isbn_check('ISBN-NUMBER');

print_r($isbn);

?>
```

### search_title_isbn

Search for the ISBN by the title.

__Example__
```php
<?php

require libraryhelper.php;

$libraryhelper = new LibraryHelper('DEVLOPER-KEY');

$isbns = $libraryhelper>search_title_isbn('TITLE');

print_r($isbns);

?>

Examples
---------------------

See examples.php for examples on using most methods.

License
---------------------

Please make sure you follow all licenses listed here for any methods you use: http://www.librarything.com/wiki/index.php/LibraryThing_APIs