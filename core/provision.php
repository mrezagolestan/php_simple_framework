<?php
require 'bootstrap.php';

use App\Provision;

$app->bindFromKernelConfig('http');


try {
    $db = app()->resolve(\Core\Utils\Database\DBInterface::class);

    $migrations = file_get_contents(APP_DIR . 'migrations.sql');
    $db->execute($migrations, []);
    print("\033[32m********* Migration Script performed Successfully. *********\033[0m\r\n");

    app()->resolve(Provision::class)->run();
    print("\033[32m********* Provisioning Script performed Successfully. *********\033[0m\r\n");
} catch (PDOException $e) {
    print("\033[31m" . $e->getMessage() . "\033[0m\r\n");
}
?>