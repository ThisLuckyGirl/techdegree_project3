<?php
//page will add new entries to journal - includes textboxes to create entry title,
// date, time spent, what was learned, and resources to remember

// filter POST data, call function to add data to db, and redirect to home page/index page
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $timeSpent = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING));
    //call add entry function and redirect to index.php
    if (add_entry($title, $date, $timeSpent, $learned, $resources)) {
        header('location: index.php');
        exit;
    //error message if add entry fails
    } else {
        $error_message = 'Could not add entry';
        echo $error_message;
    }
}

//function to add new entries to database
function add_entry($title, $date, $timeSpent, $learned, $resources, $id = null) {
    include 'inc/connection.php';
  $sql = 'INSERT INTO entries(title, date, time_spent, learned, resources)
    VALUES (?, ?, ?, ?, ?)';

    //prepared statement
    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $timeSpent, PDO::PARAM_STR);
        $results->bindValue(4, $learned, PDO::PARAM_STR);
        $results->bindValue(5, $resources, PDO::PARAM_STR);
        if ($id) {
            $results->bindValue(6, $id, PDO::PARAM_STR);
        }
        $results->execute();
    //catch errors
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return true;
}
include("inc/header.php");
?>

<section>
    <div class="container">
        <!--changed class from div to form and created POST method to post data-->
            <h2>New Entry</h2>
            <form class="new-entry" method="post" action="new.php">
                <label for="title"> Title</label>
                <input id="title" type="text" name="title"><br>
                <label for="date">Date</label>
                <input id="date" type="date" name="date"><br>
                <label for="time-spent"> Time Spent</label>
                <input id="time-spent" type="text" name="timeSpent"><br>
                <label for="what-i-learned">What I Learned</label>
                <textarea id="what-i-learned" rows="5" name="whatILearned"></textarea>
                <label for="resources-to-remember">Resources to Remember</label>
                <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"></textarea>
                <input type="submit" value="Publish Entry" class="button">
                <a href="index.php" class="button button-secondary">Cancel</a>
            </form>
        </div>
    </div>
</section>

<?php include("inc/footer.php"); ?>
