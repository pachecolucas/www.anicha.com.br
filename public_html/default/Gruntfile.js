module.exports = function (grunt) {

    grunt.initConfig({
        //--Watch
        watch: {
            css: {
                files: [
                    'css/**/*',
                    'vendors/**/*',
                    'less/**/*',
                ],
                tasks: ['less', 'csso'],
            },
            js: {
                files: [
                    'js/**/*',
                ],
                tasks: ['uglify'],
            }
        },
        //-- Compilador de LESS
        less: {
            production: {
                options: {
                    cleancss: true
                },
                files: {
//                    'css/less-font-awesome.css': 'vendors/font-awesome/less/font-awesome.less',
//                    'css/less-style2.css': 'less/less-style.less'
                    'css/style-min.css': 'css/style.less'
                }
            }
        },
        //-- Concatenação e Minificação CSS
        csso: {
            compress: {
                options: {
//                    report: 'gzip'
                },
                files: {
                    'min/sty2.css': [
                        // template
                        'css/bootstrap.min.css',
                        'css/vendors.css',
                        'css/style-min.css',
                        'css/components.css',
                        'slider-revolution/css/settings.css',
                        'slider-revolution/css/layers.css',
//                        'slider-revolution/css/navigation.css',
                        //  ePanel
                        'vendors/messenger-1.4.1/build/css/messenger.css',
//                        'vendor/messenger-1.4.1/build/css/messenger-theme-flat.css',
                        'vendors/messenger-1.4.1/build/css/messenger-theme-future.css',
                    ]
                }
            },
        },
        //--Uglify (Minificação/Concatenação JS)
        uglify: {
            options: {
                mangle: false // Specify (mangle: false) to prevent changes to your variable and function names.
            },
            my_target: {
                files: {
                    'min/lib1.js': [
                        // TEMPLATE
                        'js/jquery.min.js', // jQuery
                        'js/bootstrap.min.js',
                        'slider-revolution/js/jquery.themepunch.tools.min.js',
                        'slider-revolution/js/jquery.themepunch.revolution.min.js',
                        'slider-revolution/js/extensions/revolution.extension.parallax.min.js',
                        'slider-revolution/js/extensions/revolution.extension.video.min.js',
                        'slider-revolution/js/extensions/revolution.extension.slideanims.min.js',
                        'slider-revolution/js/extensions/revolution.extension.navigation.min.js',
                        'slider-revolution/js/extensions/revolution.extension.layeranimation.min.js',
                        'js/owl.carousel.min.js',
                        'js/bootstrap-select.min.js',
                        'js/jquery-ui.min.js',
                        'js/script.js',
                        // ePanel
                        'vendors/messenger-1.4.1/build/js/messenger.min.js',
                        'vendors/messenger-1.4.1/build/js/messenger-theme-future.js',
                    ],
//                    'min/app1.js': [
//                        'vendors/angular/angular.min.js',
//                        'vendors/angular/angular-resource.min.js',
//                        'vendors/angular/angular-locale_pt-br.js',
////                        
//                        'js/ng/app.js',
//                        'js/ng/factories/messenger.js',
//                        'js/ng/directives/post2.js',
//                    ]
                }
            }
        },
    });

    //--Carrega tarefas
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
//    grunt.loadNpmTasks('grunt-contrib-connect');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-csso');

    //--Tarefas a serem executadas
    grunt.registerTask('default', ['less']);
    grunt.registerTask('w', ['watch']);
    grunt.registerTask('jsmin', ['uglify']);
    grunt.registerTask('cssmin', ['csso']);

};