GENERATOR
---------
ENCORE
- init
- init:vue
- init:react
- init:sass
- init:less
- init:postcss
- init:typescript
- logging, including recommendations
- react hot loading

## init
- interactively ask questions, but just assume a lot
	- Choose an output path: [web/build]
	- What's the public path to web/build? [/build]
	- Are you creating a single page app SPA or will you have multiple pages?
		- if SPA
			- Great! We'll bootstrap a small app. What type:
				- JavaScript
				- Vue.js
				- React
		- if multi page
			- Cool! We'll create a "global" entry that will be included on all pages.

			

	- SPA or multiple pages?
	- react, vue, typescript?
	- assumes sass
	- assumes postcss
	- assumes linting
	-> directions on what it did
	-> directions on what link/script tags to add
	-> inform them to run add:entry for multi-page (maybe even ask them)

- runs "yarn add" for a bunch of things
- creates a webpack.config.js file with defaults, comments, commented-out
	features, etc
	- // autoProvidejQuery
	- // enableVersioning()
	- cleanupOutputBeforeBuild()
- add browser key to package.json
- adds a few entries to .gitignore
- generates a few basic assets
	- assets/app.js
	- assets/app.sass
	- generates some tests (react uses jest)
- run only one time


DIFFERENT APP TYPES
	- SPA Angular
	- SPA React
	- MPA
	- MPA with Angular
	- MPA with React

SPA
	- assets/
		app/
			- main.js
			- main.scss
		- images/

MPA
	- assets/
		# included on every page
		- app
			- app.js
			- app.scss
			- images/

		# page-specific entry
		- checkout
			- checkout.js
			- checkout.scss
			- images/

- handle globally-executed JS
- internally, we have an "addEntry" task, which can be traditional, vue or React



MY IDEAL FLOW
- Initially, I run init, and it gets me all setup
- later, I realize I want less, so I run add:less
	Encore.enableLess();
- later, I need a new entry, so I run add:entry

TODOS
-----

- should we have more output? All I see after the first build is:
    Compiled successfully in 1472ms 
    + 2 hidden modules
- need to add a GH issue template
- upgrade to latest webpack and test things

LATER
-----
- add logging and, for example, advertise what we're
    doing with the .babelrc file

- add some sort of init script? It would:
    - .gitignore /node_modules (maybe output path, guessed?)
    - it would create a sample webpack.config.js

- they add a note on top of the config files
    // Note: You must restart bin/webpack-dev-server for changes to take effect

- they make me think our loaders (buildRulesConfig) code could
    be cleaned up to be more readable!

- for react, they install prop-types
    - so, how can we encourage them to install *all*
        necessary deps


## LESS IMPORTANT
- should we think about how a user might, in theory, have a
     vendor entry (for caching) and also some sort of "common"
     entry that's included on every page? Should we really push
     that "commons" entry to be a vendor... not things with your
     code?
- create an example repository
- Check out sourcemap warning on this page
    https://webpack.js.org/loaders/style-loader/
      > Note about source maps support and assets...
- sourcemaps ARE dumped in SASS files... always :/
