# craft-hcaptcha Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 2.0.1 - 2022-06-08
### Fixed
- Removed hostname check because it's not reliable ([#2](https://github.com/c10d-dev/craft-hcaptcha/issues/2), thanks @lmcnearney)
- Avoid possible crash when database table is not present

## 2.0.0 - 2022-06-01
### Changed
- Now requires PHP ^8.0.2.
- Now requires Craft ^4.0.0.

## 1.2.0 - 2022-05-31
### Added
- Added utility section with success rate and logs

## 1.1.1 - 2021-10-19
### Fixed
- Fixed registration form validation for new users only

## 1.1.0 - 2021-05-09
### Removed
- Removed Guzzle dependency

## 1.0.2 - 2021-05-08
### Fixed
- Fixed user captcha validation, only for site requests

## 1.0.1 - 2021-05-03
### Fixed
- Changed name to comply with rules for Craft Plugins

## 1.0.0 - 2021-04-24
### Added
- Initial release
