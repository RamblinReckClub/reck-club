<?php
require "logged_in_check.php";
require "set_session_vars_full.php";
require "database_connect.php";
$pageTitle = "Points";
?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php"; ?>
<body>
<?php require "partials/header.php"; ?>
<div class="container mb-3">
    <div class="row mb-3">
        <h2 class="col-8">Families</h2>
        <div class="col-4">
            <div class="btn-group float-right">
                <?php
                if($_SESSION[isAdmin]==1 || $_SESSION[isVP]==1) {
                    echo "<form action=\"familyEvents.php\" method=\"POST\">";
                    echo "<button type=\"submit\" class='btn btn-secondary'  value=\"Family Events\">Family Events</button>";
                    echo "</form>";
                    echo "<form action=\"editFamilies.php\" method=\"POST\">";
                    echo "<button type=\"submit\" class='ml-2 btn btn-primary' value=\"Edit Families\">Edit Families</button>";
                    echo "</form>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?php
                $query = $db->query("SELECT familyName,familyPoints FROM Family WHERE familyID=1");
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $row = $query->fetch();
            ?>
            <h4><?php echo (strlen($row[familyName]) > 0) ? $row[familyName] : 'Family 1'; ?> <small class="float-right text-primary">Points: <?php echo (isset($row[familyPoints]) ? $row[familyPoints] : '0'); ?></small></h4>
            <?php
                $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=1 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
                $query->setFetchMode(PDO::FETCH_ASSOC);
            ?>
            <?php if ($query->rowCount() > 0): ?>
                <table class="table table-sm table-hover">
                    <thead>
                    <th scope="col">Member</th>
                    <th scope="col" style="text-align:right !important;">Points</th>
                    </thead>
                    <tbody>

                    <?php
                        while($row = $query->fetch()) {
                            echo "<tr><td>" . $row[firstName]." ".$row[lastName]."</td><td align=\"right\">" . $row[memberPoints] . "</td></tr>";

                        }
                    ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No members are assigned to this family.</p>
            <?php endif; ?>
        </div>
        <div class="col-6">
            <?php
            $query = $db->query("SELECT familyName,familyPoints FROM Family WHERE familyID=2");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $row = $query->fetch();
            ?>
            <h4><?php echo (strlen($row[familyName]) > 0) ? $row[familyName] : 'Family 2'; ?> <small class="float-right text-primary">Points: <?php echo (isset($row[familyPoints]) ? $row[familyPoints] : '0'); ?></small></h4>
            <?php
            $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=2 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            ?>
            <?php if ($query->rowCount() > 0): ?>
                <table class="table table-sm table-hover">
                    <thead>
                    <th scope="col">Member</th>
                    <th scope="col" style="text-align:right !important;">Points</th>
                    </thead>
                    <tbody>

                    <?php
                    while($row = $query->fetch()) {
                        echo "<tr><td>" . $row[firstName]." ".$row[lastName]."</td><td align=\"right\">" . $row[memberPoints] . "</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No members are assigned to this family.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?php
            $query = $db->query("SELECT familyName,familyPoints FROM Family WHERE familyID=3");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $row = $query->fetch();
            ?>
            <h4><?php echo (strlen($row[familyName]) > 0) ? $row[familyName] : 'Family 3'; ?> <small class="float-right text-primary">Points: <?php echo (isset($row[familyPoints]) ? $row[familyPoints] : '0'); ?></small></h4>
            <?php
            $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=3 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            ?>
            <?php if ($query->rowCount() > 0): ?>
                <table class="table table-sm table-hover">
                    <thead>
                    <th scope="col">Member</th>
                    <th scope="col" style="text-align:right !important;">Points</th>
                    </thead>
                    <tbody>

                    <?php
                    while($row = $query->fetch()) {
                        echo "<tr><td>" . $row[firstName]." ".$row[lastName]."</td><td align=\"right\">" . $row[memberPoints] . "</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No members are assigned to this family.</p>
            <?php endif; ?>
        </div>
        <div class="col-6">
            <?php
            $query = $db->query("SELECT familyName,familyPoints FROM Family WHERE familyID=4");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $row = $query->fetch();
            ?>
            <h4><?php echo (strlen($row[familyName]) > 0) ? $row[familyName] : 'Family 4'; ?> <small class="float-right text-primary">Points: <?php echo (isset($row[familyPoints]) ? $row[familyPoints] : '0'); ?></small></h4>
            <?php
            $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=4 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            ?>
            <?php if ($query->rowCount() > 0): ?>
                <table class="table table-sm table-hover">
                    <thead>
                    <th scope="col">Member</th>
                    <th scope="col" style="text-align:right !important;">Points</th>
                    </thead>
                    <tbody>

                    <?php
                    while($row = $query->fetch()) {
                        echo "<tr><td>" . $row[firstName]." ".$row[lastName]."</td><td align=\"right\">" . $row[memberPoints] . "</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No members are assigned to this family.</p>
            <?php endif; ?>
        </div>
    </div>
<!--    <table align="center">-->
<!--        --><?php
//        echo "<tr bgcolor=\"#b3a369\"><th width=300>";
//        $query = $db->query("SELECT familyName FROM Family WHERE familyID=1");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        $row = $query->fetch();
//        echo $row[familyName];
//        echo "</th><th>Points</th><th width=300>";
//        $query = $db->query("SELECT familyName FROM Family WHERE familyID=3");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        $row = $query->fetch();
//        echo $row[familyName];
//        echo "</th><th>Points</th></tr>";
//        echo "<tr><td>";
//        $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=1 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        while($row = $query->fetch()) {
//            echo $row[firstName]." ".$row[lastName]."<br>";
//        }
//        echo "</td><td>";
//        $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=1 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        while($row = $query->fetch()) {
//            echo $row[memberPoints]."<br>";
//        }
//        echo "</td><td>";
//        $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=3 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        while($row = $query->fetch()) {
//            echo $row[firstName]." ".$row[lastName]."<br>";
//        }
//        echo "</td><td>";
//        $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=3 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        while($row = $query->fetch()) {
//            echo $row[memberPoints]."<br>";
//        }
//        echo "</td></tr>";
//        echo "<tr bgcolor=\"#b3a369\"><th>";
//        $query = $db->query("SELECT familyName FROM Family WHERE familyID=2");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        $row = $query->fetch();
//        echo $row[familyName];
//        echo "</th><th>Points</th><th>";
//        $query = $db->query("SELECT familyName FROM Family WHERE familyID=4");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        $row = $query->fetch();
//        echo $row[familyName];
//        echo "</th><th>Points</th></tr>";
//        echo "<tr><td>";
//        $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=2 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        while($row = $query->fetch()) {
//            echo $row[firstName]." ".$row[lastName]."<br>";
//        }
//        echo "</td><td>";
//        $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=2 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        while($row = $query->fetch()) {
//            echo $row[memberPoints]."<br>";
//        }
//        echo "</td><td>";
//        $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=4 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        while($row = $query->fetch()) {
//            echo $row[firstName]." ".$row[lastName]."<br>";
//        }
//        echo "</td><td>";
//        $query = $db->query("SELECT firstName, lastName, memberPoints FROM Member WHERE memFamilyID=4 AND status != 'alumni' ORDER BY memberPoints DESC, lastName, firstName");
//        $query->setFetchMode(PDO::FETCH_ASSOC);
//        while($row = $query->fetch()) {
//            echo $row[memberPoints]."<br>";
//        }
//        echo "</td></tr>";
//        ?>
<!--    </table>-->
</div>
<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>

</body>

</html>