<?php
//convert to string
if ($data['current_cron'])
    $data['current_cron'] = 'TRUE';
else $data['current_cron'] = 'FALSE';
?>

<!DOCTYPE html>
<html>
	<head>
		<?php pf_core::loadTemplate('header'); ?>
            
                <script type="text/javascript" src="http://jsgauge.googlecode.com/svn/trunk/src/gauge.js"></script>
                <script type="text/javascript" src="http://jsgauge.googlecode.com/svn/trunk/src/jquery.gauge.js"></script>
		
                <style>
                    .online{color:green;}
                    .offline{color:red;}

                    #logload { white-space: pre; height:350px;overflow:auto;}
                    
                    #multijava{font-size:14px;color:red;}
                    
                    .serverwarning {color:red;}
                    .serverlog{margin-top:25px;}
                    
                    .button-group{background:none;}
                    
                    
		</style>
		<script>
			$('#tab a').click(function (e) {
  				e.preventDefault();
  				$(this).tab('show');
			})
		
                        //this deals with the CPU/MEM bar
                        function updatestats ()
                        {
                            //grab some general stats from the server
                            $.getJSON('<?php echo pf_config::get('base_url'); ?>index.php/data/general',function(data){
                            
                            //assign some vars based off the data
                            var cores = (data['CORES']); //number of cores on the server
                            var cpu = data['CPU'] / cores;
                            var mem = data['MEM'] ;
                            var multi = data['MULTI'];
                            
                            //if multiple java's are found we show the error
                            if (multi == true){
                                $('#multijava').show();
                            }
                            
                            $( "#cores").html('CPU Usage Based On '+ cores +' Cores');
                            
                            
                            //change the bar's width based on cpu and core
                            if (cores = 1)
                                {
                                    $('#cpu').gauge('setValue', cpu);
                                }
                            else if (cores = 2)
                                {
                                    $('#cpu').gauge('setValue', cpu / 2);
                                }
                            else if (cores = 4)
                                {
                                    $('#cpu').gauge('setValue', cpu / 4);
                                }
                            else if (cores = 8)
                                {
                                    $('#cpu').gauge('setValue', cpu / 8);
                                }
                                
                            //same with mem usage                                
                            $('#mem').gauge('setValue', mem);    
                                
                            }); //end main json data call
                            
                            //updates player info etc
                            serverinfo();
                            
                            //call yourself again after 10 seconds
                            setTimeout(updatestats,10000);
                        }
                        
                        
                        //this collects and reports server data from the minecraft server
                        function serverinfo()
                        {
                            $.getJSON('<?php echo pf_config::get('main_page'); ?>/data/info',function(data){
                                var online = data['online'];
                                
                                $( '#info' ).html (
                                "<b>Craftbukkit Version:</b> " +data['version'] +"<br />\n\
                                <b>Players Connected:</b> " + data['players'] + " of " + data['max_players'] + '<br />'
                                + '<b>MOTD:</b> ' + data['motd'] +'<br />')
                                
                                //if online
                                if (online)
                                    {
                                    $('#online').html('<b>Online-Status</b>:Online!')
                                    $('#online').css({'color':'green'});
                                    }
                                else
                                    {
                                    $('#online').html('<b>Online-Status</b>:Offline!')
                                    $('#online').css({'color':'red'});    
                                    }
                            
                            });
                        }
                        
                        //our document is ready, so let's fire off some functions
                        $(document).ready(function(){ 
                            $('#multijava').hide();
                            updatestats();
                            
                            $('#logload').load('<?php echo pf_config::get('main_page')?>/data/mainlog');
                            
                            $('#chat').click(function() {
                                $('#logload').load ('<?php echo pf_config::get('main_page')?>/data/chatlog');
                            });
                            
                            $('#all').click(function() {
                                $('#logload').load ('<?php echo pf_config::get('main_page')?>/data/mainlog');
                            });
                            
                            $('#errors').click(function() {
                                $('#logload').load ('<?php echo pf_config::get('main_page')?>/data/errorlog');
                            });
                            
                            $('#connections').click(function() {
                                $('#logload').load ('<?php echo pf_config::get('main_page')?>/data/connectionlog');
                            });
                            
                           $("#cpu")
                          .gauge({
                             colorOfCenterCircleFill:'#000000',//center of needle
                             colorOfCenterCircleStroke:'#000000',//outline of center
                             colorOfPointerFill:'#000000',//color of needle
                             colorOfPointerStroke:'#000000',//outline of needle
                             unitsLabel: '%',
                             majorTicks:10,
                             minorTicks:1, //number of ticks between major ticks
                             min: 0,
                             max: 100,
                             label: 'CPU',
                             bands: [
                                 {color: "#ffff00", from: 50, to: 74},
                                 {color: "#ff0000", from: 75, to: 100}
                                 ]
                           })
                           
                           $("#mem")
                          .gauge({
                             colorOfCenterCircleFill:'#000000',//center of needle
                             colorOfCenterCircleStroke:'#000000',//outline of center
                             colorOfPointerFill:'#000000',//color of needle
                             colorOfPointerStroke:'#000000',//outline of needle
                             unitsLabel: '%',
                             majorTicks:10,
                             minorTicks:1, //number of ticks between major ticks
                             min: 0,
                             max: 100,
                             label: 'MEM',
                             bands: [
                                 {color: "#ffff00", from: 50, to: 74},
                                 {color: "#ff0000", from: 75, to: 100}
                                 ]
                           })
                           
                          
                        });
		</script>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	
	<body>
        <?php pf_core::loadTemplate('menu'); ?>
            
            <!-- Content -->
                <div class="row">
                    <div id="multijava" class="twelve columns alert warning">
                        Multiple Java's have been found, perhaps you have
                        multiple server running due to an error? You should
                        fix this. Time to break out SSH! <--later we will offer to fix this
                    </div>
                </div>
            
                <div class="row">
                    <div class="twelve columns offset-by-three">
                            <h2 >CMC Server Overview</h2>
                    </div>
                </div>
            
                <div class="row">
                    <div class="twelve columns">

                        <div id="gauges" class="eight columns">
                                <h4 class="six columns centered offset-by-four">Server Load</h4>
                                
                                <div class="row">
                                    <div class="four columns offset-by-one"><canvas id="cpu" height="150" width="150"></canvas></div>
                                    <div class="four columns pull-one"><canvas id="mem" height="150" width="150"></canvas></div>
                                </div>
                                <p id='cores' class="twelve columns"style="text-align:center;">CPU Usage Based On X Cores</p>
                                
                                
                        </div>

                        <div class="four columns panel">
                            <h4 class="center">Quick Stats:</h4>
                            <div id="online">Online!</div>
                            <strong>Auto-Restart:</strong>  <?php echo $data['current_cron'];?><br>
                            <strong>Last Backup:</strong>  Differed to Beta<br>
                            <strong>Next Backup:</strong>  Differed to Beta<br>
                            <br />
                            <strong>Difficulty:</strong> <?php echo $data['difficulty'];?><br>
                            <strong>PvP:</strong><?php echo $data['pvp'];?><br>
                            <strong>Game Type:</strong> <?php echo $data['gamemode'];?><br>
                            <br />
                            <div id="info">&nbsp;</div>
                        </div>
                    </div>
                </div>
            
                <br />
                <hr>
                <br />
            <div class="row">
                <div class="twelve columns">
                    
                    <ul class="button-group even four-up">
                      <li id="all"><a href="#" class="button secondary">All Messages</a></li>
                      <li id="chat"><a href="#" class="button secondary">Chat Only</a></li>
                      <li id="errors"><a href="#" class="button secondary">Errors Only</a></li>
                      <li id="connections"><a href="#" class="button secondary">Connections</a></li>
                    </ul>
                    

                    <div id="logload" class="twelve columns panel">
                        
                    </div>
                    
                </div>
            </div>

        <?php pf_core::loadTemplate('footer'); ?>
    </body>
</html>