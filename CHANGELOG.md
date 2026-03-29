# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [1.0.0] - 2026-03-29

### Changed
- Upgraded to Saloon v4 (patches CVE-2026-33942, CVE-2026-33182, CVE-2026-33183)
- Bumped minimum PHP version to 8.2
- Authentication now uses Bearer token (was Token prefix)
- Reorganized requests into subdirectory structure per resource
- Resources now extend Saloon's BaseResource
- All DTOs use readonly properties with proper type narrowing
- Updated dev dependencies: Pest v3, PHPStan v2, symfony/var-dumper v7
- Updated CI workflows for PHP 8.2/8.3/8.4

### Added
- Models resource: list, get, create, update, delete, createPrediction
- Model versions: getVersion, listVersions, deleteVersion
- Deployments resource: list, get, create, update, delete, createPrediction
- Trainings resource: list, get, create, cancel
- Files resource: list, get, upload, delete
- Collections resource: list, get
- Hardware resource: list
- Webhooks resource: getSecret
- Account resource: get
- Prediction cancel endpoint (was orphaned in previous version)
- Synchronous predictions via `wait` parameter (Prefer: wait header)
- Streaming support via `stream` parameter
- Webhook support directly on create methods
- 17 typed DTOs covering every API response
- `fromArray()` static factory on entity DTOs for nested construction

### Fixed
- Trailing newline in PostPredictionCancel endpoint URL
- PredictionsData reading `model` from wrong JSON level
- Missing null-coalescing on nullable fields in list responses

### Removed
- Custom Resource base class (replaced by Saloon's BaseResource)
- Mutable webhook state on PredictionsResource (replaced by direct parameters)
