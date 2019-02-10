<?php
//filter id and use it to access project details
if (isset($_GET['id'])) {
    list($id, $title, $date, $timeSpent, $learned, $resources)
    = get_entry(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $timeSpent = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING));
    if (add_entry($title, $date, $timeSpent, $learned, $resources)) {
        //var_dump($title, $date, $timeSpent, $learned, $resources);
        header('location: index.php');
        exit;
    } else {
        $error_message = 'Could not add entry';
        echo $error_message;
    }
}
//function add entries to database
function add_entry($title, $date, $timeSpent, $learned, $resources, $id = null) {
    include 'inc/connection.php';
    if ($id) {
        $sql = 'UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources =?
        WHERE id = ?';
    } else {
    $sql = 'INSERT INTO entries(title, date, time_spent, learned, resources)
    VALUES (?, ?, ?, ?, ?)';
    }
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
        <!--<div class="new-entry">-->
        <!--create POST method-->
            <h2>New Entry</h2>
            <form class="new-entry" method="post" action="new.php">
                <!--<div class="new-entry" method="post" action="new.php">-->
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
