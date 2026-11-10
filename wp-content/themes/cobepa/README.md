# Wordpress Starter Theme
A starter theme for kicking off WP projects. It's based upon the [Timber framework](https://www.upstatement.com/timber/) for speeding up the development process.

## Download
Download this theme and add it to the "wp-content/themes" folder.

## Installation
Navigate to the theme folder and install npm packages. This will also install [composer](https://getcomposer.org/), a package manager for PHP. Install composer packages in the next step.
```
npm install or npm i
```
Wait for npm to finish installing, then:
```
composer install
```

## Development
Run the dev command
```
npm run dev
```
The development evironment uses Webpack to handle CSS, JS, SVG,... . [Browsersync](https://github.com/Browsersync/browser-sync) is included to reload the page automatically after a change has been made to CSS, JS, PHP & Twig files.

## Production
Make sure there is a .babelrc file in the root, this has options that will compile ES6 to ES5.
```
npm run build
```

## Documentation
[Timber](https://timber.github.io/docs/)

[composer](https://getcomposer.org/)
