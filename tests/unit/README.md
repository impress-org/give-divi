# Give Unit Tests [![Build Status](https://api.travis-ci.org/impress-org/give.png?branch=master)](https://api.travis-ci.org/impress-org/give)

This folder contains instructions and test code for Give PHPUnit testing.

## Initial Setup

1) Install [PHPUnit](http://phpunit.de/) by following their [installation guide](https://phpunit.de/getting-started.html). If you've installed it correctly, this should display the version:

    `$ phpunit --version`

    Note: WordPress requires specific version constraints for PHPUnit ( 5.4 >= PHPUNIT <= 7.x ). If you have a different version of PHPUnit installed globally then you can run a per-project version of PHPUnit with `/vendor/bin/phpunit`.

2) Install WordPress and the WP Unit Test library using the `install.sh` script located in `give/tests/bin/` directory. Change to the plugin root directory and type:

    `$ tests/wordpress/bin/install.sh <db-name> <db-user> <db-password> [db-host]`

Sample usage: `$ tests/bin/install.sh give_tests root root`

Note: Running the installer a second time will not update the WordPress configuration. Instead, when making changes to the database and/or database user these values will need to be updated directly in `tmp/wordpress-tests-lib/wp-tests-config.php` (or the relative file on your operating system).

**Important**: The `<db-name>` database will be created if it doesn't exist and all data will be removed during testing.

For more information on how to write PHPUnit Tests, see [PHPUnit's Website](http://www.phpunit.de/manual/3.6/en/writing-tests-for-phpunit.html).

Are you using Pressmatic? Check out this [helpful article](https://tommcfarlin.com/unit-testing-with-pressmatic/) by Tom McFarlin on setting up PHPUnit on Pressmatic. 

## Loading dependent plugins

The core Give plugin and the Divi Builder plugin need to be symlinked to the test WordPress install, here is an example command for symlinking a local copy to the tmp directory:

`ln -s ~/Code/impress-org/givewp /tmp/wordpress/wp-content/plugins/give`
`ln -s ~/Code/divi/divi-builder /tmp/wordpress/wp-content/plugins/divi-builder`

Note: Ignore the deprecated notice thrown by Divi Builder.

Note: I tried installing Give from the WordPress.org download link, but ran into an error that I have not been able to resolve. Therefor the plugin needs to be loaded manually. This might actually be a better way, since it provides control over what versioning.

## Running Tests

Change directory to the plugin root directory and run:

    $ phpunit

The tests will execute and you'll be presented with a summary. Code coverage documentation is automatically generated as HTML in the `tmp/coverage` directory.

You can run specific tests using `--filter` followed by the class name and method to test:

    $ phpunit --filter Tests_Templates::test_get_donation_form

A text code coverage summary can be displayed using the `--coverage-text` option:

    $ phpunit --coverage-text


## Writing Tests

* Each test method should cover a single method or function with one or more assertions
* A single method or function can have multiple associated test methods if it's a large or complex method
* Use the test coverage HTML report (under `tmp/coverage/index.html`) to examine which lines your tests are covering and aim for 100%® coverage
* Prefer `assertsEquals()` where possible as it tests both type & equality
* Only methods prefixed with `test` will be run so use helper methods liberally to keep test methods small and reduce code duplication.
* Use data providers where possible. Read more about data providers [here](https://phpunit.de/manual/current/en/writing-tests-for-phpunit.html#writing-tests-for-phpunit.data-providers).
* Filters persist between test cases so be sure to remove them in your test method or in the `tearDown()` method.

## Automated Tests

Tests are automatically run via [Github Actions](https://github.com/impress-org/givewp/actions) for each commit and pull request.
