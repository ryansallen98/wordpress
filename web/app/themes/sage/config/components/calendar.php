<?php

/**
 * Shadpine calendar — class strings aligned with shadcn/ui new-york-v4 calendar (react-day-picker + cn).
 *
 * @see https://ui.shadcn.com/docs/components/radix/calendar
 * @see https://ui.shadcn.com/r/styles/new-york-v4/calendar.json
 */
return [
    // Match shadcn / RDP: theme-backed cell size + radius (see ui.shadcn.com calendar — flex weeks, not grid).
    'root' => 'group/calendar text-sm w-fit bg-background p-2 [--cell-size:theme(spacing.7)] [--cell-radius:var(--radius-md)] [[data-slot=card-content]_&]:bg-transparent [[data-slot=popover-content]_&]:bg-transparent',
    'months' => 'relative flex w-full min-w-0 flex-col gap-4 md:flex-row',
    'month' => 'relative flex w-full min-w-0 flex-1 flex-col gap-4 md:min-w-[calc(7*var(--cell-size))]',
    'month_subcaption' => 'flex h-(--cell-size) w-full items-center justify-center px-1 text-sm font-medium sm:px-(--cell-size)',
    'month_toolbar' => 'relative isolate w-full',
    'nav' => 'pointer-events-none absolute inset-x-0 top-0 z-10 flex h-(--cell-size) w-full items-center justify-between gap-1',
    'month_caption' => 'flex h-(--cell-size) w-full items-center justify-center gap-1.5 px-1 sm:gap-1.5 sm:px-(--cell-size)',
    'caption_select_month_wrapper' => 'group/native-select relative inline-flex h-7 w-auto min-w-[2.75rem] max-w-[4rem] shrink-0 items-center shadow-none has-[select:disabled]:opacity-50 sm:max-w-[4.25rem]',
    'caption_select_year_wrapper' => 'group/native-select relative inline-flex h-7 w-auto max-w-[3.25rem] shrink-0 items-center shadow-none has-[select:disabled]:opacity-50 sm:max-w-[3.5rem]',
    'caption_select' => 'h-7 w-full min-w-0 cursor-pointer appearance-none border-0 bg-transparent py-0 pr-5 pl-0 text-center text-sm font-medium text-foreground shadow-none outline-none transition-colors select-none focus-visible:ring-2 focus-visible:ring-ring/40 focus-visible:ring-offset-0 focus-visible:ring-offset-background disabled:cursor-not-allowed aria-invalid:ring-0 dark:bg-transparent',
    'caption_select_icon' => 'pointer-events-none absolute top-1/2 end-0.5 size-3.5 -translate-y-1/2 text-muted-foreground select-none rtl:**:[&>svg]:rotate-180',
    'caption_label' => 'text-sm font-medium select-none',
    'button_nav' => 'pointer-events-auto size-(--cell-size) p-0 select-none aria-disabled:opacity-50',
    'grid' => 'w-full min-w-0',
    'weekdays_row' => 'flex w-full min-w-0',
    'weekday' => 'flex-1 rounded-(--cell-radius) text-center text-[0.8rem] font-normal text-muted-foreground select-none',
    'week_row' => 'mt-2 flex w-full min-w-0',
    'table' => 'w-full border-collapse',
    'day_td' => 'group/day relative aspect-square h-full min-h-0 w-full min-w-0 flex-1 p-0 text-center select-none [&:last-child[data-selected=true]_button]:rounded-r-(--cell-radius) [&:first-child[data-selected=true]_button]:rounded-l-(--cell-radius)',
    'range_start' => 'rounded-l-(--cell-radius) bg-accent',
    'range_middle' => 'rounded-none',
    'range_end' => 'rounded-r-(--cell-radius) bg-accent',
    'today' => 'rounded-(--cell-radius) bg-accent text-accent-foreground data-[selected=true]:rounded-none',
    'outside' => 'text-muted-foreground aria-selected:text-muted-foreground',
    'disabled' => 'text-muted-foreground opacity-50',
    'day_button' => 'm-0 cursor-pointer border-0 bg-transparent p-0 relative isolate z-10 inline-flex aspect-square size-auto w-full min-w-(--cell-size) flex-col items-center justify-center gap-1 rounded-(--cell-radius) font-normal leading-none shadow-none transition-colors outline-none hover:bg-accent hover:text-accent-foreground focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50 disabled:hover:bg-transparent dark:hover:bg-accent/50 group-data-[focused=true]/day:relative group-data-[focused=true]/day:z-10 group-data-[focused=true]/day:border-ring group-data-[focused=true]/day:ring-[3px] group-data-[focused=true]/day:ring-ring/50 data-[range-end=true]:rounded-(--cell-radius) data-[range-end=true]:rounded-r-(--cell-radius) data-[range-end=true]:bg-primary data-[range-end=true]:text-primary-foreground data-[range-middle=true]:rounded-none data-[range-middle=true]:bg-accent data-[range-middle=true]:text-accent-foreground data-[range-start=true]:rounded-(--cell-radius) data-[range-start=true]:rounded-l-(--cell-radius) data-[range-start=true]:bg-primary data-[range-start=true]:text-primary-foreground data-[selected-single=true]:bg-primary data-[selected-single=true]:text-primary-foreground hover:data-[range-end=true]:bg-primary/90 hover:data-[range-end=true]:text-primary-foreground hover:data-[range-middle=true]:bg-accent/80 hover:data-[range-middle=true]:text-accent-foreground hover:data-[range-start=true]:bg-primary/90 hover:data-[range-start=true]:text-primary-foreground hover:data-[selected-single=true]:bg-primary/90 hover:data-[selected-single=true]:text-primary-foreground dark:hover:data-[range-end=true]:bg-primary/90 dark:hover:data-[range-end=true]:text-primary-foreground dark:hover:data-[range-start=true]:bg-primary/90 dark:hover:data-[range-start=true]:text-primary-foreground dark:hover:data-[selected-single=true]:bg-primary/90 dark:hover:data-[selected-single=true]:text-primary-foreground [&>span]:text-xs [&>span]:opacity-70',
];
