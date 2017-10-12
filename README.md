# About

# Getting started
1. Clone this repository
1. Rename main plugin file and folder
1. Delete composer.lock
1. Find and replace all
   1. MyPluginNamespace
   1. my-plugin
   1. My Plugin
1. Run composer install
1. Run NPM install
1. Activate the plugin

## Build, run and Deploy

### Browsersync
To run browsersync, change the url in gulpfile.js and run ```npm run serve```

### Watch
Will watch for changes 
```npm run watch```

### Build
1 time build
```npm run build```

### Deploy
Will create a zippable and minified version to use as plugin inside /dist
```npm run deploy```

## Todo
