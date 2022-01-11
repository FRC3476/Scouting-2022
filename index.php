<html lang="en" class="full-height">
<?php
include('header.php');
include('navBar.php');
?>
<style>
    /* TEMPLATE STYLES */
    .flex-center {
        color: #fff;
    }

    .intro-1 {
        background: url("dug.png")no-repeat center center;
        background-size: cover;
    }

    .navbar .btn-group .dropdown-menu a:hover {
        color: #000 !important;
    }

    .navbar .btn-group .dropdown-menu a:active {

        color: #fff !important;
    }
</style>

<body style="background-color:#008080">
    <header>
        <!--Intro Section-->
        <section class="view intro-1 hm-black-strong">
            <div style="background-color: rgba(0,0,0,.3);" class="full-bg-img flex-center">
                <div class="container">
                    <ul>
                        <li>
                            <h1 class="h1-responsive font-bold wow fadeInDown" data-wow-delay="0.2s">Welcome to Scouting!</h1>
                        </li>
                        <li>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </header>
    <!-- Main container-->
    <div class="container">

        <div class="divider-new pt-5">
            <h2 style="color:White;"><b>Quick Links<b></h2>
        </div>

        <!--Section: Best features-->
        <section id="best-features">

            <div class="row pt-3">

                <div class="col-lg-3 mb-r">
                    <a href="matchInput.php" class="btn btn-warning">Match Form</a>
                </div>

                <div class="col-lg-3 mb-r">
                    <a href="pitInput.php" class="btn btn-warning">Pit Scout Form</a>
                </div>

                <div class="col-lg-3 mb-r">
                    <a href="leadScoutInput.php" class="btn btn-warning">Lead Scout Form</a>
                </div>

            </div>

        </section>
        <!--/Section: Best features-->

    </div>
    <!--/ Main container-->
    <?php
    include("footer.php");
    ?>
    <!-- Animations init-->
    <script>
        new WOW().init();
    </script>


</body>

</html>