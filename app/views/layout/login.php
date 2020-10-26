<html lang="en">
<!--begin::Head-->
<head>
  <meta charset="utf-8" />
  <title><?=$controller->title ?></title>
  <meta name="description" content="Login page example" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

  <?php 
    self::render_app_style(
      array(
        'bundle/bundle-style',
        'login/login',
        'prismjs/prismjs',
        'style/style.bundle',
      )
    ) 
  ?>
  
  <link rel="shortcut icon" href="<?=REAL_URL?>/app/assets/img/favicon.png" />
</head>

<body id="kt_body" style="background-image: url('<?=REAL_URL?>/app/assets/img/bg-6.jpg')" class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">

    <?php self::render($view, $model); ?>

    <script>
      var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };
    </script>

    <?php 
        self::render_app_script(
            array(
                //'lib/jquery-3.5.1.min',
                'bundle/bundle',
                'prismjs/prismjs',
                'scripts/scripts.bundle',
                'widgets/widgets',
                'widgets/apexcharts',
            )
        ); 
        self::render_app_script($controller->scripts);    
    ?>
</body>
</html>