# groton-school/slim-gae-shim

Shim for Slim Skeleton to run on Google App Engine

[![Latest Version](https://img.shields.io/packagist/v/groton-school/slim-gae-shim.svg)](https://packagist.org/packages/groton-school/slim-gae-shim)

## Install

```bash
composer require groton-school/slim-gae-shim
```

## Use

The shim expects a default [slim-skeleton](https://github.com/slimphp/Slim-Skeleton#readme) layout (and configures GAE to reflect this).

1. In your `composer.json` add a `post-update-cmd` update script:

```json
{
  "scripts": {
    "post-update-cmd": "GrotonSchool\\Slim\\GAE\\Scripts::installGAEFiles"
  }
}
```

2. Run `composer update`

3. Optionally, add `*.bak` to your `.gitignore` to suppress backed up prior versions of the GAE config files

4. Inject Google App Engine environment variables into settings:

   a. [Implement `SettingsInterface`](https://github.com/groton-school/slim-skeleton/blob/9431c827f440648768d8f5d75630c84be4b8b428/src/Application/Settings/SettingsInterface.php#L11-L12)

   b. [Define the `SettingsInterface` dependency](https://github.com/groton-school/slim-skeleton/blob/9431c827f440648768d8f5d75630c84be4b8b428/app/dependencies.php#L46)

   c. [Inject the project URL and ID into your settings](https://github.com/groton-school/slim-skeleton/blob/9431c827f440648768d8f5d75630c84be4b8b428/app/settings.php#L24-L25)

5. Optionally (but recommendedly), suppress error log messages about Google App Engine start/stop requests by...

   d. [Definine routes for those requests](https://github.com/groton-school/slim-skeleton/blob/9431c827f440648768d8f5d75630c84be4b8b428/app/routes.php#L22)

6. Deploy to Google App Engine using the [Node](https://nodejs.) `deploy` wizard provided.

   a. Configure a [Billing Account](https://console.cloud.google.com/billing) with your Google Cloud account, if not already done.

   b. [Install the `gcloud` CLI](https://cloud.google.com/sdk/docs/install)

   c. Install Node dependencies with the package manager of your choice (e.g. `pnpm install`)

   d. Run the deploy wizard (`pnpm run deploy`) interactively (after the first run, this will set environment variables to allow it to be run non-interactively in the future)

### groton-school/slim-skeleton@dev-lti/gae

[groton-school/slim-skeleton](https://github.com/groton-school/slim-skeleton/tree/lti/gae) is the canonical example of how this shim is meant to be used.
