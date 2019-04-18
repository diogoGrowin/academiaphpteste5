<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
</head>
<body>

<div name="top" style=" padding-left: 2em;">

<ul style="list-style-type: none; margin: 0; padding: 0;">
    <!-- file of routes to decide where to go next-->
    <li style="display: inline; padding-right: 2em;;"><?php  if(isset($session)){echo ' User: '.$_SESSION['username'];} ?></li>
    <li style="display: inline;"><a href="<?php echo '/logout'; ?>">Logout</a></li>
</ul>

</div>

<div name="middle" style=" padding-left: 3em;">

    <h2>Main Page</h2>
    
    <ul>
        <!-- file of routes to decide where to go next-->
        <li><a href="<?php echo '/show_logs'; ?>">View All Logs</a></li>
        <li style="list-style-type: none;"><br/></li>
    </ul>

    <?php
/*     global $db;
        var_dump($db);exit(); */
    ?>
<br/>
    	<form action="/upload_file" method="POST" enctype="multipart/form-data">	<!-- mandatory the enctype for file upload -->
			<p>Choose a CSV file to upload:</p>

			<!-- MAX_FILE_SIZE attribute  to allow max size-->
			<!-- <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" /> -->
			
			<input type="file" name="csv_file" /> &nbsp;
			<input type="submit" name="submit" value="Upload file" />
		</form>


    <navigation>
    <br/><br/><br/>

    <div class="">
			<p>Select Indexes</p>
	    	<label for="indexes">Indexes</label>
			<select class="" id="indexes" name="index"> 

				<option value="" selected="selected"></option>
                <?php  
                /* foreach($object as $pais)
	                {   
	                    echo "<option value=\"" . htmlspecialchars($pais->id) . "\""; 	    //guarda o id dos paise  
	                    echo ">" . htmlspecialchars($pais->symbol) . "</option>"; 			//mostra o nome dos paises
	            }  */
	            ?>
	            </select>
		</div> 

    <navigation>
    <br/>

    <div id="result">
    </div>


<!--     <script>

    var select_box=document.getElementById("indexes");      //find html object by id
    var result_content=document.getElementById("result");   //get result div object

    function show_content()
    {
        //ajax

        var select_box_id=select_box.options[select_box.selectedIndex].value;   //get the index value used from select box

        console.log("id: "+select_box_id);  //debug

        var xhr= new XMLHttpRequest();                          //new ajax

        //var url='/index.php?method=ajax&id='+select_box_id;
        //var url='/ajax'+select_box_id;
        var url='/ajax';

        xhr.open('POST',url,true);                               //process ajax request page

        xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');                  //set header to be a request by AJAX
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');   //send ajax request as POST

        console.log("url: "+url);  //debug

        xhr.onreadystatechange= function()
        {   
            //console.log('Ready State: '+xhr.readyState);        //print to console browser the states 
            if(xhr.readyState == 4 && xhr.status == 200)
            {   
                //AJAX response
                //console.log('Response: '+xhr.responseText);       //print result
                var result = xhr.responseText;                      // retrive result 

                //validate
                console.log(result);

                var json=JSON.parse(result);                        //since its JSON obj, need to decode it first

                //console.log(json);
                result_content.innerHTML='Symbol: ' + json.symbol + '<br/>' +'Description: '+ json.description + '<br/>' + 'Spread Target Standard: ' + json.spread_target_standard 
                + '<br/>' + 'Trading Hours : ' + json.trading_hours +  '<br/>' + 'Type : ' + json.type_definition ;
            }
        }

        xhr.send('id='+select_box_id);                                             //call ajax request
    }

    select_box.addEventListener('change',show_content);         //call ajax function on action change of selectbox

    </script> -->



</div>

</body>
</html>