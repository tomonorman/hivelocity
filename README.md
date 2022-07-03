## Requirements

* PHP
* Composer
* PHPUnit

## Running the tests

The test will load in a csv file containing sample banking data and run the results function located in `Finalresult.php`. It will then compare this against your control set which should be provided in the data provider `bankRecordsProvider()`  in `FinalResultTest.php` as an  (array of) associative array(s). Multiple files (and thus multiple control sets) can be provided.

Please note the following:

1. Your sample data (csv file(s)) should be placed in `/tests/support`
2. A new array should be provided for each csv file you wish to test against within `bankRecordsProvider()`. The `filename` field will be used by the test to load in the corresponding csv. So it should look something like this:
```php
return [
            [
                [
                    "filename"=>"<name>.csv",
                    "failure_code"=>"<code>",
                    "failure_message"=>"<message>",
                    "records"=>[
                        [
                          ...
                        ],
                        [
                          ...
                        ],
                    ]
                ]
            ],
            [
                [
                    "filename"=>"<name>.csv",
                    "failure_code"=>"<code>",
                    "failure_message"=>"<message>",
                    "records"=>[
                        [
                          ...
                        ],
                        [
                          ...
                        ],
                    ]
                ]
            ],
            ...
        ];
```
