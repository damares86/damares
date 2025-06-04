<?php


$stmt =$settings->showSettings();
require "admin/core/site.php";


if(($dm==0)&&(!isset($_SESSION['loggedin']))&&($file!="login.php")){
    ?>
</head>

<body>
    <div id="siteContainer">
        <div id="bottomContainer" class="mt-5 p-5"> 
            <div class="text-center">
                <img src="admin/assets/img/logo.svg" style="width:15%; margin-bottom:3em;">
            </div>
            <h1 style="text-align:center; font-size:3em;">Site under maintenance</h1>
            <br><br>
            <h1 style="text-align:center; font-size:3em;">Sito in manutenzione</h1>
            <div class="text-center my-5">
                <p class="font-weight-bold">Made with Mini Cms <?=$mc_version?> - a project by &nbsp; &nbsp; 
                    <a href="https://www.dmweblab.com">
                        <img src="admin/assets/img/dmweblab_logo.png" style="vertical-align:middle;">
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>


    <?php
    exit;
}


if(!in_array($_SERVER['SERVER_NAME'],$site)){
    ?>
    </head>
    
    <body>
        <div id="siteContainer">
            <div id="bottomContainer" class="mt-5 p-5">  
                <h1 style="text-align:center; font-size:3em;">Licenza non valida</h1>
                <br><br>
                <h1 style="text-align:center; font-size:3em;">Invalid license</h1>
            </div>
        </div>
    </body>
    </html>
    
    
        <?php
        exit;
}

?>