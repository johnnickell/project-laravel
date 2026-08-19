<?php

declare(strict_types=1);

$root = dirname(__DIR__);

foreach ([
    'AGENTS.md',
    'CONTEXT.md',
    'LICENSE',
    'SECURITY.md',
    'CONTRIBUTING.md',
    'planning/README.md',
    'planning/ROADMAP.md',
    'planning/specs/00001-PRD.md',
    'planning/tickets/00001-TICKET.md',
    'planning/tickets/BOARD.md',
    'planning/agents/domain.md',
    'planning/agents/issue-tracker.md',
    'planning/agents/triage-labels.md',
] as $path) {
    if (! is_file($root.'/'.$path)) {
        throw new RuntimeException(sprintf('Missing repository authority file: %s', $path));
    }
}

foreach (['PRD-00001', 'T-00001'] as $identifier) {
    if (! str_contains((string) file_get_contents($root.'/planning/specs/00001-PRD.md'), $identifier)
        && ! str_contains((string) file_get_contents($root.'/planning/tickets/00001-TICKET.md'), $identifier)) {
        throw new RuntimeException(sprintf('Missing local planning identifier: %s', $identifier));
    }
}

fwrite(STDOUT, "Planning authority check passed.\n");
