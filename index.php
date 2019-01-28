<?php include("inc/header.php");
//require('inc/journal.db');

try {
    $results = $db->query('SELECT * FROM entries');
} catch(Exception $e) {
    echo $e->getMessage();
    die();
}

$journalEntries = $results->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
        <section>
            <div class="container">
                <div class="entry-list">
                  <ol>
                    <?php
                        foreach($journalEntries as $journalEntry) {
                            echo '<li><a href="detail.php">' .
                            $journalEntry[$title] . $journalEntry[$date] . '</li>';
                        }
                    ?>
                  <!--
                    <article>
                        <h2><a href="detail.php">The best day I’ve ever had</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                    <article>
                        <h2><a href="detail_2.php">The absolute worst day I’ve ever had</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                    <article>
                        <h2><a href="detail_3.php">That time at the mall</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                    <article>
                        <h2><a href="detail_4.php">Dude, where’s my car?</a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                  -->
                </div>
            </div>
        </section>
</html>
<?php include("inc/footer.php"); ?>
