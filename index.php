<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

include_once 'Watcher.php';


if ($_POST) {
    if ((isset($_POST['file']) && !empty($_POST['file'])) && isset($_POST['filter'])) {
        $watcher = new Watcher($_POST['file'], !empty($_POST['filter']) ? $_POST['filter'] : null);
    }
}
?>
<html>
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <?php
            if (!isset($watcher)) {
                ?>
                <form method="POST" action="?">
                    <div class="card"  style="top: 40px;">
                        <div class="card-header">
                            <span class="card-title">Setup</span>
                        </div>  
                        <div class="card-body">
                            <div class="form-group form-row">
                                <label class="col-form-label col-sm-2 text-right">File</label>
                                <input class="form-control col-sm-8" type="text" name="file" placeholder="/path/to/file/filename" />
                            </div>
                            <div class="form-group form-row">
                                <label class="col-form-label col-sm-2 text-right">Filter</label>
                                <input class="form-control col-sm-8" type="text" name="filter"  placeholder="[A-Za-z]{0,3}" />
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Start</button>
                        </div>
                    </div>
                </form>  
                <?php
            } else {
                ?>
                <h1>Watching ...</h1>
                <table class="table table-borderd table-sm">
                    <tbody>
                        <?php
                        while (!$watcher->end()) {

                            echo "<tr>";
                            echo "<td>".$watcher->getNext()." <a href=\"#\" id=\"followedUp\"></a></td>";
                            echo "<tr/>";
                        }
                        echo "<script>" . PHP_EOL;
                        echo "    $(document).ready(function() {" . PHP_EOL;
                        echo "        windows.location.href='#followedUp';" . PHP_EOL;
                        echo "    });".PHP_EOL;
                        echo "</script>" . PHP_EOL;
                        ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </body>
</html>