'use strict';
module.exports = function (grunt) {
  require('load-grunt-tasks')(grunt);
	
  // Project configuration.
  grunt.initConfig({
	pkg: grunt.file.readJSON('package.json'),

	clean: {
	  main: {
	    src: ["app/templates"]
	  },
	},
	copy: {
		main: {
			expand: true,
			dot: true,
			cwd: 'app/src/',
			src:  [
				'**',
				'!node_modules/**',
				'!.sass-cache/**',
				'!.git/**',
				'!.git',
				'!*.sublime-workspace',
				'!*.sublime-project',
			],
			dest: 'app/templates/',
	    	options: {
	    		process: function (content, srcpath) {
	    	    	content = content.replace(/(Kathy Darling)/g, "<%= opts.authorName %>");
	    	    	content = content.replace(/(WooCommerce Extension Boilerplate)/g, "<%= opts.projectTitle %>");
	    	    	content = content.replace(/(woocommerce-extension-boilerplate)/g, "<%= opts.projectSlug %>");
	    	    	content = content.replace(/(WC_Extension_Boilerplate)/g, "<%= opts.classPrefix %>");
	    	    	content = content.replace(/(wc_extension_boilerplate)/g, "<%= opts.funcPrefix %>");
	    	    	content = content.replace(/(wc-extension-boilerplate)/g, "<%= opts.textDomain %>");
	    	    	content = content.replace(/(2016.01.09)/g, "<%= opts.releaseDate %>");
	    	    	content = content.replace(/(2016)/g, "<%= opts.Year %>");
	    	    	content = content.replace(/<%= pkg\.(.*?) %>/g, "<%% pkg.$1 %%>");
	    	    	content = content.replace(/<%= grunt\.(.*?) %>/g, "<%% grunt.$1 %%>");
	    	    	return content;
	      		}
	    	},

		}
	}

});

// prep template for use as yeoman generator
grunt.registerTask( 'default', ['clean', 'copy'] );

};
