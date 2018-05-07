<?php
if(function_exists('date_default_timezone_set')) date_default_timezone_set("Asia/Kolkata");
$pdo=new PDO('mysql:host=projectapollo.c64lnxkmo6ns.us-east-2.rds.amazonaws.com;dbname=apollo', '********', '********');
$btc=0;$eth=0;$xmr=0;$xrp=0;$best=0;$worst=0;
if(!isset($_GET['cur']))
{
    $query = $pdo->prepare("SELECT * FROM `btc` where close!=-1");
    $query->execute();
    $btc = $query->fetchAll(PDO::FETCH_ASSOC);
    $query = $pdo->prepare("SELECT * FROM `eth` where close!=-1");
    $query->execute();
    $eth = $query->fetchAll(PDO::FETCH_ASSOC);
    $query = $pdo->prepare("SELECT * FROM `xmr` where close!=-1");
    $query->execute();
    $xmr = $query->fetchAll(PDO::FETCH_ASSOC);
    $query = $pdo->prepare("SELECT * FROM `xrp` where close!=-1");
    $query->execute();
    $xrp = $query->fetchAll(PDO::FETCH_ASSOC);

}
elseif ($_GET['cur']=='BTC') {
    $query = $pdo->prepare("SELECT * FROM `btc`  where Date > '2017-09-01 00:00:00' ");
    $query->execute();
    $btc = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $pdo->prepare("SELECT prediction,date FROM btc  where date>CURDATE()+1 and prediction2 in (Select max(prediction2) from btc  where date>CURDATE()+1) ");
    $query->execute();
    $best = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $pdo->prepare("SELECT prediction,date FROM btc  where date>CURDATE()+1 and prediction2 in (Select min(prediction2) from btc  where date>CURDATE()+1) ");
    $query->execute();
    $worst = $query->fetchAll(PDO::FETCH_ASSOC);
}

elseif ($_GET['cur']=='ETH') {
    $query = $pdo->prepare("SELECT * FROM `eth` where Date > '2017-09-01 00:00:00'");
    $query->execute();
    $eth = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $pdo->prepare("SELECT prediction,date FROM eth  where date>CURDATE()+1 and prediction2 in (Select max(prediction2) from eth  where date>CURDATE()+1) ");
    $query->execute();
    $best = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $pdo->prepare("SELECT prediction,date FROM eth  where date>CURDATE()+1 and prediction2 in (Select min(prediction2) from eth  where date>CURDATE()+1) ");
    $query->execute();
    $worst = $query->fetchAll(PDO::FETCH_ASSOC);
}

elseif ($_GET['cur']=='XMR') {
    $query = $pdo->prepare("SELECT * FROM `xmr` where Date > '2017-09-01 00:00:00'");
    $query->execute();
    $xmr = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $pdo->prepare("SELECT prediction,date FROM xmr  where date>CURDATE()+1 and prediction2 in (Select max(prediction2) from xmr  where date>CURDATE()+1) ");
    $query->execute();
    $best = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $pdo->prepare("SELECT prediction,date FROM xmr  where date>CURDATE()+1 and prediction2 in (Select min(prediction2) from xmr  where date>CURDATE()+1)  ");
    $query->execute();
    $worst = $query->fetchAll(PDO::FETCH_ASSOC);
}

elseif ($_GET['cur']=='XRP') {
    $query = $pdo->prepare("SELECT * FROM `xrp` where Date > '2017-09-01 00:00:00'");
    $query->execute();
    $xrp = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $pdo->prepare("SELECT prediction,date FROM xrp  where date>CURDATE()+1 and prediction2 in (Select max(prediction2) from xrp  where date>CURDATE()+1)  ");
    $query->execute();
    $best = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $pdo->prepare("SELECT prediction,date FROM xrp  where date>CURDATE()+1 and prediction2 in (Select min(prediction2) from xrp  where date>CURDATE()+1) ");
    $query->execute();
    $worst = $query->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Apollo</title>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
    <div id="loading">
        <img id="loading-image" src="css/loader.gif" alt="Loading..." />
    </div>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <a class="navbar-brand" href="index.html">Apollo</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a class="nav-link" href="index.html">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Bitcoin">
                    <a class="nav-link" href="?cur=BTC">
                        <i class="fab fa-bitcoin"></i>
                        <span class="nav-link-text">Bitcoin Prediction</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Ethereum">
                    <a class="nav-link" href="?cur=ETH">
                        <i class="fab fa-ethereum"></i>
                        <span class="nav-link-text">Ethereum Prediction</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Monero">
                    <a class="nav-link" href="?cur=XMR">
                        <i class="fab fa-monero"></i>
                        <span class="nav-link-text">Monero Prediction</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Ripple">
                    <a class="nav-link" href="?cur=XRP">
                        <i class="fab fa-cloudsmith"></i>
                        <span class="nav-link-text">Ripple Prediction</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item">
                    <a class="nav-link text-center" id="sidenavToggler">
                        <i class="fa fa-fw fa-angle-left"></i>
                    </a>
                </li>
            </ul>

        </div>
    </nav>
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">My Dashboard</li>
            </ol>
            <!-- Icon Cards-->
            <div class="row card_cur">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-primary o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fab fa-bitcoin"></i>
                            </div>
                            <div class="mr-5 btc">Bitcoin</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="?cur=BTC">
                            <span class="float-left">View Predictions</span>
                            <span class="float-right">

                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-warning o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fab fa-ethereum"></i>
                            </div>
                            <div class="mr-5 eth">Ethereum</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="?cur=ETH">
                            <span class="float-left">View Predictions</span>
                            <span class="float-right">

                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white bg-success o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fab fa-monero"></i>
                            </div>
                            <div class="mr-5 mon">Monero</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1 " href="?cur=XMR">
                            <span class="float-left ">View Predictions</span>
                            <span class="float-right ">

                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3 ">
                    <div class="card text-white bg-danger o-hidden h-100 ">
                        <div class="card-body ">
                            <div class="card-body-icon ">
                                <i class="fab fa-cloudsmith"></i>
                            </div>
                            <div class="mr-5 rip">Ripple</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1 " href="?cur=XRP">
                            <span class="float-left ">View Predictions</span>
                            <span class="float-right ">

                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <ol class="breadcrumb">
                    Stats

            </ol>
            <div class="row" id="jumbo">

                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white o-hidden h-100" style="background-color: #009688;">
                        <div class="card-body">
                            Date
                            <div class="card-body-icon">
                                <i class="far fa-calendar-alt"></i>
                            </div>
                            <div class="mr-5 date">Date</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white o-hidden h-100" style="background-color: #00E676;">
                        <div class="card-body">
                            Current Value
                            <div class="card-body-icon">
                            <i class="fas fa-rupee-sign"></i>
                            </div>
                            <div class="mr-5 current">Current Value</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-white o-hidden h-100" style="background-color: #00C853;">
                        <div class="card-body">
                            Predicted Value
                            <div class="card-body-icon">
                                <i class="fab fa-reddit-alien"></i>
                            </div>
                            <div class="mr-5 predicted">Predicted Value</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3 ">
                    <div class="card text-white o-hidden h-100 " style="background-color: #FF3D00;">
                        <div class="card-body ">
                            Accuracy
                            <div class="card-body-icon ">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="mr-5 accuracy">Accuracy</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-3 ">
                </div>
                <div class="col-xl-3 col-sm-6 mb-3 ">
                    <div class="card text-white o-hidden h-100 " style="background-color: #7F3AF6;">
                        <div class="card-body ">Best date to Sell:<br/>
                        <span class="bestdate">Date</span>
                            <div class="card-body-icon ">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="mr-5 best">BEST</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3 ">
                    <div class="card text-white o-hidden h-100 " style="background-color: #FF6F8B;">
                        <div class="card-body ">Best date to Buy:<br/>
                            <span class="worstdate">Date</span>
                            <div class="card-body-icon ">
                                <i class="fas fa-rupee-sign"></i>
                            </div>
                            <div class="mr-5 worst">WORST</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3 ">
                </div>

            </div>
            <!-- Area Chart Example-->
            <div class="card mb-3 ">
                <div class="card-header ">
                    <?php if(!isset($_GET['cur'])){ ?>
                        <i class="fas fa-chart-area"></i>&nbsp;Historical Data</div>
                    <?php } elseif ($_GET['cur']=='BTC'){ ?>
                        <i class="fab fa-bitcoin"></i>&nbsp;Bitcoin Prediction Data</div>
                    <?php } elseif ($_GET['cur']=='ETH'){ ?>
                        <i class="fab fa-ethereum"></i>&nbsp;Ethereum Prediction Data</div>
                    <?php } elseif ($_GET['cur']=='XMR'){ ?>
                        <i class="fab fa-monero"></i>&nbsp;Monero Prediction Data</div>
                    <?php } elseif ($_GET['cur']=='XRP'){ ?>
                        <i class="fab fa-cloudsmith"></i>&nbsp;Ripple Prediction Data</div>
                    <?php } ?>
                    <div class="card-body ">
                        <div id="chartContainer" style="width: 100%; height: 300px"></div>
                    </div>
                    <div class="card-footer small text-muted live_time">Updated at 11:59 PM</div>
                </div>

            </div>
        </div>
        <!-- /.container-fluid-->
        <!-- /.content-wrapper-->
        <footer class="sticky-footer ">
            <div class="container ">
                <div class="text-center ">
                    <small>Copyright © Project Apollo 2018</small>
                </div>
            </div>
        </footer>
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded " href="#page-top ">
            <i class="fa fa-angle-up "></i>
        </a>
        <!-- Logout Modal-->
        <div class="modal fade " id="exampleModal " tabindex="-1 " role="dialog " aria-labelledby="exampleModalLabel " aria-hidden="true ">
            <div class="modal-dialog " role="document ">
                <div class="modal-content ">
                    <div class="modal-header ">
                        <h5 class="modal-title " id="exampleModalLabel ">Ready to Leave?</h5>
                        <button class="close " type="button " data-dismiss="modal " aria-label="Close ">
                            <span aria-hidden="true ">×</span>
                        </button>
                    </div>
                    <div class="modal-body ">Select "Logout " below if you are ready to end your current session.</div>
                    <div class="modal-footer ">
                        <button class="btn btn-secondary " type="button " data-dismiss="modal ">Cancel</button>
                        <a class="btn btn-primary " href="login.html ">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js "></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js "></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js "></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js "></script>
        <!-- Custom scripts for this page-->
        <script src="js/index.js "></script>
        <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
        <?php
        echo "<script type='text/javascript'>passData(".json_encode($btc).",".json_encode($eth).",".json_encode($xmr).",".json_encode($xrp).",".json_encode($best).",".json_encode($worst).")</script>";

        ?>
    </div>

</body>

</html>
