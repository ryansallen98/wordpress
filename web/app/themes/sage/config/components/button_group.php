<?php

/**
 * Shadpine button group — parity with shadcn/ui button-group CVA (registry new-york-v4).
 *
 * @see https://ui.shadcn.com/docs/components/radix/button-group
 */
return [
    'group' => [
        // Mirrors registry/new-york-v4/ui/button-group.tsx — buttonGroupVariants base + orientation.
        'base' => 'flex w-fit items-stretch has-[>[data-slot=button-group]]:gap-2 [&>*]:focus-visible:relative [&>*]:focus-visible:z-10 has-[select[aria-hidden=true]:last-child]:[&>[data-slot=select-trigger]:last-of-type]:rounded-r-md [&>[data-slot=select-trigger]:not([class*=\'w-\'])]:w-fit [&>input]:flex-1',
        'orientation' => [
            'horizontal' => '[&>*:not(:first-child)]:rounded-l-none [&>*:not(:first-child)]:border-l-0 [&>*:not(:last-child)]:rounded-r-none',
            'vertical' => 'flex-col [&>*:not(:first-child)]:rounded-t-none [&>*:not(:first-child)]:border-t-0 [&>*:not(:last-child)]:rounded-b-none',
        ],
    ],
    'text' => [
        // ButtonGroupText — same cn() string as upstream (no justify-center / muted strip).
        'base' => 'flex items-center gap-2 rounded-md border bg-muted px-4 text-sm font-medium shadow-xs [&_svg]:pointer-events-none [&_svg:not([class*=\'size-\'])]:size-4',
    ],
    'separator' => [
        // Separator primitive + ButtonGroupSeparator overlay (registry separator.tsx + button-group.tsx).
        'radix' => 'shrink-0 bg-border data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full data-[orientation=vertical]:h-full data-[orientation=vertical]:w-px',
        'group' => 'relative !m-0 self-stretch bg-input data-[orientation=vertical]:h-auto',
    ],
];
