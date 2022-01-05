<?php


class Installer
{

    private $autoloader = '';
    private $rootPath = '';


    public function __construct()
    {
        $this->autoloader = dirname(__DIR__).'/vendor/autoload.php';
        $this->rootPath = dirname(__DIR__).DIRECTORY_SEPARATOR;
    }


    public function install()
    {
        $this->setMessage('Preparing Installation');
        if($this->hasExtension())
        {
            chdir($this->rootPath);
            $this->setMessage('Installation Started');
            if(php_sapi_name() === 'cli')
            {
                $argc = shell_exec('composer install');
                $this->setMessage(['Installation On Process...'],['Please Do not close this window']);
            }else{
                $this->setMessage(['Installation On Process...'],['Please Do not close this window']);
                $argc = shell_exec('composer install');
                sleep(30);
                $this->setMessage($argc);
                $argc = shell_exec('php artisan migrate:fresh --seed');

            }
            sleep(30);
            $this->setMessage($argc);
        }

        if($this->hasAutoload())
        {
            $this->setMessage('Installation Complete');
            if(PHP_SAPI === 'cli')
            {
                $this->setMessage('Please Read Docs For Know All Latest Changes Of This Framework..');
                $this->setMessage(['You can now start your application by hitting '],['php artisan serve']);
            }else{
                echo '<a style="
                        background-color: #4CAF50;
                        border: none;
                        color: white;
                        padding: 15px 32px;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
                        font-size: 16px;"
                     href="/">Finish</a>';
                die();
            }


        }else{
            $this->setMessage('Please wait for 120 seconds and reload this page');
        }

    }

    public function hasAutoload()
    {
        return file_exists($this->autoloader);
    }



    public function setMessage($message,$error=false)
    {
        $color = '#4CAF50';
        if($error)
        {
            $color = 'red';
        }

        if(is_string($message))
        {
            if(PHP_SAPI === 'cli')
            {
                echo "\e[92m $message \n\e[0m";
            }else{
                ob_start();
                echo "<h3 style='color: ".$color."'>".$message ."</h3>";
                ob_end_flush();
            }

        }else{
            foreach ($message as $msg)
            {
                if(PHP_SAPI === 'cli')
                {
                    echo "\e[92m $message \n\e[0m";
                }else{
                    ob_start();
                    echo "<h3 style='color: ".$color."'>".$msg ."</h3>";
                    ob_end_flush();
                }
            }
        }

        if($error){die();}
    }

    /**
     * @return bool
     */
    private function hasExtension() :bool
    {
        if (!version_compare(PHP_VERSION, '7.4.0', '>=')) {
            $this->setMessage('I am at least PHP version 7.4.0, my version: ' . PHP_VERSION . "\n");
            $this->setMessage('Installation Process Stopped!',true);
        }
        if (!extension_loaded('bcmath')) {
            $this->setMessage('BCMath extension not found');
            $this->setMessage('Installation Process Stopped!',true);
        }
        if (!extension_loaded('fileinfo')) {
            $this->setMessage('FILE INFO extension not found');
            $this->setMessage('Installation Process Stopped!',true);
        }
        if (!extension_loaded('openssl')) {
            $this->setMessage('OpenSSL extension not found');
            $this->setMessage('Installation Process Stopped!',true);
        }
        if (!extension_loaded('pdo')) {
            $this->setMessage('PDO extension not found');
            $this->setMessage('Installation Process Stopped!',true);
        }
        return true;
    }


}




// To Do
$installer = new Installer();


if($installer->hasAutoload() !== true)
{
    $installer->install();
}

