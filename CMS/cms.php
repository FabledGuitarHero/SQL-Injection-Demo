<?php

 /*
  *  Vulnerable PHP CMS - handles no sanatizing or validation of input,
  *  and allows a potentional hacker to exploit HTML content housed
  *  directly in an SQL Database.
  */

  class cms{

    var $host;
    var $username;
    var $password;
    var $table;
    var $con;

  /*
   * Path that holds all the templates for various pages
   */
    var $template_path = "templates/";


   /*
    * CMS Constructor
    */
    public function __construct($newHost, $newUserName, $newPassword, $newDatabase){
      $this->host = $newHost;
      $this->username = $newUserName;
      $this->password = $newPassword;
      $this->table = $newDatabase;
    }

   /*
    * Function that renders the page content of the selected ID.
    * INSECURE:
    *    Pulls direct PHP from a database, leading to potential manipluation
    *    of direct HTML page content.
    */
    public function render($filename){
      $fetch = "SELECT bodytext FROM pageTable WHERE id = ".$filename.";";
      $result = mysqli_query($this->con, $fetch);


      include "templates/header.php";
      while($assoc = mysqli_fetch_assoc($result)){
        print_r($assoc['bodytext']);
      }
      include "templates/footer.php";
    }

   /*
    * Admin page included to add HTML content to the database easier
    */
    public function display_admin(){
         return <<<ADMIN_FORM
        <form action="{$_SERVER['PHP_SELF']}" method="post">
          <label for="title">Title:</label>
          <input name="title" id="title" type="text" maxlength="150" /></br>
          <label for="id">ID:</label>
          <input name="id" id="id" type="text" /></br>
          <label for="bodytext">Body Text:</label></br>
          <textarea name="bodytext" id="bodytext"></textarea></br>
          <input type="submit" value="Create This Entry!" />
        </form>
ADMIN_FORM;
    }

   /*
    * Function that writes page content to the database
    */
    public function write($post){
      var_dump($post);
      if ($post['title'])
        $title = mysqli_real_escape_string($this->con, $post['title']);
      if ($post['id'])
        $id = mysqli_real_escape_string($this->con, $post['id']);
      if ($post['bodytext'])
        $bodytext = mysqli_real_escape_string($this->con, $post['bodytext']);
      if ($title && $bodytext && $id){
        $created = time();
        $sql = "INSERT INTO pageTable VALUES('$id','$title','$bodytext','$created')";
        echo $id." ".$title." ".$bodytext." ".$created;
        return mysqli_query($this->con, $sql);
      }
      else {
        return false;
      }
    }


   /*
    * Connects to the database
    */
    public function connect(){
      $this->con = mysqli_connect($this->host, $this->username, $this->password) or die ("Bad connection" . mysqli_error());
      mysqli_select_db($this->con,$this->table) or die ("Bad database".mysqli_error());

      return $this->writeDB($this->con);
    }

   /*
    * If the Page Table doesn't exist, creates it.
    */
    public function writeDB($con){
      $sql = "
      CREATE TABLE IF NOT EXISTS pageTable(
          id INTEGER UNIQUE,
          title VARCHAR(150),
          bodytext TEXT,
          created VARCHAR(150));";

      return mysqli_query($con, $sql);
    }
}
?>
