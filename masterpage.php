<!DOCTYPE html>
<html>
    <head>
        <title><?php MasterPageData::title(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/main.css" rel="stylesheet" type="text/css"/>
        <link href="css/menu.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
        <script src="js/timer.js" type="text/javascript"></script>
        <script>
            function ddMenu() {
                document.getElementsByClassName('topnav')[0].classList.toggle('responsive');
            }
        </script>
    </head>
    <body>
        <h1>Werklog</h1>
        <ul class='topnav'>
            <?php echo MenuManager::getMenu(); ?>
            <li class='icon'><a href='javascript:void(0);' onclick='ddMenu()'>&#9776;</a></li>
        </ul>
        <?php MasterPageData::main(); ?>
    </body>
</html>