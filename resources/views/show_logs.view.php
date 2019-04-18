<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>All Logs</title>

    <style>
        table, th, td {
               border: 1px solid black;
           }
    </style>
</head>
<body>
    <a href="/index">&laquo; back</a>
    <h2>All Logs</h2>

<div style="margin-left: 20em; ">
    

    <form method="POST" action="/download_logs">
    <p>Number of Logs:  <?php echo $object2; ?> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <input type="submit" name="download" id="download" value="Download File">
    </p>

    </form>

    <table >
      <tr>
        <th>Username</th>
        <th>Action</th>
        <th>Time</th>
        <th>Description</th>
      </tr>
    
      <?php 
      
      foreach($object as $logs)   //the $object is defined on the template->render() method
      { 
        
      ?>
        <tr>
          <td><?php echo htmlspecialchars($logs->username); ?></td>
          <td><?php echo htmlspecialchars($logs->action); ?></td>
          <td><?php echo htmlspecialchars($logs->time_stamp); ?></td>
          <td><?php echo htmlspecialchars($logs->description); ?></td>
    	  </tr>
      <?php } ?>
      </table>
</div>

</body>
</html>