# Release Checklist for v2.0.0

## Pre-Release Steps

- [x] Update composer.json version to 2.0.0
- [x] Update CHANGELOG.md with v2.0.0 changes
- [x] Create API.md documentation
- [x] Update README.md with migration guide
- [x] Add new feature tests
- [x] Verify all tests pass

## Release Steps

1. **Commit all changes:**
   ```bash
   git add .
   git commit -m "Release v2.0.0: Add custom headers, custom arguments, fix authentication"
   ```

2. **Create and push tag:**
   ```bash
   git tag -a v2.0.0 -m "Version 2.0.0 - Major release with MX18 API v1 compatibility"
   git push origin v2.0.0
   ```

3. **Push to main branch:**
   ```bash
   git push origin main
   ```

4. **Packagist will auto-update** (if webhook is configured)

## Post-Release

- [ ] Verify package appears on Packagist
- [ ] Test installation: `composer require ankitfromindia/mx18-laravel:^2.0`
- [ ] Update documentation if needed

## Breaking Changes Summary

- Authentication method changed from `Authorization: Bearer` to `X-Api-Key`
- This is internal change - no user code changes required
- Added new methods: `headers()` and `customArguments()`

## New Features

- Custom email headers support
- Custom arguments for tracking/analytics
- Full MX18 API v1 specification compliance
- Enhanced documentation and examples
