'use strict';

module.exports = function (grunt) {


    grunt.initConfig({
        less: {
          development: {
            files: {
              "public/styles/css/styles.css": "dev/styles/styles.less" // destination file and source file
            }
          }
        },
        watch: {
          styles: {
            files: ['dev/styles/**/*.less'], // which files to watch
            tasks: ['less:development'],
            options: {
              nospawn: true
            }
          }
        }
      });
      grunt.loadNpmTasks('grunt-contrib-less');
      grunt.loadNpmTasks('grunt-contrib-watch');
      grunt.registerTask('default', ['less', 'watch']);
    };