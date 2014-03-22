#JSON wrapper for json_decode and json_encode

Wraps the json functions in PHP in a static class, and throws specific exceptions

## Installation
via composer

1. Get [Composer](http://getcomposer.org/)
2. Add `"paulgessinger/json": "dev-master"` to your require
3. Install dependencies with `composer install`


## Getting started

The abstract class PG\JSON contains three methods `JSON::decode`, `JSON::encode` and `JSON::beautify`.
They throw error specific exceptions, which all inherit from PG\JSON\Exception\JsonException, so you can catch them all at once.
Just go

```php
use PG\JSON ;
JSON::encode(array('abc' => 'def'));

// or

JSON::decode('{"abc":"def"}') ;
```


## Tests

Run the tests by calling `phpunit` in the root dir of the repo
PHPUnit is also included in the *require-dev*s so you can get it with `composer install --dev` or `composer update`.

## Contributors
- [Paul Gessinger](http://paulgessinger.com)

## License 

The MIT License (MIT)

Copyright (c) 2014 Paul Gessinger

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.