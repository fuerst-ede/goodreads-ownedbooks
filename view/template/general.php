<html>
  <head>
      <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
      <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
      <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">

      <script src="<?=$controller->constants->jsPath . 'jquery-3.1.1.min.js'?>"></script>
      <script type="application/javascript">
          var rootUrl = '<?=$controller->constants->urlRoot?>';
      </script>
  </head>
  <body>
    <?=$controller->parts->main?>
  </body>
</html>