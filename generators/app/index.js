'use strict';
const Generator = require('yeoman-generator');
const chalk = require('chalk');
const yosay = require('yosay');

module.exports = class extends Generator {

  initializing() {
    this.props = {};
  }

  prompting() {
    // Have Yeoman greet the user.
    this.log(yosay(
      'Welcome to the WooCommerce Extension generator!'
    ));

    const prompts = [
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

    return this.prompt(prompts).then(props => {
      // To access props later use this.props.projectTitle;
      this.props = props;
    });
  }

  // Sanitize inputs.
  default() {
    this.props.projectSlug = this.props.projectTitle.toLowerCase().replace( /[\s]/g, '-' ).replace( /[^a-z-_]/g, '' );
    this.props.classPrefix = this.props.classPrefix.replace( /[\s]/g, '_' );
    this.props.funcPrefix = this.props.classPrefix.toLowerCase();
    this.props.textDomain = this.props.funcPrefix.replace( /[\s|_]/g, '-' );
    this.props.fileSlug = this.props.textDomain;
    this.props.namespace = this.props.projectTitle.replace( /[\s|-]/g, '_' ).replace( /( ^|_ )( [a-z] )/g, function( match, group1, group2 ){
      return group1 + group2.toUpperCase(); 
    });
    var today = new Date();
    var month = today.getMonth() + 1;
    var day = today.getDay();

    this.props.Year = today.getFullYear();
    this.props.releaseDate = this.props.Year + '.' + month + '.' + day;
  }

  writing() {

    this.fs.copyTpl( this.templatePath( 'readme.txt' ), this.destinationPath( 'readme.txt' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'changelog.txt' ), this.destinationPath( 'changelog.txt' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'wc-extension-boilerplate.php' ), this.destinationPath( this.props.fileSlug + '.php' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'includes/class-wc-extension-boilerplate-admin-settings.php' ), this.destinationPath( 'includes/class-' + this.props.fileSlug + '-admin-settings.php' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'includes/class-wc-extension-boilerplate-admin.php' ), this.destinationPath( 'includes/class-' + this.props.fileSlug + '-admin.php' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'includes/class-wc-extension-boilerplate-cart.php' ), this.destinationPath( 'includes/class-' + this.props.fileSlug + '-cart.php' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'includes/class-wc-extension-boilerplate-compatibility.php' ), this.destinationPath( 'includes/class-' + this.props.fileSlug + '-compatibility.php' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'includes/class-wc-extension-boilerplate-display.php' ), this.destinationPath( 'includes/class-' + this.props.fileSlug + '-display.php' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'includes/class-wc-extension-boilerplate-helpers.php' ), this.destinationPath( 'includes/class-' + this.props.fileSlug + '-helpers.php' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'includes/class-wc-extension-boilerplate-order.php' ), this.destinationPath( 'includes/class-' + this.props.fileSlug + '-order.php' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'includes/wc-extension-boilerplate-template-functions.php' ), this.destinationPath( 'includes/' + this.props.fileSlug + '-template-functions.php' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'includes/wc-extension-boilerplate-template-hooks.php' ), this.destinationPath( 'includes/' + this.props.fileSlug + '-template-hooks.php' ), { props: this.props } );
    this.fs.copy( this.templatePath( 'templates/single-product/sample-template.php' ), this.destinationPath( 'templates/single-product/sample-template.php' ) );
    this.fs.copy( this.templatePath( 'woo-includes/class-wc-dependencies.php' ), this.destinationPath( 'woo-includes/class-wc-dependencies.php' ) );
    this.fs.copy( this.templatePath( 'woo-includes/woo-functions.php' ), this.destinationPath( 'woo-includes/woo-functions.php' ) );
    this.fs.copyTpl( this.templatePath( 'languages/woocommerce-extension-boilerplate.pot' ), this.destinationPath( 'languages/' + this.props.fileSlug + '.pot' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'assets/js/wc-extension-boilerplate-frontend.js' ), this.destinationPath( 'assets/js/' + this.props.fileSlug + '-frontend.js' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'assets/js/wc-extension-boilerplate-admin.js' ), this.destinationPath( 'assets/js/' + this.props.fileSlug + '-admin.js' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'assets/scss/wc-extension-boilerplate-frontend.scss' ), this.destinationPath( 'assets/scss/' + this.props.fileSlug + '-frontend.scss' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'assets/css/wc-extension-boilerplate-frontend.css' ), this.destinationPath( 'assets/css/' + this.props.fileSlug + '-frontend.css' ), { props: this.props } );
    this.fs.copyTpl( this.templatePath( 'package.json' ), this.destinationPath( 'package.json' ), { props: this.props } );
    this.fs.copy( this.templatePath( 'Gruntfile.js' ), this.destinationPath( 'Gruntfile.js' ) );
    this.fs.copy( this.templatePath( '.gitignore' ), this.destinationPath( '.gitignore' ) );

  }

  install() {
    this.installDependencies({
      bower: false,
    });
  }


  end() {
    // Have Yeoman say goodbye.
    this.log(yosay(
      'Your plugin has been generated.'
    ));
  }

};
