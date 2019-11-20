# BugSpring

[![GitHub release](https://img.shields.io/github/release/bugspring/BugSpring.svg)](https://github.com/bugspring/BugSpring/releases/latest)
[![license](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/bugspring/BugSpring/blob/master/LICENSE)
[![Build Status](https://github.com/BookStackApp/BookStack/workflows/phpunit/badge.svg)](https://github.com/bugspring/BugSpring/actions)
![GitHub last commit](https://img.shields.io/github/last-commit/bugspring/BugSpring)


A modern Bugtracker build with Laravel and VueJS.

## Getting Started


These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.


### Prerequisites

The following software is needed to install and run BugSpring:
- php
- composer
- npm


### Installing


After cloning the repository.
```shell
> git clone https://github.com/bugspring/BugSpring.git
```

You need to ```cd``` into the cloned repository.
```shell
> cd BugSpring
```

In the directory, configure the application.
You need at least to set the database configuration. The rest can be left at their default.
```bash
> cp .env.example .env
> nano .env
```

Now ```composer install``` can be called.
This will 
* install php dependencies
* generate the APP_KEY (set in the .env)
* run the database migrations
* install laravel/passport
```shell
> composer install
```

## Running the tests

To run the tests, just call the phpunit script in the vendor/bin/ folder.

```shell
> vendor/bin/phpunit --testdox
```

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/bugspring/BugSpring/tags). 

## Authors

* [nipeco](https://github.com/nipeco)
* [DrDynamic](https://github.com/DrDynamic)

See also the list of [contributors](https://github.com/bugspring/BugSpring/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone whose code was used
