<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
<link href="<?= base_url('assets/plugins/global/plugins.bundle.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/plugins/custom/prismjs/prismjs.bundle.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/css/pages/wizard/wizard-3.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/css/magnific-popup/magnific-popup.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('assets/css/viewerjs/css/viewer.css') ?>" rel="stylesheet" type="text/css" />

<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1400
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };
</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
<script src="<?= base_url('assets/plugins/custom/prismjs/prismjs.bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
<script src="<?= base_url('assets/js/pages/crud/forms/widgets/select2.js') ?>"></script>
<script src="<?= base_url('assets/js/magnific-popup/jquery.magnific-popup.min.js') ?>"></script>
<script src="<?= base_url('assets/js/viewerjs/js/viewer.js') ?>"></script>
<script>
    window.addEventListener('DOMContentLoaded', function() {
        var galley = document.getElementById('galley');
        var viewer = new Viewer(galley, {
            url: 'data-original',
            title: function(image) {
                return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
            },
        });
    });
</script>
<script src="<?= base_url('assets/js/date.js') ?>"></script>