<?php

/**
 * Shadpine accordion — class tokens for Blade wrappers that compose `primitive/*` (behavior in Blade + Alpine).
 */
return [
    'root' => 'flex w-full flex-col',
    'trigger' => 'group/accordion-trigger relative flex flex-1 items-start justify-between rounded-lg border border-transparent py-2.5 text-left text-sm font-medium transition-all outline-none hover:underline focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50 focus-visible:after:border-ring disabled:pointer-events-none disabled:opacity-50 **:data-[slot=accordion-trigger-icon]:ml-auto **:data-[slot=accordion-trigger-icon]:size-4 **:data-[slot=accordion-trigger-icon]:text-muted-foreground',
    'content' => 'grid overflow-hidden text-sm transition-[grid-template-rows] duration-200 ease-out motion-reduce:duration-0 data-[state=closed]:grid-rows-[0fr] data-[state=open]:grid-rows-[1fr]',
    'item' => 'not-last:border-b',
];
