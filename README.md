# Pitchfork Plugin

A plugin for use with the [Pitchfork theme](https://github.com/asuengineering/pitchfork) for WordPress.

This plugin adds blocks and block patterns for the block editor consistent with the ASU Unity Design system for web standards.

Requires at least: WP 6.0
Tested up to: 6.0
Requires PHP: 7.3
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

**Contributors**

- Steve Ryan (ASU Engineering)

## Usage Requirements

- Download the lastest release from Github.
- Install in the normal WP location for plugins which is typically `/wp-content/plugins`.

**Recommended / Required Additional Plugins**

This plugin contains blocks that are constructed with the use of Advanced Custom Fields Pro.

- The ACF Pro plugin is also required by the Pitchfork theme.
- ASU Engineering provides a licensed copy of this plugin within its standard distribution of WordPress on the Pantheon hosting platform.

Plugin updates can optionally be managed from the admin dashboard through the use of [Git Updater](https://git-updater.com/) or [WP Pusher](https://wppusher.com).

## Includes

- This plugin implements styles and cofigurations of the [Glide.js](https://glidejs.com/) library that can be found within the [UDS React Core library](https://asu.github.io/asu-unity-stack/@asu/unity-react-core/).
- However, the `@asu/unity-react-core` library is not a dependency and is never included or enqueued directly.

## Development

- Run `npm install` prior to local development.
- SASS and JS compile & watch tasks are triggered via Gulp-WP and `npx gulp-wp` from the project root.

## Release Notes

See [CHANGELOG.md](CHANGELOG.md) for the a list of all improvements made to the theme.

We also keep similar notes in the [releases section](https://github.com/asuengineering/pitchfork-blocks/releases) of our project for an overview of what changed with each release.
