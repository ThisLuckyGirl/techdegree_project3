<?php include("inc/header.php");
include("inc/connection.php");


if(!empty($_GET['id'])) {
    $id = $_GET['id'];
}



try {
    $results = $db->query('SELECT * FROM entries WHERE id = 15');
} catch(Exception $e) {
    echo $e->getMessage();
    die();
}

$journalEntry = $results->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
        <section>
            <div class="container">
                <div class="entry-list single">
                    <article>
                        <h1><?php echo $journalEntry['title']; ?></h1>
                        <time datetime="2016-01-31"><?php echo $journalEntry['date']; ?></time>
                        <div class="entry">
                            <h3>Time Spent: </h3>
                            <p><?php echo $journalEntry['time_spent']; ?></p>
                        </div>
                        <div class="entry">
                            <h3>What I Learned:</h3>
                            <p><?php echo $journalEntry['learned']; ?></p>
                        </div>
                        <div class="entry">
                            <h3>Resources to Remember:</h3>
                            <ul>
                                <li><a href=""><?php echo $journalEntry['resources']; ?></a></li>
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
            <div class="edit">
                <p><a href="edit.php">Edit Entry</a></p>
            </div>
        </section>
    </body>
</html>
<?php include("inc/footer.php"); ?>
