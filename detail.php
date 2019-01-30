<?php
//include("inc/connection.php");

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


include("inc/header.php");
?>


<section>
    <div class="container">
        <div class="entry-list single">
            <article>
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
                    <ul>
                        <li><a href=""><?php echo $details['resources']; ?></a></li>
                    </ul>
                </div>
            </article>
        </div>
    </div>
    <div class="edit">
        <p><a href="edit.php">Edit Entry</a></p>
    </div>
</section>

<?php include("inc/footer.php"); ?>
