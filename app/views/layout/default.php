<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Evermore Timer | <?= $controller->title ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script type="text/javascript"> var real_url = '<?=REAL_URL?>'</script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <?php 
        self::render_app_style(
          array(
            'bundle/bundle-style',
            'style/style.bundle.min',
            'style',
          )
        ) 
    ?>
  </head>
  <body>
      <div class="container-fluid">
          <?php self::render($view, $controller->model); ?>
      </div>
    <?php 
        self::render_app_script(
            array(
                'bundle/bundle',
                'prismjs/prismjs',
                'scripts/scripts.bundle',
            )
        ); 
              
        self::render_app_script($controller->scripts);    
    ?>
  </body>
</html>