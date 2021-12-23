const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/* Admin Panel */

/*mix.less(
    [
            './resources/assets/admin/less/_main_full/bootstrap.less',
            './resources/assets/admin/less/_main_full/core.less',
            './resources/assets/admin/less/_main_full/components.less',
            './resources/assets/admin/less/_main_full/colors.less',
    ],
    'public/admin/all.css');*/

mix.less( './resources/assets/admin/less/_main_full/bootstrap.less', 'public/admin/less');
mix.less( './resources/assets/admin/less/_main_full/core.less', 'public/admin/less');
mix.less( './resources/assets/admin/less/_main_full/components.less', 'public/admin/less');
mix.less( './resources/assets/admin/less/_main_full/colors.less', 'public/admin/less');

mix.styles(
    [
        './public/admin/less/bootstrap.css',
        './public/admin/less/core.css',
        './public/admin/less/components.css',
        './public/admin/less/colors.css',
        './public/admin/icons/icomoon/styles.css',
        "./resources/assets/admin/js/plugins/inputmask/inputmask.css",
        './resources/assets/admin/css/animate.css',
        './public/admin/all.css',
    ],
    'public/admin/mix.all.css');

mix.scripts(
    [
        "./resources/assets/admin/js/plugins/loaders/pace.min.js",
        "./resources/assets/admin/js/core/libraries/jquery.min.js",
        "./resources/assets/admin/js/core/libraries/bootstrap.min.js",
        "./resources/assets/admin/js/plugins/loaders/blockui.min.js",
        "./resources/assets/admin/js/plugins/visualization/d3/d3.min.js",
        "./resources/assets/admin/js/plugins/visualization/d3/d3_tooltip.js",
        "./resources/assets/admin/js/plugins/forms/styling/uniform.min.js",
        "./resources/assets/admin/js/plugins/forms/styling/switch.min.js",
        "./resources/assets/admin/js/plugins/forms/selects/bootstrap_multiselect.js",
        "./resources/assets/admin/js/plugins/ui/moment/moment.min.js",
        "./resources/assets/admin/js/plugins/pickers/daterangepicker.js",
        "./resources/assets/admin/js/plugins/notifications/bootbox.min.js",
        "./resources/assets/admin/js/plugins/notifications/sweet_alert.min.js",
        "./resources/assets/admin/js/plugins/forms/selects/select2.min.js",
        "./resources/assets/admin/js/plugins/editors/wysihtml5/wysihtml5.min.js",
        "./resources/assets/admin/js/plugins/editors/wysihtml5/toolbar.js",
        "./resources/assets/admin/js/plugins/editors/wysihtml5/parsers.js",
        "./resources/assets/admin/js/plugins/editors/wysihtml5/locales/bootstrap-wysihtml5.ua-UA.js",
        "./resources/assets/admin/js/plugins/notifications/jgrowl.min.js",
        "./resources/assets/admin/js/plugins/editors/summernote/summernote.min.js",
        "./resources/assets/admin/js/pages/editor_wysihtml5.js", "./resources/assets/admin/js/plugins/forms/tags/tagsinput.min.js",
        "./resources/assets/admin/js/plugins/forms/tags/tokenfield.min.js",
        "./resources/assets/admin/js/plugins/ui/prism.min.js",
        "./resources/assets/admin/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js",
        "./resources/assets/admin/js/plugins/uploaders/fileinput/plugins/purify.min.js",
        "./resources/assets/admin/js/plugins/uploaders/fileinput/plugins/sortable.min.js",
        "./resources/assets/admin/js/plugins/uploaders/fileinput/fileinput.min.js",
        "./resources/assets/admin/js/core/libraries/jquery_ui/interactions.min.js",
        "./resources/assets/admin/js/plugins/forms/selects/select2.min.js",
        "./resources/assets/admin/js/plugins/forms/editable/editable.min.js",
        "./resources/assets/admin/js/plugins/velocity/velocity.min.js",
        "./resources/assets/admin/js/plugins/velocity/velocity.ui.min.js",
        "./resources/assets/admin/js/plugins/buttons/spin.min.js",
        "./resources/assets/admin/js/plugins/buttons/ladda.min.js",
        "./resources/assets/admin/js/plugins/inputmask/inputmask.js",
        "./resources/assets/admin/js/plugins/inputmask/bindings.js",
        //  Datepickers
        "./resources/assets/admin/js/plugins/pickers/anytime.min.js",
        "./resources/assets/admin/js/plugins/pickers/pickadate/picker.js",
        "./resources/assets/admin/js/plugins/pickers/pickadate/picker.date.js",
        "./resources/assets/admin/js/plugins/pickers/pickadate/picker.time.js",
        "./resources/assets/admin/js/plugins/pickers/pickadate/legacy.js",

        "./resources/assets/admin/js/core/app.js",

        "./resources/assets/admin/js/pages/table_elements.js",
        "./resources/assets/admin/js/pages/form_select2.js",
        "./resources/assets/admin/js/pages/uploader_bootstrap.js",
        "./resources/assets/admin/js/pages/form_tags_input.js",
        "./resources/assets/admin/js/pages/custom.js",
        "./resources/assets/admin/js/pages/editor_summernote.js",
        "./resources/assets/admin/js/pages/components_modals.js",
        "./resources/assets/admin/js/pages/components_buttons.js",
        "./resources/assets/admin/js/pages/picker_date.js",
        //"./resources/assets/admin/js/pages/dashboard.js",


        "./resources/assets/admin/js/plugins/ui/ripple.min.js",
    ],
    'public/admin/mix.all.js');


/* Front  */

mix.styles([
        "./resources/assets/front/css/bootstrap.min.css",
        "./resources/assets/front/css/style.css",
        "./resources/assets/front/css/custom.css",
        "./resources/assets/front/css/font-awesome.min.css",
        "./resources/assets/front/css/fontello.css",
        "./resources/assets/admin/js/plugins/inputmask/inputmask.css",
        "./resources/assets/front/css/animsition.min.css",
        "./resources/assets/front/css/owl.carousel.css",
        "./resources/assets/front/css/owl.theme.css"
    ],
    "public/front/mix.all.css");

mix.scripts([
        "./resources/assets/front/js/jquery.min.js",
        "./resources/assets/front/js/bootstrap.min.js",
        "./resources/assets/front/js/menumaker.js",

        "./resources/assets/front/js/animsition.js",
        "./resources/assets/front/js/animsition-script.js",

        "./resources/assets/front/js/jquery.sticky.js",
        "./resources/assets/front/js/sticky-header.js",

        "./resources/assets/front/js/owl.carousel.min.js",
        "./resources/assets/front/js/slider-carousel.js",
        "./resources/assets/front/js/service-carousel.js",

        "./resources/assets/front/js/accordion.js",

        "./resources/assets/front/js/back-to-top.js",
        "./resources/assets/admin/js/plugins/inputmask/inputmask.js",
        "./resources/assets/admin/js/plugins/inputmask/bindings.js",
        "./resources/assets/front/js/custom.js",
    ],
    "public/front/mix.all.js");

mix.version(['public/admin/mix.all.css', 'public/admin/mix.all.js', 'public/front/mix.all.js', 'public/front/mix.all.css']);

//mix.remove(['public/admin/all.css', 'public/admin/all.js', 'public/front/all.css', 'public/front/all.js']);

