<html>
<?php
include("header.php") ?>
<script src="js/bootstrap.min.js"></script>

<head>
    <style>
        body {
            font-size: 12px
        }

        .board {
            margin-left: 500px;
        }

        h1 {
            margin-left: 20px;
            font-size: 2rem;
        }

        .column {
            width: 250px;
            float: left;
            border: solid 4px black;
            height: 100vh;
        }

        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .task-list {
            min-height: 15rem;
            background-color: #f5f5f5;
        }



        /* Dragula CSS Release 3.2.0 from: https://github.com/bevacqua/dragula */

        .gu-mirror {
            position: fixed !important;
            margin: 0 !important;
            z-index: 9999 !important;
            opacity: 0.8;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
            filter: alpha(opacity=80);
        }

        .gu-hide {
            display: none !important;
        }

        .gu-unselectable {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
        }

        .gu-transit {
            opacity: 0.2;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=20)";
            filter: alpha(opacity=20);
        }
    </style>
</head>

<body>
    <?php include("navBar.php") ?>


    <div class="container">

        <div class="row row-cols-4" style="flex-wrap: nowrap;">
            <div class="col" style="margin-right: 25px;">
                <h3 style="text-align:center">All Teams</h3>
                <div class='row task-list' id="all-teams">
                    <!-- Picklist Initialze Here -->
                </div>
            </div>

            <div class="col" style="margin-right: 25px;">
                <h3 style="text-align:center">Offense</h3>
                <div class='row task-list' id="offense-teams">

                </div>
            </div>

            <div class="col" style="margin-right: 25px;">
                <h3 style="text-align:center">Defense</h3>
                <div class='row task-list' id="defense-teams">

                </div>
            </div>

            <div class="col" style="margin-right: 25px;">
                <h3 style="text-align:center">DNP</h3>
                <div class='row task-list' id="dnp-teams">

                </div>
            </div>

        </div>

    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
</script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>
<!-- <script src="js/draganddrop.js"></script> -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js'></script>

<script src="./js/firebase.js" type="module"></script>

<script src="./js/picklist.js" type="module"></script>

<?php include("footer.php") ?>