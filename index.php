<?php
//page displays a list of journal entries - includes title and date
//entries are displayed descending by entry date

//include connection.php to connect to database
include("inc/connection.php");

//query database and catch errors
try {
    $results = $db->query('SELECT * FROM entries ORDER BY date DESC');
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
                //display journal entry titles and dates
                foreach($journalEntries as $journalEntry) {
                     echo '<article><h2><a href="detail.php?id='.$journalEntry['id'].'">' .
                     $journalEntry['title'] . '</a></h2>' .
                      '<time datetime="01-31-2018">' .
                      $journalEntry['date'] . '</time></article>';
                       }
                ?>
        </div>
    </div>
</section>

<?php include("inc/footer.php"); ?>
