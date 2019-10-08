<?php $pageTitle = "Roster"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>
<div class="container">
    <h2 class="mb-3">2019 Roster</h2>
    <h4 class="mb-4">Executive Board</h4>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Faculty Advisor:</strong> <a href="mailto:estephens34@gatech.edu">Gerome Stephens</a></p>
            <p><strong>Reck Driver:</strong> <a href="mailto:driver@reckclub.org">Ben Damus</a></p>
            <p><strong>President:</strong> <a href="mailto:president@reckclub.org">Jill Riley</a></p>
            <p><strong>Vice President:</strong> <a href="mailto:mcdonnellelisabeth@gmail.com">Elisabeth McDonnell</a></p>
        </div>
        <div class="col-md-6">
            <p><strong>Treasurer:</strong> <a href="mailto:treasurer@reckclub.org">Ethan Kreager</a></p>
            <p><strong>Secretary:</strong> <a href="mailto:secretary@reckclub.org">Cade Lawson</a></p>
            <p><strong>Member-at-Large:</strong> <a href="mailto:kassiedlee@gatech.edu">Kassie Lee</a></p>
            <p><strong>Member-at-Large:</strong> <a href="mailto:lhancher3@gatech.edu">Laura Hancher</a></p>
        </div>
    </div>
    <hr class="mb-3">
    <h4 class="mb-3">Chairs</h4>

    <div class="row mb-3">
        <div class="col-md-6">
            <?php $chairs = array(
                    [
                "chair" => 'Alumni Relations',
                "name" => 'Matt DeJonge'
                ],
                [
                    "chair" => 'Baseball',
                    "name" => 'McKade Stewart'
                ],
                [
                    "chair" => 'Basketball',
                    "name" => 'Ethan Rosman'
                ],
                [
                    "chair" => 'Big Buzz',
                    "name" => 'Sydney Weisenburger'
                ],
                [
                    "chair" => 'Campus Outreach',
                    "name" => 'Brayton Miles'
                ],
                [
                    "chair" => 'Football',
                    "name" => 'Abi Ivemeyer'
                ],
                [
                    "chair" => 'Fundraising',
                    "name" => 'Ronnie Ludwin'
                ],
                [
                    "chair" => 'Homecoming',
                    "name" => 'Isabel Wickliffe'
                ]);

            foreach ($chairs as $item) {
                echo "<p><strong>". $item["chair"] .":</strong> " . $item["name"] . "</p>";
            }
            
            ?>
        </div>
        <div class="col-md-6">
            <?php $chairs = array(
                [
                    "chair" => 'Non-Revenue Sports',
                    "name" => 'Jake Grant'
                ],
                [
                    "chair" => 'Public Relations',
                    "name" => 'Noah Bryant'
                ],
                [
                    "chair" => 'Probatemaster',
                    "name" => 'Josh Philliber'
                ],
                [
                    "chair" => 'RECKruitment',
                    "name" => 'Halle Bryan'
                ],
                [
                    "chair" => 'T-Book',
                    "name" => 'Katie Coveny'
                ],
                [
                    "chair" => 'T-Night',
                    "name" => 'Marissa Klee'
                ],
                [
                    "chair" => 'Technology',
                    "name" => 'Ethan Rosman'
                ],
                [
                    "chair" => 'Traditions',
                    "name" => 'Isabelle Liffiton'
                ]);

            foreach ($chairs as $item) {
                echo "<p><strong>". $item["chair"] .":</strong> " . $item["name"] . "</p>";
            }

            ?>
        </div>
    </div>
    <hr class="mb-3">
    <h4 class="mb-3">Members</h4>
    <div class="row">
        <div class="col-md-2">
            <?php $members = ['Abi Ivemeyer','Amanda Healy','Benjamin Damus','Brandon Dobson','Brayton Miles','Brittany Powell', 'Brooke Brennan','Cade Lawson']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-2">
            <?php $members = ['Caroline Means', 'Daley Cass','Davis Burson','Ebie McDonnell','Ethan Kreager','Ethan Rosman', 'Gracie Curran','Inika Jain']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-2">
            <?php $members = ['Isabel Wickliffe','Isabelle Liffiton','Jake Grant','Jill Riley','Jo\'De Cummings','Josh Philliber', 'Kassie Lee']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-2">
            <?php $members = ['Katie Coveny','Kayleigh Nortje','Laura Hancher','Macey Parrott','Marissa Klee','Matt DeJonge','McKade Stewart']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-2">
            <?php $members = ['Noah Bryant', 'Robert Cottingham','Ronnie Ludwin','Samantha White','Sunny Thomson','Sydney Weisenburger','Zoe Sieling']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
    </div>
    <hr class="mb-3">
    <h4 class="mb-4">Probates</h4>
    <div class="row mb-3">
        <div class="col-md-3">
            <?php $members = ['Adam Lederer','Ally Rosenthal','Annie Robinson','Brendan Mindiak', 'Brittany Ritter']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-3">
            <?php $members = ['Dean Plaskon','Derek Prusener','Diana Michael', 'Haley McElroy']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-3">
            <?php $members = ['Jack Crawford',"Jen O'Brien",'Katie Earles','Kirby Crisswell']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
        <div class="col-md-3">
            <?php $members = ['Michael Xiao','Rachel Hurst','Whitney Miller', 'William Platt']; ?>
            <?php
            foreach ($members as $item) {
                echo "<p>" . $item . "</p>";
            }
            ?>
        </div>
    </div>
    <hr class="mb-3">
</div>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>
