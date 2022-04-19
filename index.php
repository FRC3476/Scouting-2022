<html lang="en" class="full-height">
<?php
include('header.php');
include('navBar.php');
?>
<script src="js/bootstrap.min.js"></script>

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
                    <div class="col-lg-2 mb-r">
                        <a href="MatchInput.php" class="btn btn-warning">Match Scout Input</a>
                    </div>

                    <div class="col-lg-2 mb-r">
                        <a href="pitInput.php" class="btn btn-warning">Pit Scout Form</a>
                    </div>

                    <div class="col-lg-2 mb-r">
                        <a href="pictureUpload.php" class="btn btn-warning">Picture Upload</a>
                    </div>

                    <div class="col-lg-2 mb-r">
                        <a href="leadScoutInput.php" class="btn btn-warning">Lead Scout Form</a>
                    </div>

                    <div class="col-lg-2 mb-r">
                        <a href="scoutGenPicklist.php" class="btn btn-warning">Team Rank Form</a>
                    </div>

                    <div class="col-lg-2 mb-r">
                        <a href="bet.php" class="btn btn-warning">Betting Page</a>
                    </div>
                </div>
            </div>
        </section>
    </header>
    <!-- Main container-->
    <div class="container">

        <div class="divider-new pt-5">
            <h2 style="color:White;"><b>Other Pages<b></h2>
        </div>

        <!--Section: Best features-->
        <section id="best-features">

            <div class="row pt-3">

                <div class="col-lg-4">
                    <a href="https://www.thebluealliance.com/event/2022gal" class="btn btn-warning">The Blue Alliance</a>
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