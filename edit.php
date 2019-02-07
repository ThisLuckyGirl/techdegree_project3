<?php
//include("inc/connection.php");

if(isset($_GET['id'])) {
    $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
    $entry = get_entry($id);
}

if(isset($_POST['delete'])) {
    delete_entry(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT));
    header('location: index.php');
    exit;
}


//prepared statement to filter input to be displayed
function get_entry($id){
include("inc/connection.php");

$sql = 'SELECT * FROM entries WHERE id = ?';
    try {
        $results = $db->prepare($sql);
        $results->bindParam(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "</br>";
        return false;
    }
    return $results->fetch();
  }
//$details = $results->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $timeSpent = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING));

    if (update_entry($title, $date, $timeSpent, $learned, $resources, $id)) {
        //var_dump($title, $date, $timeSpent, $learned, $resources);
        header('Location: index.php');
        exit;
    } else {
        $error_message = 'Could not update entry';
        echo $error_message;
    }
}

function update_entry($title, $date, $timeSpent, $learned, $resources, $id) {
    include 'inc/connection.php';

    if (isset($id)) {
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

function delete_entry($id) {
    include 'inc/connection.php';

    //$sql = 'DELETE id, title, date, time_spent, learned, resources
            //FROM entries WHERE id = ?';

    $sql = 'DELETE FROM entries WHERE id = ?';

    try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();
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
                <input id="title" type="text" name="title" value="<?php if(isset($entry['title'])) { echo $entry['title'];}?>"><br>
                <label for="date">Date</label>
                <input id="date" type="date" name="date" value="<?php if(isset($entry['date'])) { echo $entry['date'];}?>"><br>
                <label for="time-spent"> Time Spent</label>
                <input id="time-spent" type="text" name="timeSpent" value="<?php if(isset($entry['time_spent'])) { echo $entry['time_spent'];}?>"><br>
                <label for="what-i-learned">What I Learned</label>
                <textarea id="what-i-learned" rows="5" name="whatILearned"><?php if(isset($entry['learned'])) { echo $entry['learned'];}?></textarea>
                <label for="resources-to-remember">Resources to Remember</label>
                <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"><?php if(isset($entry['resources'])) { echo $entry['resources'];}?></textarea>
                <?php
                if (!empty($id)) {
                    echo '<input type="hidden" name="id" value="' . $id . '" />';
                }
                 ?>
                <input type="submit" value="Edit Entry" class="button">
                <a href="index.php" class="button button-secondary">Cancel</a>

                <input type="hidden" value="<?php echo $entry['id']; ?>" name="delete">
                <input type="submit" class="button" value="Delete">


            </form>
        </div>
    </div>
</section>
<?php include("inc/footer.php"); ?>
