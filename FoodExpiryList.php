<!DOCTYPE html>

<script defer src="js/food-expiry-list.js"></script>

<html lang="en">
    <title>My Food List</title>
    <?php
    session_start();
    include "head.php";
    ?>    
    <body>

        <style>
            /*ax accordiance*/

            .accordion {
                background-color: #6d6875;
                color: whitesmoke;
                cursor: pointer;
                padding: 18px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 15px;
                transition: 0.4s;
            }

            .active, .accordion:hover {
                background-color: #b5838d;
            }

            .accordion:after {
                content: '\002B';
                color: whitesmoke;
                font-weight: bold;
                float: right;
                margin-left: 5px;

            }

            .active:after {
                content: "\2212";
            }

            .panel {
                padding: 0 18px;
                background-color: white;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.2s ease-out;
            }
        </style>


        <!-- header section starts  -->
        <?php include "nav.php"; ?>
        <!-- header section ends -->
        <div class="heading">
            <h1>My Food List</h1>
        </div>

        <section class="products">
            <!--if got purchase history-->
            <div class="wrapper" style="margin-bottom: 30px;">  

            </div>

        </section>
        <?php include "footer.php"; ?>
    </body>
</html>


