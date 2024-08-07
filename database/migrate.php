<?php



require_once __DIR__ . '/Database.php';

class Migrate
{
    public static function run()
    {
        $db = new Database();

        $migrations = glob(__DIR__ . '/migrations/*.php');
        foreach ($migrations as $migration) {
            require_once $migration;
        }
    }
}

Migrate::run();
?>
