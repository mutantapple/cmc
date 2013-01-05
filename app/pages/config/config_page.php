<?php
//fix commonly empty values

if (!key_exists('enable-command-block', $data))
{
    $data['enable-command-block']=false;
}

if (!key_exists('scooper-enabled', $data))
{
    $data['scooper-enabled']=false;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<?php pf_core::loadTemplate('header'); ?>
                <style>
                    select {width:100px;}
                    input[type=text] {
                       width: 100px;
                    }
                </style>
	</head>
        
        <body>
        <?php pf_core::loadTemplate('menu'); ?>
            
            <div class="container">
                <div class="row">
                    <h1 class="center">Config Your Server</h1>
                    <p class="warning center span6 offset3"><b>WARNING</b>:Currently only letters and number are allowed in text. All spaces/special characters are removed</p>
                </div>

                <div class="row">
                                    
                                    <?php pf_forms::createForm('form', 'config_form span6 offset3', pf_config::get('main_page') . '/config/savesettings', 'POST')?>
                                    
                                        <legend class="center">Common Settings</legend>
                                        <table>
                                            <tr>
                                            <th width="33%">Setting</th>
                                            <th width="33%">Value</th>
                                            </tr>
                                            <tr>
                                                <td>Difficulty: </td>
                                                <td>
                                                    <?php pf_forms::options('difficulty', 'difficulty',array('0'=>'Peaceful','1'=>'Easy','2'=>'Normal','3'=>'Hard'),$data['difficulty'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Game Mode</td>
                                                <td>
                                                    <?php pf_forms::options('gamemode', 'gamemode',array('0'=>'Survival','1'=>'Creative','2'=>'Adventure'),$data['gamemode'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Hardcore</td>
                                                <td>
                                                    <?php pf_forms::options('hardcore', 'hardcore',array('True'=>'True','False'=>'False'),$data['hardcore'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>World</td>
                                                <td><?php pf_forms::text('level-name', TRUE, $data['level-name'])?></td>
                                            </tr>
                                            <tr>
                                                <td>Seed</td>
                                                <td><?php pf_forms::text('level-seed', NULL, $data['level-seed'],'Level Seed')?></td>
                                            </tr>
                                            <tr>
                                                <td>Max Players</td>
                                                <td><?php pf_forms::text('max-players', TRUE, $data['max-players'],'Max-Players')?></td>
                                            </tr>
                                            <tr>
                                                <td>MOTD</td>
                                                <td><input type="text" name="motd"  required value="<?php echo $data['motd']; ?>"/></td>
                                            </tr>
                                            <tr>
                                                <td>PVP</td>
                                                <td>
                                                    <?php pf_forms::options('pvp', 'pvp',array('TRUE'=>'True','FALSE'=>'False'),$data['pvp'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Spawn Animals</td>
                                                <td>
                                                    <?php pf_forms::options('spawn-animals', 'spawn-animals',array('TRUE'=>'True','FALSE'=>'False'),$data['spawn-animals'])?>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td>Spawn Monsters</td>
                                                <td>
                                                    <?php pf_forms::options('spawn-monsters', 'spawn-monsters',array('TRUE'=>'True','FALSE'=>'False'),$data['spawn-monsters'])?>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td>Spawn NPC's</td>
                                                <td>
                                                    <?php pf_forms::options('spawn-npcs', 'spawn-npcs',array('TRUE'=>'True','FALSE'=>'False'),$data['spawn-npcs'])?>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td>Texture Pack</td>
                                                <td><?php pf_forms::text('texture-pack', NULL, $data['texture-pack'],'Texture-Pack')?></td>
                                            </tr>
                                            <tr>
                                                <td>View Distance:</td>
                                                <td>
                                                    <?php pf_forms::options('view-distance', 'view-distance',array('3'=>'Close','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'Default','11'=>'11','12'=>'12','13'=>'13','14'=>'14'),$data['view-distance'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><legend class="center">Other Settings</legend></td>
                                            </tr>
                                            <tr>
                                                <td>Allow Flight:</td>
                                                <td>
                                                    <?php pf_forms::options('allow-flight', 'allow-flight',array('TRUE'=>'True','FALSE'=>'False'),$data['allow-flight'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Enable Query:</td>
                                                <td>
                                                    <?php pf_forms::options('enable-query', 'enable-query',array('TRUE'=>'True','FALSE'=>'False'),$data['enable-query'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Enable Rcon:</td>
                                                <td>
                                                    <?php pf_forms::options('enable-rcon', 'enable-rcon',array('TRUE'=>'True','FALSE'=>'False'),$data['enable-rcon'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Enable Command Block:</td>
                                                <td>
                                                    <?php pf_forms::options('enable-command-block', 'enable-command-block',array('TRUE'=>'True','FALSE'=>'False'),$data['enable-command-block'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Generate Structures:</td>
                                                <td>
                                                    <?php pf_forms::options('generate-structures', 'generate-structures',array('TRUE'=>'True','FALSE'=>'False'),$data['generate-structures'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Generator Settings:</td>
                                                <?php if (!key_exists('generator-settings', $data)) $data['generator-settings']=''?>
                                                <td><?php pf_forms::text('generator-settings', NULL, $data['generator-settings'],'generator-settings')?></td>
                                            </tr>
                                            <tr>
                                                <td>Level Type:</td>
                                                <td>
                                                    <?php pf_forms::options('level-type', 'level-type',array('DEFAULT'=>'DEFAULT','FLAT'=>'FLAT','LARGEBIOMES'=>'LARGEBIOMES'),$data['level-type'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Max Build Height:</td>
                                                <td><?php pf_forms::text('max-build-height', TRUE, $data['max-build-height'],'max-build-height')?></td>
                                            </tr>
                                            <tr>
                                                <td>Online Mode:</td>
                                                <td>
                                                    <?php pf_forms::options('online-mode', 'online-mode',array('TRUE'=>'True','FALSE'=>'False'),$data['online-mode'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Query Port:</td>
                                                <?php if (!key_exists('query-port', $data)) $data['query-port']=''?>
                                                <td><?php pf_forms::text('query-port', NULL, $data['query-port'],'query-port')?></td>
                                            </tr>
                                            <tr>
                                                <td>Rcon Password:</td>
                                                <?php if (!key_exists('rcon-password', $data)) $data['rcon-password']=''?>
                                                <td><?php pf_forms::text('rcon-password', NULL, $data['rcon-password'],'rcon-password')?></td>
                                            </tr>
                                            <tr>
                                                <td>Server IP:</td>
                                                <td><?php pf_forms::text('server-ip', NULL, $data['server-ip'],'server-ip')?></td>
                                            </tr>
                                            <tr>
                                                <td>Server Port:</td>
                                                <td><?php pf_forms::text('server-port', TRUE, $data['server-port'],'server-port')?></td>
                                            </tr>
                                            <tr>
                                                <td>Scooper Enabled:</td>
                                                <td>
                                                    <?php pf_forms::options('scooper-enabled', 'scooper-enabled',array('TRUE'=>'True','FALSE'=>'False'),$data['scooper-enabled'])?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Spawn Protection:</td>
                                                <td><?php pf_forms::text('spawn-protection', TRUE, $data['spawn-protection'],'spawn-protection')?></td>
                                            </tr>
                                            <tr>
                                                <td>White List:</td>
                                                <td>
                                                    <?php pf_forms::options('white-list', 'white-list',array('TRUE'=>'True','FALSE'=>'False'),$data['white-list'])?>
                                                </td>
                                            </tr>
                                         </table>
                                            <input type="submit" value="Save" class="button rounded span4"/>
                                    </form>
			</div><!-- END ROW -->
                    </div>
            <?php pf_core::loadTemplate('footer'); ?>
	</body>
</html>