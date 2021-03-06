<?php
include_once 'include/check_session.php';
include '../BLL/committees.php';
$committee = new committees();
$rs_committee = $committee->committee_get($_GET['committee_id']);
$row_committee = $rs_committee->fetch_assoc();
?>
<!DOCTYPE html>
<html>
    <head>
        <!--here decide the title depend on the directorate-->
        <?php
        if (($_SESSION['directorate'] == 2) || ($_SESSION['user_type'] == 0)) {
            ?>
            <title>تعديل اللجنة</title>
        <?php } elseif ($_SESSION['directorate'] == 3) {
            ?>
            <title>تعديل اللجنة الدبلوماسية</title>
            <?php
        } elseif ($_SESSION['directorate'] == 4) {
            ?>
            <title>اسم الكتلة / الائتلاف</title>
            <?php
        }
        ?>
        <!--header file inclusion-->
        <?php include_once 'include/header.php'; ?>
    </head>
    <body>
        <!---top menu file inclusion-->
        <?php include 'include/menu.php'; ?>

        <!-- Sidebar menu and button -->
        <div>
            <!-- Sidebar menu -->
            <div>
                <nav class="w3-sidebar w3-bar-block w3-white w3-card-2 w3-animate-left w3-xxlarge" style="display:none;z-index:2" id="mySidebar">
                    <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-display-topright w3-text-teal">Close
                        <i class="fa fa-remove"></i>
                    </a>
                    <hr>
                    <!--bellow i send with the url the id of the directorate-->
                    <?php
                    if ($_SESSION['user_type'] == 2) {//here if the user type is regular user
                        ?>
                        <a class="w3-bar-item w3-button" href='committees.php?directorate=<?php echo $_SESSION['directorate']; ?>'>رجوع</a><!--here i'll send with the url the directorate id for that user-->
                    <?php } elseif ($_SESSION['user_type'] == 0) { ?>
                        <a class="w3-bar-item w3-button" href='committees.php?directorate=2'>رجوع</a><!--here because the user is superadmin and he can just add the legislative affairs committees, i'll send always with the url the directorate id as 2-->
                    <?php }
                    ?>
                </nav>
            </div>

            <!-- Sidebar button -->
            <div>
                <br>
                <div class="w3-container" style="position:relative">
                    <a onclick="w3_open()" class="w3-button w3-xlarge w3-circle w3-teal"
                       style="position:absolute;top:-28px;right:24px">+</a>
                </div>
            </div>
        </div>

        <!--this form to choose and upload an image-->
        <div class="w3-container w3-padding-64" id="contact">
            <div class="right-align-text">
                <form class="w3-container w3-card-4 w3-padding-16 w3-white" action="committee_edit_ctl.php" method="post">
                    <input type = "hidden" name = "committee_id" value = "<?php echo $row_committee['committee_id'] ?>" class="w3-input w3-border">

                    <div class="w3-section">
                        <label><?php
                            //bellow i'll set the the input field label based on the user directorate
                            if (($_SESSION['directorate'] == 2) || ($_SESSION['user_type'] == 0)) {//here i check if the directorate is legislative affairs with the id 2, or the user type is super admin
                                echo 'اسم اللجنة';
                            } elseif ($_SESSION['directorate'] == 3) {//here i check if the directorate is foreign affairs with the id 3
                                echo "اسم اللجنة الدبلوماسية";
                            } elseif ($_SESSION['directorate'] == 4) {//here i check if the directorate is blocs with the id 4
                                echo "اسم الكتلة / الائتلاف";
                            }
                            ?></label>
                        <input type="text" name="committee_name" <?php
                        //bellow i'll set the placeholder value based on the user directorate
                        if (($_SESSION['directorate'] == 2) || ($_SESSION['user_type'] == 0)) {//here i check if the directorate is legislative affairs with the id 2, or the user type is super admin
                            ?> placeholder = "اسم اللجنة" <?php
                               } elseif ($_SESSION['directorate'] == 3) {//here i check if the directorate is foreign affairs with the id 3
                                   ?> placeholder = "اسم اللجنة الدبلوماسية" <?php
                               } elseif ($_SESSION['directorate'] == 4) {//here i check if the directorate is blocs with the id 4
                                   ?> placeholder = "اسم الكتلة / الائتلاف" <?php
                               }
                               ?> class="w3-input w3-border right-dir" value = "<?php echo $row_committee['committee_name'] ?>">
                    </div>
                    <button class="w3-button w3-right w3-theme" type="submit" name="edit">تعديل</button>
                </form>
            </div>
        </div>

        <!--footer inclusion-->
        <?php include_once 'include/footer.php'; ?>    
    </body>
</html>
