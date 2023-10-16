<?php

$repositoryPath = 'C:\nginx\html\Trabalho_da_SEPE';

$command = "cd $repositoryPath && git pull";
$output = shell_exec($command);

echo "<pre>$output</pre>";
?>