<?php
//page displays individual journal entry details
//includes link to edit.php, which allows user to edit or delete entry

//filter GET data and set to id variable
if(isset($_GET['id'])) {
    $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
}

//include connection to database
include("inc/connection.php");

//prepared statement - prepare data, bind, and execute
try {
    $results = $db->prepare('SELECT * FROM entries WHERE id = ?');
    $results->bindParam(1, $id, PDO::PARAM_INT);
    $results->execute();
} catch (Exception $e) {
    echo "Error!: " . $e->getMessage() . "</br>";
    return false;
}

$details = $results->fetch(PDO::FETCH_ASSOC);


include("inc/header.php");
?>


<section>
    <div class="container">
        <div class="entry-list single">
            <article>
                <!--display all entry details-->
                <h1><?php echo $details['title']; ?></h1>
                <time datetime="2016-01-31"><?php echo $details['date']; ?></time>
                <div class="entry">
                    <h3>Time Spent: </h3>
                    <p><?php echo $details['time_spent']; ?></p>
                </div>
                <div class="entry">
                    <h3>What I Learned:</h3>
                    <p><?php echo $details['learned']; ?></p>
                </div>
                <div class="entry">
                    <h3>Resources to Remember:</h3>
                    <p>
                    <?php echo $details['resources']; ?>
                    </p>
                </div>
            </article>
        </div>
    </div>
    <div class="edit">
        <p><a href="edit.php?id=<?php echo $details['id']; ?>"> Edit Entry</a></p>
    </div>
</section>

<?php include("inc/footer.php"); ?>
