# techdegree_project3
Unit 3 project for TalentPath PHP cohort

Build a Personal Learning Journal

Create a local web interface of a learning journal. The main (index) page will list journal entry titles and dates. 
Each journal entry title will link to a detail page that displays the title, date, time spent, what you learned, and 
resources to remember. Include the ability to add or edit journal entries. When adding or editing a journal entry, 
there must be prompts for title, date, time spent, what you learned, resources to remember. The results for these entries must be stored in a SQLite database and displayed in a blog style website. The SQLite Database/HTML/CSS for this site has been supplied for you.

Project Instructions:

* Create a PDO connection to the SQLite (database.db) file within the inc folder.
* Use prepared statements to add/edit/delete journal entries in the database.
* Create “add/edit” view for the "entry" page that allows the user to add or edit journal entries with the following fields:     title, date, time_spent, learned, and resources. Each journal entry should have a unique primary key.
* Create "list" view for the "index" page. The list view contains a list of journal entries, which displays Title and Date of   each Entry. The title should be hyperlinked to the detail page for each journal entry. 
  Entries should be sorted by date. 
* Include a link to add an entry.
* Create "details" view with the entries displaying the journal entry with all fields: title, date, time_spent, learned, 
  and resources. Include a link to edit the entry.
* Add the ability to delete a journal entry.
* Use the supplied HTML/CSS to build and style your pages. Use CSS to style headings, font colors, journal entry 
  container colors, body colors.
