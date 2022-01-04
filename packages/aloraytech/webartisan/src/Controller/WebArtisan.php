<?php

namespace Aloraytech\Webartisan\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class WebArtisan
{

    private array $availableClearCommand = ['cache','route','config','view'];
    private array $availableMakeCommand = ['controller','model','factory','seeder','migration','provider','notification'];
    private array $availableComposerCommand = ['install','update','install_no_dev','update_no_dev','dump_autoload'];

    public function __construct()
    {
        if(!Auth::check())
        {
            redirect('/');
        }
    }


    /**
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        return '<h1>Web Artisan Working Properly </h1>
                <br><h3> This Library Help you run cli commands in web route
                <br> Example: <i>php artisan make:controller ControllerName</i>
                <br> Will Be : <i>domain.com/web-artisan/make/controller/ControllerName</i> </h3>';

    }

    /**
     * @param Request $request
     * @param string $command
     * @return string|null
     */
    public function clear(Request $request,string $command)
    {
        if(in_array($command,$this->availableClearCommand))
        {
            $commandText = strtolower($command).':clear';
            $execute = Artisan::call($commandText);
            return '<h3> You have successfully execute '.$commandText.'</h3>';
        }else{
            if($command === 'all')
            {
                $commandText = '';
               foreach ($this->availableClearCommand as $item)
               {
                   $commandText = strtolower($item).':clear';
                   $exitCode = Artisan::call($commandText);
                   echo '<h3>You have successfully execute <u>'.$commandText.'</u></h3>';
               }
            }
        }
        return null;
    }


    /**
     * @param Request $request
     * @param string $command
     * @param string $subject
     * @return string|null
     */
    public function make(Request $request,string $command,string $subject)
    {

        if(in_array($command,$this->availableMakeCommand))
        {
            $commandText = 'make:'.strtolower($command).' '.$subject;
            $exitCode = Artisan::call($commandText);
            return '<h3> You have successfully execute '.$commandText.'</h3>';
        }else{
            if($command === 'all')
            {
                $commandText = '';
                foreach ($this->availableMakeCommand as $item)
                {
                    $commandText = 'make:'.strtolower($item).' '.$subject;
                    $exitCode = Artisan::call($commandText);
                    echo '<h3>You have successfully execute <u>'.$commandText.'</u></h3>';
                }
            }
        }
        return null;
    }


    public function optimize()
    {
        $exitCode = Artisan::call('optimize');
        return '<h3>You have successfully Optimize Your System</h3>';
    }



    public function composer(string $command)
    {

        if(in_array($command,$this->availableComposerCommand))
        {
//            chdir(base_path());
//            shell_exec('composer '.$command);
            return '<h3> Composer Functionality will Be updated soon</h3>';
        }else{
            return redirect()->route('web.artisan.help');
        }



    }




















}
