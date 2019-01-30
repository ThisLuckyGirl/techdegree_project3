<?php
include("inc/connection.php");

if(isset($_GET['id'])) {
    $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
    $entry = get_entry($id);
}

//prepared statement to filter input
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


include("inc/header.php");
?>


<section>
    <div class="container">
        <div class="edit-entry">
            <h2>Edit Entry</h2>
            <form class="edit-entry" method="post" action="edit.php">
                <label for="title"> Title</label>
                <input id="title" type="text" name="title" value="<?php echo $entry['title'];?>"><br>
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
