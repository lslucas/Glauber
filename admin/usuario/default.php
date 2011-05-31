<?php

  if (isset($_POST['act'])) {
  include_once 'mod.exec.php';

   } elseif (isset($_GET['insert']) XOR isset($_GET['update'])) {
    include_once 'form.php';

     } elseif (isset($_GET['delete'])) {
      include_once 'mod.delete.php';

       } elseif (isset($_GET['status'])) {
      	include_once 'mod.status.php';

         } elseif (isset($_GET['alterasenha'])) {

           if(isset($_POST['senha_atual']))
            include_once 'alterasenha.mod.exec.php';

             else include_once 'alterasenha.form.php';

            } else {
             include_once 'list.php';

            }
