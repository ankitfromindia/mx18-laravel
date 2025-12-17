# Changelog

All notable changes to `mx18-laravel` will be documented in this file.

## 2.1.0 - 2025-12-17

### Added
- `addRecipient()` method for efficient bulk email sending
- Support for multiple recipients with individual personalization in single API call

### Improved
- More efficient bulk email handling without requiring separate MX18Mail objects per recipient

## 2.0.0 - 2025-12-17

### Added
- Custom headers support via `headers()` method
- Custom arguments support via `customArguments()` method
- Full compatibility with MX18 API v1 specification
- Enhanced documentation with complete API examples

### Changed
- **BREAKING**: Authentication changed from `Authorization: Bearer` to `X-Api-Key` header
- Updated API client to match official MX18 API specification
- Improved error handling and response parsing

### Fixed
- API authentication method now correctly uses X-Api-Key header
- Resolved compatibility issues with MX18 API v1

## 1.2.0 - 2025-12-16

### Changed
- Updated minimum PHP requirement to 8.3+
- Added support for Laravel 12.x
- Updated PHPUnit to version 10.0+
- Updated Orchestra Testbench for Laravel 12 compatibility
- Dropped support for PHP 8.0-8.2 and Laravel 8.x-9.x

## 1.1.0 - 2025-12-16

### Added
- Laravel 8.x support
- PHP 8.0 support
- Backward compatibility with older Laravel versions

### Changed
- Updated minimum requirements to support Laravel 8+
- Updated test dependencies for broader compatibility

## 1.0.0 - 2025-12-16

### Added
- Initial release
- Send single emails via MX18 API
- Send bulk emails
- Webhook handling with signature verification
- Support for HTML/text content
- File attachments support
- Email personalization
- CC/BCC recipients
- Laravel auto-discovery
- Comprehensive documentation
