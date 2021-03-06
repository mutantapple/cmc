<?php 
if ($data['last_backup']==false)
{
    $last_backup = '<span style="color:red;">No Previous Backups! BAD ADMIN!</span>';
}
else $last_backup = $data['last_backup'];

//get scheduled backup count
$backups = CMC::getCMCSetting('scheduled_backups');

if ($backups)
{
$number = count($backups);
}
 else 
{
$number = 0;    
}

?>

<!DOCTYPE html>
<html>
	<head>
            <?php pf_core::loadTemplate('header'); ?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            
            <script>
            $(document).ready(function() {
                $('.success').click(update);
                $('#backingup').hide();
                $('#listing').load('<?php echo pf_config::get('main_page')?>/backups/view');
            });
            
            function update()
            {
                $('#main').hide();
                $('#backingup').show();
            }
            
            </script>
            
	</head>
        <body>
        <?php pf_core::loadTemplate('menu'); ?>
            <h3 class="center">Backup Management</h3>
                        
                <div id='loading' class="row">
                    <div class="six columns offset-by-three">
                    <div id='backingup' class="info" style="margin-bottom:25px;">BACKUP IN PROGRESS!<br /></div><br /><br />
                    </div>
                </div>
                <div class="row">
                    <div class="six columns offset-by-three">
                    <div class="info">Warning: Backups can take a long time to complete.<br /></div><br />
                    </div>
                </div>
                
                <div id="main" class="row">
                    <div class="six columns">
                        
                    <?php pf_forms::createForm('backup', 'ten columns backupform panel', MAIN_PAGE."/backups/action", 'POST'); ?>
                    
                    <p><b>Your Last Backup Was:</b> <?php echo $last_backup; ?><br /></p>
                    
                    <p><b>Check the worlds you wish to backup.</b></p>
                    <label class="checkbox"><?php pf_forms::checkbox('world1', $data[0], $data[0]);?></label>
                    <label class="checkbox"><?php if (key_exists(1, $data)) pf_forms::checkbox('world2', $data[1], $data[1]);?></label>
                    <label class="checkbox"><?php if (key_exists(2, $data)) pf_forms::checkbox('world3', $data[2], $data[2]);?></label><br />
                    <?php pf_forms::button('submit', 'Manual Backup', 'twelve button rounded success'); ?>
                    <?php pf_forms::closeForm();?>
                    <br />
                    </div>
                    <div class="six columns panel">
                        You have <b><?php echo $number; ?></b> Backups Scheduled<br /><br />
                        <b></b>
                        <?php 
                        if ($backups)
                        {
                            foreach ($backups as $world=>$time)
                            {
                                echo "<b>$world</b>" . ' at ' . $time . '00 hours - daily'."<br />\n<br />\n";
                            }
                        }
                        ?>
                        
                        
                        <a href="<?php echo MAIN_PAGE ?>/worlds" class="rounded button secondary">View/Edit Schedules</a>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div id="listing" class="twelve columns">
                    
                </div>
                </div>
            <?php pf_core::loadTemplate('footer'); ?>
    </body>
</html>
