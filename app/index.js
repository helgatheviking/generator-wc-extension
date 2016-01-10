'use strict';
var util = require( 'util' );
var path = require( 'path' );
var yeoman = require( 'yeoman-generator' );
var chalk = require( 'chalk' );
var async = require( 'async' );


var WC_Generator = yeoman.generators.Base.extend({
	init: function () {
		this.log( chalk.cyan( 'Welcome to the WooCommerce Extension generator!' ));

		this.on( 'end', function () {
			var i, length, installs = [],
				chalks = { skipped:[], run:[] },
			//	installers = ['npm'];
				installers = [];

			this.log( chalk.green.bold( 'Your plugin has been generated.' ));

			for ( i = 0, length = installers.length; i < length; i++ ) {
				if ( this.options['skip-install'] || this.options[ 'skip-' + installers[ i ] ] ) {
					chalks.skipped.push( chalk.yellow.bold( installers[ i ] + ' install' ));
				} else {
					chalks.run.push( chalk.yellow.bold( installers[ i ] + ' install' ));
					installs.push( _install( installers[ i ],this ));
				}
			}
			
			if ( 0 < chalks.skipped.length ) {
				this.log( 'Skipping ' + chalks.skipped.join( ', ' ) + '. Just run yourself when you are ready.' );
			}
			if ( 0 < installs.length ) {
				this.log( 'Running ' + chalks.run.join( ', ' ) + ' for you. If this fails try running yourself.' );
				async.parallel( installs );
			}
		});

	},

	options: function () {
		var done = this.async();
		this.basename = path.basename( this.env.cwd );

		var prompts = [
			{
				name:    'projectTitle',
				message: 'Project title',
				default: 'WC Boilerplate'
			},
			{
				name:    'classPrefix',
				message: 'Class prefix',
				default: 'WC_Boilerplate'
			},
			{
				name:    'description',
				message: 'Description',
				default: 'The best WordPress extension ever made!'
			},
			{
				name:    'projectHome',
				message: 'Project homepage',
				default: 'http://github.com/'
			},
			{
				name:    'authorName',
				message: 'Author name',
				default: this.user.git.name
			},
			{
				name:    'authorEmail',
				message: 'Author email',
				default: this.user.git.email
			},
			{
				name:    'authorUrl',
				message: 'Author URL'
			}
		];
		// gather initial settings
		this.prompt( prompts, function ( props ) {
			this.opts = props;
			this.opts.projectSlug = this.opts.projectTitle.toLowerCase().replace( /[\s]/g, '-' ).replace( /[^a-z-_]/g, '' );
			this.opts.classPrefix = this.opts.classPrefix.replace( /[\s]/g, '_' );
			this.opts.funcPrefix = this.opts.classPrefix.toLowerCase();
			this.opts.textDomain = this.opts.funcPrefix.replace( /[\s|_]/g, '-' );
			this.fileSlug = this.opts.projectSlug;
			this.namespace = this.opts.projectTitle.replace( /[\s|-]/g, '_' ).replace( /( ^|_ )( [a-z] )/g, function( match, group1, group2 ){
				return group1 + group2.toUpperCase(); 
			});
			var today = new Date();
			var month = today.getMonth() + 1;
			var day = today.getDay();

			this.opts.Year = today.getFullYear();
			this.opts.releaseDate = this.opts.Year + '.' + month + '.' + day;
			done();
		}.bind( this ));
	},

	plugin: function() {
		this.template( 'readme.txt', 'readme.txt' );
		this.template( 'changelog.txt', 'changelog.txt' );
		this.template( 'wc-extension-boilerplate.php', this.fileSlug + '.php' );
		this.template( 'includes/class-wc-extension-boilerplate-admin-settings.php', 'includes/class-' + this.opts.funcPrefix + '-admin-settings.php' );
		this.template( 'includes/class-wc-extension-boilerplate-admin.php', 'includes/class-' + this.opts.funcPrefix + '-admin.php' );
		this.template( 'includes/class-wc-extension-boilerplate-cart.php', 'includes/class-' + this.opts.funcPrefix + '-cart.php' );
		this.template( 'includes/class-wc-extension-boilerplate-compatibility.php', 'includes/class-' + this.opts.funcPrefix + '-compatibility.php' );
		this.template( 'includes/class-wc-extension-boilerplate-display.php', 'includes/class-' + this.opts.funcPrefix + '-display.php' );
		this.template( 'includes/class-wc-extension-boilerplate-helpers.php', 'includes/class-' + this.opts.funcPrefix + '-helpers.php' );
		this.template( 'includes/class-wc-extension-boilerplate-order.php', 'includes/class-' + this.opts.funcPrefix + '-order.php' );
		this.template( 'includes/wc-extension-boilerplate-template-functions.php', 'includes/' + this.opts.funcPrefix + '-template-functions.php' );
		this.template( 'includes/wc-extension-boilerplate-template-hooks.php', 'includes/' + this.opts.funcPrefix + '-template-hooks.php' );
		this.copy( 'templates/single-product/sample-template.php', 'templates/single-product/sample-template.php' );
		this.copy( 'woo-includes/class-wc-dependencies.php', 'woo-includes/class-wc-dependencies.php' );
		this.copy( 'woo-includes/woo-functions.php', 'woo-includes/woo-functions.php' );
	},

	i18n: function() {
		this.template( 'languages/woocommerce-extension-boilerplate.pot', 'languages/' + this.fileSlug + '.pot' );
	},

	js: function() {
		this.template( 'assets/js/wc-extension-boilerplate-frontend.js', 'assets/js/' + this.fileSlug + '-frontend.js' );
		this.template( 'assets/js/wc-extension-boilerplate-admin.js', 'assets/js/' + this.fileSlug + '-admin.js' );
	},

	scss: function() {
		this.template( 'assets/scss/wc-extension-boilerplate-frontend.scss', 'assets/scss/' + this.fileSlug + '-frontend.scss' );
	},

	css: function() {
		this.template( 'assets/css/wc-extension-boilerplate-frontend.css', 'assets/css/' + this.fileSlug + '-frontend.css' );
	},

	grunt: function() {
		this.template( 'package.json', 'package.json' );
		this.template( 'Gruntfile.js', 'Gruntfile.js' );
	},

	git: function() {
		this.copy( '.gitignore', '.gitignore' );
	}

});

function _install( command, context ) {
	return function install( cb ) {
		context.emit( command + 'Install' );
		context.spawnCommand( command, ['install'] )
		.on( 'error', cb )
		.on( 'exit', context.emit.bind( context, command + 'Install:end' ))
		.on( 'exit', function ( err ) {
			if ( err === 127 ) {
				this.log.error( 'Could not find Composer' );
			}
			cb( err );
		}.bind( context ));
	}
}

module.exports = WC_Generator;