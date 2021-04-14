<?php

class load
{
    const FILE_DOES_NOT_EXISTS = 'file_does_not_exists';
    const MESSAGES_BOX         = [
        self::FILE_DOES_NOT_EXISTS => 'File does not exists: %s (%s)',
    ];

    public static function app($name)
    {
        $path = sprintf(
            '%s/apps/%s/%s.php',
            conf::get('project_root'),
            context::get_app(),
            $name
        );

        if (!is_file($path)) {
            throw new RuntimeException(sprintf(self::MESSAGES_BOX[self::FILE_DOES_NOT_EXISTS], $name, $path));
        }

        include_once $path;
    }

    public static function task($task_name)
    {
        try {
            $path = getenv('FRAMEWORK_PATH').'/library/shell/tasks/'.$task_name.'.php';

            if (!is_file($path)) {
                $path = conf::get('project_root').DIRECTORY_SEPARATOR.'tasks/tasks/'.$task_name.'.php';
            }

            if (!is_file($path)) {
                throw new Exception("Task \"{$task_name}\" is unknown ({$path})");
            }

            include_once $path;
        } catch (Exception $e) {
            debug_print_backtrace();
        }
    }

    public static function model($name)
    {
        try {
            self::lib('models/'.$name.'.peer');
        } catch (Exception $e) {
            debug_print_backtrace();
        }
    }

    public static function lib($name)
    {
        require_once conf::get('project_root').DIRECTORY_SEPARATOR.'lib/'.$name.'.php';
    }

    public static function view_helper($name, $system = false)
    {
        if ($system) {
            self::system('helpers/view/'.$name.'.helper');
        } else {
            self::lib('helpers/view/'.$name.'.helper');
        }
    }

    public static function system($name)
    {
        $path = getenv('FRAMEWORK_PATH').DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.$name.'.php';
        require_once $path;
    }

    public static function action_helper($name, $system = true)
    {
        if ($system) {
            self::system('helpers/action/'.$name.'.helper');
        } else {
            self::lib('helpers/action/'.$name.'.helper');
        }
    }

    public static function form($name)
    {
        self::lib('forms/'.$name.'.form');
    }
}