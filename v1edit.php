<?php
//include("inc/connection.php");

//function to update/edit entries
/*function get_entry($id){
    $sql = 'SELECT title, date, time_spent, learned, resources FROM entries WHERE id = ?';

    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $timeSpent, PDO::PARAM_STR);
        $results->bindValue(4, $learned, PDO::PARAM_STR);
        $results->bindValue(5, $resources, PDO::PARAM_STR);
        $results->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return $results->fetch();
}*/
/*
if(isset($_GET['id'])) {
    $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
}

//prepared statement to filter input
include("inc/connection.php");

    try {
        $results = $db->prepare('SELECT * FROM entries WHERE id = ?');
        $results->bindParam(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "</br>";
        return false;
    }

$details = $results->fetch(PDO::FETCH_ASSOC);
*/


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $timeSpent = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING));

    if (update_entry($title, $date, $timeSpent, $learned, $resources)) {
        //var_dump($title, $date, $timeSpent, $learned, $resources);
        header('Location: index.php');
        exit;
    } else {
        $error_message = 'Could not add entry';
        echo $error_message;
    }
}

//function add entries to database
function update_entry($title, $date, $timeSpent, $learned, $resources, $id = null) {
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
            $results->bindValue(6, $id, PDO::PARAM_INT);
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
        <div class="edit-entry">
            <h2>Edit Entry</h2>
            <form class="edit-entry" method="post" action="edit.php">
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
                <?php
                if (!empty($id)) {
                    echo '<input type="hidden" name="id" value"' . $id . '" />';
                }
                 ?>
                <input type="submit" value="Edit Entry" class="button">
                <a href="#" class="button button-secondary">Cancel</a>
            </form>
        </div>
    </div>
</section>
<?php include("inc/footer.php"); ?>
