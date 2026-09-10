<?php

declare(strict_types=1);

const EXPECTED_COMPOSER_WARNING = '- The package "johnnickell/fight-common" is pointing to a commit-ref, this is bad practice and can cause unforeseen issues.';

function composerValidationIsAccepted(string $output, int $exitCode): bool
{
    if ($exitCode !== 0) {
        return false;
    }

    preg_match_all('/^- .+$/m', $output, $matches);

    return $matches[0] === [EXPECTED_COMPOSER_WARNING];
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') !== __FILE__) {
    return;
}

$process = proc_open(
    ['composer', 'validate'],
    [1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
    $pipes,
);

if (! is_resource($process)) {
    fwrite(STDERR, "Unable to execute Composer validation.\n");
    exit(1);
}

$output = stream_get_contents($pipes[1]).stream_get_contents($pipes[2]);
fclose($pipes[1]);
fclose($pipes[2]);
$exitCode = proc_close($process);

fwrite(STDOUT, $output);

if (! composerValidationIsAccepted($output, $exitCode)) {
    fwrite(STDERR, "Composer validation did not produce exactly the temporary Fight Common commit-reference warning.\n");
    exit(1);
}
