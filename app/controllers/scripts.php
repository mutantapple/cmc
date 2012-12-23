<?php

class scripts extends pf_controller
{
    public function index()
    {
        $this->checkLogin();
        
        $this->loadView('scripts/main_page');
    }
    
    //send a command to screen
    private function send($command)
    {
        //$command = 'screen -S bukkit -p 0 -X stuff "' . $command .'" '."`echo -ne '\015'`";
        $command = "screen -S bukkit -p 0 -X stuff '".$command."\n' ";
        exec($command);
    }
    
    //send a say command
    public function say()
    {
        //if no command passed via url
        if (!isset($_GET['command']))
        {
            $this->loadView('scripts/say_page');
        }
        
        else 
        {
            //what did they want to say?
            $say = $_GET['command'];

            $this->send('say '.$say);
        }
    }
    
    //restart the server
    public function restart()
    {
        $this->send('say ###Restart In 1 Minute###');
        sleep(50);
        $this->send('say ###Restart In 10 Seconds###');
        sleep(5);
        $this->send('say ###Restart In 5 Seconds###');
        $this->send('save-all');
        sleep(5);
        $this->send('stop');
        sleep(10);
        
        //load our online checker library
        $this->loadLibrary('server_conf');
        
        //make sure the server is offline
        $online = server_conf::checkOnline();
        $i=1;
        
        //while the server is online, we sleep 10 seconds, unless it's been 100 seconds,
        //in which case we FORCE it to close
        while ($online==true)
        {
            $i++;
            sleep(10);
            //if not died in 100 seconds, we FORCE it to close
            if ($i <= 10)
            {
                exec ('pkill java'); //force all java's to close
                break;
            }
        }
        
        if (file_exists(APPLICATION_DIR.'mcscripts'.DS.'startup.sh'))
        {
        //exec the last startup we used        
        exec(APPLICATION_DIR.'mcscripts'.DS.'startup.sh');
        //redirect to main page
        pf_core::redirectUrl(pf_config::get('main_page'));
        }
        else $this->loadView ('scripts/start_page');
    }

    //stop the server
    public function stop()
    {
        $this->send('say ###SERVER SHUTDOWN In 1 Minute###');
        sleep(50);
        $this->send('say ###SERVER SHUTDOWN In 10 Seconds###');
        sleep(5);
        $this->send('say ###SERVER SHUTDOWN In 5 Seconds###');
        $this->send('save-all');
        sleep(5);
        $this->send('stop');
        sleep(10);
        
        //load our online checker library
        $this->loadLibrary('server_conf');
        
        //make sure the server is offline
        $online = server_conf::checkOnline();
        $i=1;
        
        //while the server is online, we sleep 10 seconds, unless it's been 100 seconds,
        //in which case we FORCE it to close
        while ($online==true)
        {
            $i++;
            sleep(10);
            //if not died in 100 seconds, we FORCE it to close
            if ($i <= 10)
            {
                exec ('pkill java'); //force all java's to close
                break;
            }
        }
    }
    
    //start the server
    public function startup()
    {
        $this->checkLogin();
        
        //load the server config library
        $this->loadLibrary('server_conf');
        
        //get settings
        $settings = new pf_json();
        $settings->readJsonFile(pf_config::get('Json_Settings'));
        $data = $settings->get('startup_script');
        
        //check if server is online
        if (server_conf::checkOnline())
        {
            //we are online
            pf_events::dispayFatal('Server Already Running, Perhaps you should stop it first?');
        }
        
        if ($_SERVER['REQUEST_METHOD']=='POST')
        {
            $startup = array(
                'Maxram'  =>  $_POST['maxram'],
            );
            
            //save this to the settings file for later
            $settings->set('startup_script', $startup);
            
            //write the settings file
            $settings->writeJsonFile(pf_config::get('Json_Settings'));
            
            //get the bukkit_dir
            $dir = $settings->get('bukkit_dir');
            
            //write the script to the mcscripts folder
            $file = 'cd '.$dir."\n";
            $file .= 'screen -dmS bukkit java -Xincgc -Xmx'.$_POST['maxram'].'M -jar craftbukkit.jar'."\n";
            
            //if we can't write, we throw an error
            if (! file_put_contents(APPLICATION_DIR.'mcscripts'.DS.'startup.sh', $file))
            {
                pf_events::dispayFatal('Unable to save script! Is app/mcscripts writable?');
            }
            
            $chmod = 'chmod +x ' . APPLICATION_DIR.'mcscripts'.DS.'startup.sh';
            exec($chmod);
            
            exec(APPLICATION_DIR.'mcscripts'.DS.'startup.sh');
            
            pf_core::redirectUrl(pf_config::get('main_page'));
        }
        
        else 
        {
            $this->loadView('scripts/start_page',$data);
        }
        
    }

}
?>
