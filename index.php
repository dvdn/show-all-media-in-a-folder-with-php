<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Show media in folder</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="inc/style.css">
    <link rel="shortcut icon" type="image/png" href="inc/favicon.png"/>
    <!-- style for media insertion -->
    <link rel="stylesheet" type="text/css" href="inc/ins-media.css">
</head>
<body>
    <header><div><h1>Show all media in my folder</h1></div></header>

    <!-- media insertion -->
    <?php include "inc/ins-media.php"; ?>

    <footer><div><?php echo date("Y"); ?> // source code <a target="_blank" href="https://github.com/dvdn/show-all-media-in-a-folder-with-php">dvdn/show-all-media-in-a-folder-with-php</a></div></footer>
</body>
</html>
