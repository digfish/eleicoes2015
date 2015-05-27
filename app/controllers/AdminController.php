<?php

class AdminController extends \BaseController {

    protected $layout = 'admin/master';

    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }
    
    
    /**
     * Display a listing of the resource.
     * GET /admin
     *
     * @return Response
     */
    public function index() {
        
        return View::make('admin/master');
        //
    }

    public function tags() {
        
        return View::make('admin/tags');
        //
    }
    
    public function noticias() {
        return View::make('admin/noticias');
    }

    public function console() {
        $logfile = base_path() . '/logs/cron.log';
         $log = (file_get_contents($logfile));
         
         $last_modification = filemtime($logfile);

        return View::make('admin/console')
                ->with('log',$log)
                ->with('last_modification', date('Y-m-d H:i:s', $last_modification));
    }
    
    public function executeCron() {
        $logfile = base_path() . '/logs/cron.log';
        chdir(base_path());
        ob_start();
        system("php artisan cron:run");
        $output = ob_get_clean();
        File::put($logfile,$output);
        $last_modification = filemtime($logfile);
        return Response::json( array('output' => $output, 'last_modification' =>  date('Y-m-d H:i:s', $last_modification)));
    }
    

}
