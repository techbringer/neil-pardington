module.exports = function(grunt) {
	
	grunt.initConfig({
		compass: {
			dist: {
				options: {
					sassDir: 'scss',
					cssDir: 'css',
					environment: 'production',
					outputStyle: 'compressed'
				}
			}
		},
		
		
		watch: {
			css: {
				files: 'scss/*.scss',
				tasks: ['compass:dist'],
				options: {
					event: ['all'],
					livereload: true,
				},
			},
			sprites: {
				files: 'img/sprites/*.png',
				tasks: ['compass:dist'],
				options: {
					event: ['all'],
					livereload: true,
				}
			},
			js: {
				files: ['js/pagetypes/*.js'],
				task: ['jshint']
			}
		}
	});
	
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-requirejs');
	grunt.loadNpmTasks('grunt-contrib-watch');
/* 	grunt.loadNpmTasks('grunt-imageoptim'); */
	grunt.loadNpmTasks('grunt-contrib-jshint');
	
	grunt.registerTask('default', ['compass:dist']);
	grunt.registerTask('production', ['compass:dist', 'requirejs:compile']);//, 'imageoptim']);
}
