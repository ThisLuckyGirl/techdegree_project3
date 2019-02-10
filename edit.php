<?php
//page allows user to edit or delete existing journal entries

//filter id and use it to access project details
if(isset($_GET['id'])) {
    $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
    $entry = get_entry($id);
}

//function to access journal entry by entry id
function get_entry($id){
include("inc/connection.php");
//prepared statement to prepare and bind data
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

//if statement to filter POST data and call either edit or delete function
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $timeSpent = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING));
    $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
    $resources = trim(filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING));

//call edit function and redirect to index.php
    if ($_POST['edit']) {
        update_entry($title, $date, $timeSpent, $learned, $resources, $id);
            header('location: index.php');
            exit;
//call delete function and redirect to index.php
    } else if ($_POST['delete']) {
          delete_entry(filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT));
          header('location: index.php');
          exit;
    }
}


//edit(update) function
function update_entry($title, $date, $timeSpent, $learned, $resources, $id) {
    include 'inc/connection.php';

        $sql = 'UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ?
        WHERE id = ?';

    //prepared statement - bind all variables
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
    //prepared statement - execute
        $results->execute();
    //prepared statement - catch errors
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return true;
}

//function to delete entries
function delete_entry($id) {
    include 'inc/connection.php';

    $sql = 'DELETE FROM entries WHERE id = ?';

    //prepared statement
    try {
    //prepared statement - bind id variable and execute
        $results = $db->prepare($sql);
        $results->bindValue(1, $id, PDO::PARAM_INT);
        $results->execute();
    //prepared statement - catch errors
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
                <input type="submit" value="Edit Entry" class="button" name="edit">
                <a href="index.php" class="button button-secondary">Cancel</a>

                <input type="hidden" value="<?php echo $entry['id']; ?>" name="delete">
                <input type="submit" class="button" value="Delete">


            </form>
        </div>
    </div>
</section>
<?php include("inc/footer.php"); ?>
