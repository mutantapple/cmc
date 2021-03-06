<?php

class settings extends pf_controller
{
    
    public function index()
    {
        $this->checkLogin();
        
        $userlevels = CMC::getCMCSetting('pageaccess');
        //lock to user level
        pf_auth::lockPage($userlevels['settings'], 'Sorry, You do not have access to this page!');
        
        $data = array();
        
        //write the new settings
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            CMC::writeCMCSetting('bukkit_dir', trim($_POST['bukkit_dir']));
            CMC::writeCMCSetting('update_channel', $_POST['update_channel']);
            CMC::writeCMCSetting('custom_url', trim($_POST['custom_url']));
            CMC::writeCMCSetting('log_lines', $_POST['log_lines']);
            CMC::writeCMCSetting('restart_check', $_POST['auto_restart']);
            CMC::writeCMCSetting('jarfile', trim($_POST['jarfile']));
            $data['saved']=true;
        }
        else
        {
        $data['saved']=false; //we didn't save any settings
        }
        
        //get the old settings and display them
        $data['bukkit_dir'] = CMC::getCMCSetting('bukkit_dir');
        $data['update_channel'] = CMC::getCMCSetting('update_channel');
        $data['custom_url'] = CMC::getCMCSetting('custom_url');
        $data['log_lines'] = CMC::getCMCSetting('log_lines');
        $data['restart_check'] = CMC::getCMCSetting('restart_check');
        $data['jarfile'] = CMC::getCMCSetting('jarfile');
        
        $this->loadView('settings/settings_page.php',$data);
    }
}
?>
