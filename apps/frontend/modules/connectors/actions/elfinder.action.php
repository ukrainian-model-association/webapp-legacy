<?php

include_once __DIR__.'/elFinder.class.php';

class connectors_elfinder_action extends frontend_controller
{

    public function execute()
    {
        $opts = [
            'root'        => sprintf('%s/data/files', conf::get('project_root')),// path to root directory
            'tmbDir'      => 'tmp',
            'URL'         => '/uploads/',// root directory URL
            'rootAlias'   => 'Home',// display this instead of root directory name
            'uploadAllow' => ['all'],
            'uploadDeny'  => ['application', 'text'],
            'uploadOrder' => 'deny,allow',
        ];

        $fm = new elFinder($opts);
        $fm->run();
    }
}
