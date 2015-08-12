<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>GitHub register issue</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="img/apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    
        <div class="container">            
            <p class="bg-primary info">
                This is a tool to register GitHub issues. You need to fill bottom form and press submit button.
            </p>
            <?php if (isset($flash['success'])): ?>
            <p class="bg-success info">
                <span class="glyphicon glyphicon-ok-circle"></span> <?php echo $flash['success'];?>
            </p>
            <?php endif; ?>
            <?php if (isset($flash['error'])): ?>
            <p class="bg-danger info">
                <span class="glyphicon glyphicon-remove-circle"></span> <?php echo $flash['error'];?>
            </p>           
            <?php endif; ?>
            <form method="post" action="./" novalidate="novalidate" >
                <div class="form-group">
                    <label for="title">GitHub login</label>
                    <input type="text" value="<?php if (isset($_SESSION['login'])) echo htmlentities($_SESSION['login']); ?>" name="login" class="form-control" id="title" placeholder="Enter here your GitHub login" required>
                </div>
                <div class="form-group">
                    <label for="password">GitHub password</label>
                    <input type="password" value="<?php if (isset($_SESSION['password'])) echo htmlentities($_SESSION['password']); ?>" name="password" class="form-control" id="password" placeholder="Enter here your GitHub password" required>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter here title for the issue" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea rows="25" name="description" class="form-control" id="description" placeholder="Write here description of the issue"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>
    </body>
</html>
