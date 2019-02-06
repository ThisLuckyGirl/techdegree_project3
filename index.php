<?php
include("inc/connection.php");


//query database and catch errors
try {
    $results = $db->query('SELECT * FROM entries ORDER BY date ASC');
} catch(Exception $e) {
    echo $e->getMessage();
    die();
}

// store results to variable
$journalEntries = $results->fetchAll(PDO::FETCH_ASSOC);

include("inc/header.php");
?>


<section>
    <div class="container">
        <div class="entry-list">
              <?php
                foreach($journalEntries as $journalEntry) {
                     echo '<article><h2><a href="detail.php?id='.$journalEntry['id'].'">' .
                     $journalEntry['title'] . '</a></h2>' .
                      '<time datetime="01-31-2018">' .
                      $journalEntry['date'] . '</time></article>';
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

<?php include("inc/footer.php"); ?>
