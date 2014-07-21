module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {
            // 2. Configuration for concatinating files goes here.
            dist: {
                src: [
                    'js/vendor/*.js',
                    'js/build/*.js'
                ],
                dest: 'js/deploy/production.js',
            }
        },
        
        jshint: {
            src: ['js/build/*.js']
        },

        uglify: {
            build: {
                src: 'js/deploy/production.js',
                dest: 'js/deploy/production.min.js'
            }
        },

        imagemin: {
            dynamic: {
                files: [{
                    expand: true,
                    cwd: 'img/build',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: 'img/deploy/'
                }]
            }
        },

        sass: {
            dist: {                            // Target
                options: {                      // Target options
                    style: 'expanded'
                },
                files: {                         // Dictionary of files
                    'css/seperate/main.css': 'scss/main.scss',   
                    'css/styleguide/sg.css': 'scss/sg.scss'     // 'destination': 'source'
                }

            }
        },

        cssmin: {
            combine: {
                files: {
                    'css/combined/main.css': ['css/seperate/*.css']
                }
            },
            minify: {
                src: 'css/combined/main.css',
                dest: 'style.css'
            }
        },

        watch: {
            options: {
                livereload: true,
            },
            scripts: {
                files: ['js/build/*.js'],
                tasks: ['concat', 'jshint','uglify'],
                options: {
                    spawn: false,
                }
            },
            css: {
                files: 'scss/**/*.scss',
                tasks: ['sass', 'cssmin'],
                options: {
                    spawn: false,
                }
            }
        }

    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['concat', 'uglify', 'jshint', 'sass', 'cssmin', 'imagemin']);
};