/*global describe, beforeEach, it */
'use strict';
var path = require('path');
var helpers = require('yeoman-generator').test;

describe('wc-extension generator', function () {
  beforeEach(function (done) {
    helpers.testDirectory(path.join(__dirname, 'temp'), function (err) {
      if (err) {
        return done(err);
      }

      this.app = helpers.createGenerator('wc-extension:app', [
        '../../app'
      ]);
      done();
    }.bind(this));
  });

  it('creates expected files', function (done) {
    var expected = [
      // add files you expect to exist here.
      'assets/css/wc-extension-boilerplate-frontend.css',
      'assets/js/wc-extension-boilerplate-admin.js',
      'assets/js/wc-extension-boilerplate-admin.min.js',
      'assets/js/wc-extension-boilerplate-frontend.js',
      'assets/js/wc-extension-boilerplate-frontend.min.js',
      'assets/scss/wc-extension-boilerplate-frontend.scss',
      'includes/class-wc-extension-boilerplate-admin-settings.php',
      'includes/class-wc-extension-boilerplate-admin.php',
      'includes/class-wc-extension-boilerplate-admin-cart.php',
      'includes/class-wc-extension-boilerplate-admin-compatibility.php',
      'includes/class-wc-extension-boilerplate-admin-display.php',
      'includes/class-wc-extension-boilerplate-admin-helpers.php',
      'includes/class-wc-extension-boilerplate-admin-order.php',
      'includes/wc-extension-boilerplate-template-functions.php',
      'includes/wc-extension-boilerplate-template-hooks.php',
      'languages/woocommerce-extension-boilerplate.pot',
      'templates/single-product/sample-template.php',
      'woo-includes/class-wc-dependencies.php',
      'woo-includes/woo-functions.php',
      '.gitignore',
      'changelog.txt',
      'Gruntfile.js',
      'LICENSE',
      'readme.md',
      'readme.txt',
      'wc-extension-boilerplate.php',
    ];

    helpers.mockPrompt(this.app, {
      'someOption': true
    });
    this.app.options['skip-install'] = true;
    this.app.run({}, function () {
      helpers.assertFile(expected);
      done();
    });
  });
});
