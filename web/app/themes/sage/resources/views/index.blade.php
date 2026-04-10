@extends('layouts.app')

@section('content')
@include('partials.page-header')

@if (!have_posts())
  <x-alert variant="destructive">
    <x-alert.title>
      {!! __('No results found', 'sage') !!}
    </x-alert.title>
    <x-alert.description>
      {!! __('No results were found for your search.', 'sage') !!}
    </x-alert.description>
    <x-alert.action>
      <x-button as="a" href="/" variant="outline">{!! __('Go Home', 'sage') !!}</x-button>
    </x-alert.action>
  </x-alert>

  {!! get_search_form(false) !!}
@endif

@while(have_posts())
  @php
    the_post();
  @endphp
  @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
@endwhile

{{--
  Shadpine UI — live kit on the home template.
  Keep this section in sync with docs/components/INDEX.md: every catalogued component
  should have a matching subsection below when you ship a new widget.
--}}
<section
  class="mt-16 space-y-16 border-t border-border pt-16 px-8"
  aria-labelledby="shadpine-ui-kit-heading"
>
  <header class="max-w-3xl space-y-2">
    <h2 id="shadpine-ui-kit-heading" class="text-2xl font-semibold tracking-tight text-foreground">
      {!! __('Shadpine UI kit', 'sage') !!}
    </h2>
    <p class="text-muted-foreground text-sm leading-relaxed">
      {!! __(
        'Reference examples for Blade components under resources/views/components/. Documentation lives in docs/components/ in the repository. When you add a component to the catalog (INDEX.md), add a subsection here with a short description and one or more examples.',
        'sage'
      ) !!}
    </p>
  </header>

  <div class="space-y-16">
    {{-- Accordion — docs/components/accordion.md --}}
    <div class="space-y-4">
      <div>
        <h3 class="text-lg font-medium text-foreground">{!! __('Accordion', 'sage') !!}</h3>
        <p class="text-muted-foreground mt-1 text-sm">{!! __('Disclosure groups (single or multiple open).', 'sage') !!}</p>
      </div>
      <div class="max-w-sm rounded-lg border border-border">
        <x-accordion type="single">
          <x-accordion.item class="border-b px-4 last:border-b-0">
            <x-accordion.trigger>
              {!! __('Section one', 'sage') !!}
            </x-accordion.trigger>
            <x-accordion.content>
              {!! __('Content for the first section.', 'sage') !!}
            </x-accordion.content>
          </x-accordion.item>
          <x-accordion.item class="border-b px-4 last:border-b-0">
            <x-accordion.trigger>
              {!! __('Section two', 'sage') !!}
            </x-accordion.trigger>
            <x-accordion.content>
              {!! __('Content for the second section.', 'sage') !!}
            </x-accordion.content>
          </x-accordion.item>
        </x-accordion>
      </div>
    </div>

    {{-- Alert — docs/components/alert.md --}}
    <div class="space-y-4">
      <div>
        <h3 class="text-lg font-medium text-foreground">{!! __('Alert', 'sage') !!}</h3>
        <p class="text-muted-foreground mt-1 text-sm">{!! __('Status messages with optional title, description, and action slot.', 'sage') !!}</p>
      </div>
      <div class="max-w-xl space-y-4">
        <x-alert>
          <x-alert.title>{!! __('Note', 'sage') !!}</x-alert.title>
          <x-alert.description>{!! __('Default alert for neutral information.', 'sage') !!}</x-alert.description>
        </x-alert>
        <x-alert variant="destructive">
          <x-alert.title>{!! __('Error', 'sage') !!}</x-alert.title>
          <x-alert.description>{!! __('Destructive variant for errors or irreversible outcomes.', 'sage') !!}</x-alert.description>
          <x-alert.action>
            <x-button type="button" variant="outline" size="sm">{!! __('Dismiss', 'sage') !!}</x-button>
          </x-alert.action>
        </x-alert>
      </div>
    </div>

    {{-- Alert dialog — docs/components/alert-dialog.md --}}
    <div class="space-y-4">
      <div>
        <h3 class="text-lg font-medium text-foreground">{!! __('Alert dialog', 'sage') !!}</h3>
        <p class="text-muted-foreground mt-1 text-sm">
          {!! __('Modal alert with trap, Escape to close, and action that can chain x-on:click before closeDialog().', 'sage') !!}
        </p>
      </div>
      <div>
        <x-alert-dialog>
          <x-alert-dialog.trigger as="x-button" variant="outline">
            {!! __('Open alert dialog', 'sage') !!}
          </x-alert-dialog.trigger>

          <x-alert-dialog.content size="sm">
            <x-alert-dialog.header>
              <x-alert-dialog.title>{!! __('Are you absolutely sure?', 'sage') !!}</x-alert-dialog.title>
              <x-alert-dialog.description>
                {!! __('This action cannot be undone. Demo only — no data is deleted.', 'sage') !!}
              </x-alert-dialog.description>
            </x-alert-dialog.header>
            <x-alert-dialog.footer>
              <x-alert-dialog.cancel>{!! __('Cancel', 'sage') !!}</x-alert-dialog.cancel>
              <x-alert-dialog.action variant="destructive" x-on:click="console.log('Alert dialog: Continue')">
                {!! __('Continue', 'sage') !!}
              </x-alert-dialog.action>
            </x-alert-dialog.footer>
          </x-alert-dialog.content>
        </x-alert-dialog>
      </div>
    </div>

    {{-- Aspect ratio — docs/components/aspect-ratio.md --}}
    <div class="space-y-4">
      <div>
        <h3 class="text-lg font-medium text-foreground">{!! __('Aspect ratio', 'sage') !!}</h3>
        <p class="text-muted-foreground mt-1 text-sm">
          {!! __('Fixed ratio box (e.g. video 16/9, square). Images use absolute positioning and object-cover.', 'sage') !!}
        </p>
        <p class="text-muted-foreground text-xs leading-relaxed">
          {!! __(
            'Sample photos are from Lorem Picsum (curated from Unsplash — free to use under the Unsplash License).',
            'sage'
          ) !!}
        </p>
      </div>
      <div class="flex max-w-2xl flex-wrap gap-8">
        <div class="w-full max-w-md">
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">16:9</p>
          <x-aspect-ratio ratio="video" class="rounded-lg border border-border">
            <img
              src="https://picsum.photos/id/28/960/540"
              alt="{{ esc_attr__('Coastal hills and water — demo stock photo.', 'sage') }}"
              class="absolute inset-0 size-full object-cover"
              loading="lazy"
              decoding="async"
              width="960"
              height="540"
            />
          </x-aspect-ratio>
        </div>
        <div class="w-44">
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">1:1</p>
          <x-aspect-ratio ratio="square" class="rounded-lg border border-border">
            <img
              src="https://picsum.photos/id/237/600/600"
              alt="{{ esc_attr__('Dog portrait — demo stock photo.', 'sage') }}"
              class="absolute inset-0 size-full object-cover"
              loading="lazy"
              decoding="async"
              width="600"
              height="600"
            />
          </x-aspect-ratio>
        </div>
      </div>
    </div>

    {{-- Badge — docs/components/badge.md --}}
    <div class="space-y-4">
      <div>
        <h3 class="text-lg font-medium text-foreground">{!! __('Badge', 'sage') !!}</h3>
        <p class="text-muted-foreground mt-1 text-sm">{!! __('Small labels; use as link or button when needed.', 'sage') !!}</p>
      </div>
      <div class="flex flex-wrap gap-2">
        <x-badge variant="default">{!! __('Default', 'sage') !!}</x-badge>
        <x-badge variant="secondary">{!! __('Secondary', 'sage') !!}</x-badge>
        <x-badge variant="destructive">{!! __('Destructive', 'sage') !!}</x-badge>
        <x-badge variant="outline">{!! __('Outline', 'sage') !!}</x-badge>
        <x-badge variant="ghost" as="a" href="#shadpine-ui-kit-heading">{!! __('Ghost link', 'sage') !!}</x-badge>
        <x-badge variant="link" as="a" href="#shadpine-ui-kit-heading">{!! __('Link', 'sage') !!}</x-badge>
      </div>
    </div>

    {{-- Skeleton — docs/components/skeleton.md --}}
    <div class="space-y-4">
      <div>
        <h3 class="text-lg font-medium text-foreground">{!! __('Skeleton', 'sage') !!}</h3>
        <p class="text-muted-foreground mt-1 text-sm">
          {!! __('Loading placeholders; size and shape with Tailwind utilities on class.', 'sage') !!}
        </p>
      </div>
      <div class="flex max-w-md flex-col gap-4">
        <x-skeleton class="h-4 w-full" />
        <div class="flex items-center gap-4">
          <x-skeleton class="size-12 shrink-0 rounded-full" />
          <div class="grow space-y-2">
            <x-skeleton class="h-4 w-full" />
            <x-skeleton class="h-4 w-3/4" />
          </div>
        </div>
      </div>
    </div>

    {{-- Breadcrumb — docs/components/breadcrumb.md --}}
    <div class="space-y-4">
      <div>
        <h3 class="text-lg font-medium text-foreground">{!! __('Breadcrumb', 'sage') !!}</h3>
        <p class="text-muted-foreground mt-1 text-sm">
          {!! __('Navigation trail: nav + ol + li; link, page, separator, optional ellipsis.', 'sage') !!}
        </p>
      </div>
      <div class="max-w-3xl space-y-8">
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('Basic', 'sage') !!}
          </p>
          <x-breadcrumb class="rounded-md border border-border bg-muted/30 px-3 py-2">
            <x-breadcrumb.item>
              <x-breadcrumb.link :href="home_url('/')">{!! __('Home', 'sage') !!}</x-breadcrumb.link>
            </x-breadcrumb.item>
            <x-breadcrumb.separator />
            <x-breadcrumb.item>
              <x-breadcrumb.link :href="home_url('/#shadpine-ui-kit-heading')">{!! __('Kit', 'sage') !!}</x-breadcrumb.link>
            </x-breadcrumb.item>
            <x-breadcrumb.separator />
            <x-breadcrumb.item>
              <x-breadcrumb.page>{!! __('Breadcrumb', 'sage') !!}</x-breadcrumb.page>
            </x-breadcrumb.item>
          </x-breadcrumb>
        </div>
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('Custom separator + ellipsis', 'sage') !!}
          </p>
          <x-breadcrumb class="rounded-md border border-border bg-muted/30 px-3 py-2">
            <x-breadcrumb.item>
              <x-breadcrumb.link :href="home_url('/')">{!! __('Home', 'sage') !!}</x-breadcrumb.link>
            </x-breadcrumb.item>
            <x-breadcrumb.separator>
              <x-lucide-minus class="size-3.5" aria-hidden="true" />
            </x-breadcrumb.separator>
            <x-breadcrumb.item>
              <x-breadcrumb.ellipsis />
            </x-breadcrumb.item>
            <x-breadcrumb.separator>
              <x-lucide-minus class="size-3.5" aria-hidden="true" />
            </x-breadcrumb.separator>
            <x-breadcrumb.item>
              <x-breadcrumb.link :href="home_url('/#shadpine-ui-kit-heading')">{!! __('Components', 'sage') !!}</x-breadcrumb.link>
            </x-breadcrumb.item>
            <x-breadcrumb.separator>
              <x-lucide-minus class="size-3.5" aria-hidden="true" />
            </x-breadcrumb.separator>
            <x-breadcrumb.item>
              <x-breadcrumb.page>{!! __('Current', 'sage') !!}</x-breadcrumb.page>
            </x-breadcrumb.item>
          </x-breadcrumb>
        </div>
      </div>
    </div>

    {{-- Button — docs/components/button.md --}}
    <div class="space-y-4">
      <div>
        <h3 class="text-lg font-medium text-foreground">{!! __('Button', 'sage') !!}</h3>
        <p class="text-muted-foreground mt-1 text-sm">
          {!! __('Variants and sizes from config/components/button.php. Icons use mallardduck/blade-lucide-icons (x-lucide-*).', 'sage') !!}
        </p>
      </div>
      <div class="flex max-w-3xl flex-col gap-6">
        <div class="flex flex-wrap gap-2">
          <x-button type="button" variant="default">{!! __('Default', 'sage') !!}</x-button>
          <x-button type="button" variant="secondary">{!! __('Secondary', 'sage') !!}</x-button>
          <x-button type="button" variant="outline">{!! __('Outline', 'sage') !!}</x-button>
          <x-button type="button" variant="ghost">{!! __('Ghost', 'sage') !!}</x-button>
          <x-button type="button" variant="destructive">{!! __('Destructive', 'sage') !!}</x-button>
          <x-button type="button" variant="link">{!! __('Link', 'sage') !!}</x-button>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <x-button type="button" size="xs">{!! __('XS', 'sage') !!}</x-button>
          <x-button type="button" size="sm">{!! __('SM', 'sage') !!}</x-button>
          <x-button type="button" size="default">{!! __('Default', 'sage') !!}</x-button>
          <x-button type="button" size="lg">{!! __('LG', 'sage') !!}</x-button>
        </div>
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('With Lucide icons (label + icon)', 'sage') !!}
          </p>
          <div class="flex flex-wrap items-center gap-2">
            <x-button type="button" variant="default">
              <x-lucide-plus class="size-4 shrink-0" aria-hidden="true" />
              {!! __('Add item', 'sage') !!}
            </x-button>
            <x-button type="button" variant="outline">
              <x-lucide-download class="size-4 shrink-0" aria-hidden="true" />
              {!! __('Download', 'sage') !!}
            </x-button>
            <x-button type="button" variant="secondary">
              <x-lucide-heart class="size-4 shrink-0" aria-hidden="true" />
              {!! __('Save', 'sage') !!}
            </x-button>
          </div>
        </div>
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('Icon-only (x-button.icon)', 'sage') !!}
          </p>
          <div class="flex flex-wrap items-center gap-2">
            <x-button as="a" href="#shadpine-ui-kit-heading" variant="outline">{!! __('Anchor as button', 'sage') !!}</x-button>
            <x-button.icon type="button" variant="outline" size="sm" aria-label="{{ esc_attr__('Open menu', 'sage') }}">
              <x-lucide-menu class="size-4" aria-hidden="true" />
            </x-button.icon>
            <x-button.icon type="button" variant="outline" size="sm" aria-label="{{ esc_attr__('Settings', 'sage') }}">
              <x-lucide-settings class="size-4" aria-hidden="true" />
            </x-button.icon>
            <x-button.icon type="button" variant="destructive" size="sm" aria-label="{{ esc_attr__('Delete', 'sage') }}">
              <x-lucide-trash-2 class="size-4" aria-hidden="true" />
            </x-button.icon>
            <x-button.icon type="button" variant="ghost" size="sm" aria-label="{{ esc_attr__('Expand', 'sage') }}">
              <x-lucide-chevron-down class="size-4" aria-hidden="true" />
            </x-button.icon>
          </div>
        </div>
      </div>
    </div>

    {{-- Button group — docs/components/button-group.md --}}
    <div class="space-y-4">
      <div>
        <h3 class="text-lg font-medium text-foreground">{!! __('Button group', 'sage') !!}</h3>
        <p class="text-muted-foreground mt-1 text-sm">
          {!! __('Groups related actions (role="group"); merges borders between outline buttons. Nested groups get gap.', 'sage') !!}
        </p>
      </div>
      <div class="flex max-w-3xl flex-col gap-8">
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('Outline row', 'sage') !!}
          </p>
          <x-button-group aria-label="{{ esc_attr__('Demo message actions', 'sage') }}">
            <x-button type="button" variant="outline">{!! __('Archive', 'sage') !!}</x-button>
            <x-button type="button" variant="outline">{!! __('Report', 'sage') !!}</x-button>
          </x-button-group>
        </div>
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('Secondary + separator', 'sage') !!}
          </p>
          <x-button-group aria-label="{{ esc_attr__('Demo edit actions', 'sage') }}">
            <x-button type="button" variant="secondary" size="sm">{!! __('Copy', 'sage') !!}</x-button>
            <x-button-group.separator />
            <x-button type="button" variant="secondary" size="sm">{!! __('Paste', 'sage') !!}</x-button>
          </x-button-group>
        </div>
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('Vertical icons', 'sage') !!}
          </p>
          <x-button-group orientation="vertical" class="h-fit" aria-label="{{ esc_attr__('Demo zoom controls', 'sage') }}">
            <x-button.icon type="button" variant="outline" aria-label="{{ esc_attr__('Zoom in', 'sage') }}">
              <x-lucide-plus class="size-4" aria-hidden="true" />
            </x-button.icon>
            <x-button.icon type="button" variant="outline" aria-label="{{ esc_attr__('Zoom out', 'sage') }}">
              <x-lucide-minus class="size-4" aria-hidden="true" />
            </x-button.icon>
          </x-button-group>
        </div>
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('Label text + buttons', 'sage') !!}
          </p>
          <x-button-group aria-label="{{ esc_attr__('Demo pagination', 'sage') }}">
            <x-button-group.text>{!! __('Page', 'sage') !!}</x-button-group.text>
            <x-button type="button" variant="outline" size="sm">{!! __('1', 'sage') !!}</x-button>
            <x-button type="button" variant="outline" size="sm">{!! __('2', 'sage') !!}</x-button>
            <x-button type="button" variant="outline" size="sm">{!! __('3', 'sage') !!}</x-button>
          </x-button-group>
        </div>
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('Nested groups', 'sage') !!}
          </p>
          <x-button-group aria-label="{{ esc_attr__('Demo nested toolbars', 'sage') }}">
            <x-button-group>
              <x-button.icon type="button" variant="outline" aria-label="{{ esc_attr__('Back', 'sage') }}">
                <x-lucide-arrow-left class="size-4" aria-hidden="true" />
              </x-button.icon>
            </x-button-group>
            <x-button-group>
              <x-button type="button" variant="outline">{!! __('Archive', 'sage') !!}</x-button>
              <x-button type="button" variant="outline">{!! __('Report', 'sage') !!}</x-button>
            </x-button-group>
          </x-button-group>
        </div>
      </div>
    </div>

    {{-- Native select — docs/components/native-select.md --}}
    <div class="space-y-4">
      <div>
        <h3 class="text-lg font-medium text-foreground">{!! __('Native select', 'sage') !!}</h3>
        <p class="text-muted-foreground mt-1 text-sm">
          {{ __(
            'Native HTML select with shadcn-style shell; forward name, id, aria-*, disabled, and invalid to the control. Option dropdowns use Canvas system colors for contrast.',
            'sage'
          ) }}
        </p>
      </div>
      <div class="flex max-w-3xl flex-col gap-8">
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('Basic', 'sage') !!}
          </p>
          <x-native-select
            id="shadpine-kit-native-select-demo"
            class="max-w-xs"
            aria-label="{{ esc_attr__('Demo status', 'sage') }}"
          >
            <x-native-select.option value="">{{ __('Select status', 'sage') }}</x-native-select.option>
            <x-native-select.option value="todo">{{ __('Todo', 'sage') }}</x-native-select.option>
            <x-native-select.option value="in-progress">{{ __('In progress', 'sage') }}</x-native-select.option>
            <x-native-select.option value="done">{{ __('Done', 'sage') }}</x-native-select.option>
          </x-native-select>
        </div>
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('Small + grouped', 'sage') !!}
          </p>
          <x-native-select
            size="sm"
            class="max-w-xs"
            aria-label="{{ esc_attr__('Demo department', 'sage') }}"
          >
            <x-native-select.option value="">{{ __('Select department', 'sage') }}</x-native-select.option>
            <x-native-select.group label="{{ __('Engineering', 'sage') }}">
              <x-native-select.option value="frontend">{{ __('Frontend', 'sage') }}</x-native-select.option>
              <x-native-select.option value="backend">{{ __('Backend', 'sage') }}</x-native-select.option>
            </x-native-select.group>
            <x-native-select.group label="{{ __('Sales', 'sage') }}">
              <x-native-select.option value="rep">{{ __('Sales rep', 'sage') }}</x-native-select.option>
              <x-native-select.option value="manager">{{ __('Account manager', 'sage') }}</x-native-select.option>
            </x-native-select.group>
          </x-native-select>
        </div>
        <div>
          <p class="text-muted-foreground mb-2 text-xs font-medium uppercase tracking-wide">
            {!! __('Invalid state', 'sage') !!}
          </p>
          <x-native-select
            class="max-w-xs"
            aria-label="{{ esc_attr__('Demo invalid select', 'sage') }}"
            aria-invalid="true"
          >
            <x-native-select.option value="">{{ __('Error state', 'sage') }}</x-native-select.option>
            <x-native-select.option value="a">{{ __('Option A', 'sage') }}</x-native-select.option>
            <x-native-select.option value="b">{{ __('Option B', 'sage') }}</x-native-select.option>
          </x-native-select>
        </div>
      </div>
    </div>

    {{-- Calendar — docs/components/calendar.md --}}
    <div class="space-y-4">
      <div>
        <h3 class="text-lg font-medium text-foreground">{!! __('Calendar', 'sage') !!}</h3>
        <p class="text-muted-foreground mt-1 text-sm">
          {!! __(
            'Month grid powered by date-fns and Alpine; styling follows shadcn/ui Calendar (React DayPicker). Props: number-of-months, caption-layout (month/year dropdown for single month only; label for multi-month), time-zone (IANA today), disabled ISO list, modifiers + modifiers-class-names. Listen for calendar-select / calendar-select-range on the host.',
            'sage'
          ) !!}
        </p>
      </div>
      @php
        $kitSingleIso = \Illuminate\Support\Carbon::today()->toDateString();
        $kitDaysSuffix = ' ' . __('days', 'sage');
        $kitBooked = [
            \Illuminate\Support\Carbon::today()->copy()->addDays(5)->toDateString(),
            \Illuminate\Support\Carbon::today()->copy()->addDays(6)->toDateString(),
            \Illuminate\Support\Carbon::today()->copy()->addDays(12)->toDateString(),
        ];
      @endphp
      <div class="grid w-full max-w-5xl grid-cols-1 gap-10 lg:grid-cols-2">
        <div
          class="min-w-0 space-y-2"
          x-data="{
            iso: @js($kitSingleIso),
            d(iso) {
              if (!iso) {
                return null;
              }
              return new Date(iso + 'T12:00:00');
            },
            fmt(iso, opts) {
              const x = this.d(iso);
              return x ? x.toLocaleDateString(undefined, opts) : '—';
            },
          }"
          x-on:calendar-select="iso = $event.detail.iso"
        >
          <p class="text-muted-foreground text-xs font-medium uppercase tracking-wide">
            {!! __('Single (outline shell)', 'sage') !!}
          </p>
          <x-calendar class="rounded-lg border" mode="single" selected="{{ $kitSingleIso }}" />
          <div class="border-border text-muted-foreground mt-3 space-y-2 border-t pt-3 text-sm">
            <p class="text-foreground text-xs font-medium uppercase tracking-wide">
              {!! __('Selected date (live)', 'sage') !!}
            </p>
            <ul class="space-y-1.5">
              <li>
                <span class="text-foreground font-medium">{!! __('ISO', 'sage') !!}</span>
                <span class="ml-1 font-mono text-xs" x-text="iso"></span>
              </li>
              <li>
                <span class="text-foreground font-medium">{!! __('Full', 'sage') !!}</span>
                <span class="ml-1" x-text="fmt(iso, { dateStyle: 'full' })"></span>
              </li>
              <li>
                <span class="text-foreground font-medium">{!! __('Long', 'sage') !!}</span>
                <span class="ml-1" x-text="fmt(iso, { dateStyle: 'long' })"></span>
              </li>
              <li>
                <span class="text-foreground font-medium">{!! __('Medium', 'sage') !!}</span>
                <span class="ml-1" x-text="fmt(iso, { dateStyle: 'medium' })"></span>
              </li>
              <li>
                <span class="text-foreground font-medium">{!! __('Short', 'sage') !!}</span>
                <span class="ml-1" x-text="fmt(iso, { dateStyle: 'short' })"></span>
              </li>
              <li>
                <span class="text-foreground font-medium">{!! __('Year-month-day (numeric)', 'sage') !!}</span>
                <span
                  class="ml-1"
                  x-text="fmt(iso, { year: 'numeric', month: '2-digit', day: '2-digit' })"
                ></span>
              </li>
            </ul>
          </div>
          <div class="border-border mt-8 space-y-2 border-t pt-8">
            <p class="text-muted-foreground text-xs font-medium uppercase tracking-wide">
              {!! __('Disable past', 'sage') !!}
            </p>
            <p class="text-muted-foreground text-xs leading-relaxed">
              {!! __(
                'Shortcut prop disable-past merges with min using today in the app timezone (or time-zone when set).',
                'sage'
              ) !!}
            </p>
            <x-calendar class="rounded-lg border" mode="single" :disable-past="true" />
          </div>
        </div>
        <div
          class="min-w-0 space-y-2 lg:col-span-2"
          x-data="{
            from: null,
            to: null,
            daysLabel: @js($kitDaysSuffix),
            d(iso) {
              if (!iso) {
                return null;
              }
              return new Date(iso + 'T12:00:00');
            },
            fmt(iso, opts) {
              const x = this.d(iso);
              return x ? x.toLocaleDateString(undefined, opts) : '—';
            },
          }"
          x-on:calendar-select-range="from = $event.detail.from; to = $event.detail.to"
        >
          <p class="text-muted-foreground text-xs font-medium uppercase tracking-wide">
            {!! __('Range (two months)', 'sage') !!}
          </p>
          <div class="max-w-full overflow-x-auto">
            <x-calendar class="w-fit max-w-none rounded-lg border" mode="range" :number-of-months="2" show-outside-days="false"  />
          </div>
          <div class="border-border text-muted-foreground mt-3 space-y-2 border-t pt-3 text-sm">
            <p class="text-foreground text-xs font-medium uppercase tracking-wide">
              {!! __('Selected range (live)', 'sage') !!}
            </p>
            <ul class="space-y-1.5">
              <li>
                <span class="text-foreground font-medium">{!! __('ISO', 'sage') !!}</span>
                <span class="ml-1 font-mono text-xs"><span x-text="from || '—'"></span> → <span x-text="to || '—'"></span></span>
              </li>
              <li>
                <span class="text-foreground font-medium">{!! __('Full', 'sage') !!}</span>
                <span class="ml-1" x-text="from && to ? fmt(from, { dateStyle: 'full' }) + ' → ' + fmt(to, { dateStyle: 'full' }) : (from ? fmt(from, { dateStyle: 'full' }) + ' → …' : '—')"></span>
              </li>
              <li>
                <span class="text-foreground font-medium">{!! __('Slash-separated', 'sage') !!}</span>
                <span
                  class="ml-1"
                  x-text="from && to ? from.replaceAll('-', '/') + ' – ' + to.replaceAll('-', '/') : (from ? from.replaceAll('-', '/') + ' – …' : '—')"
                ></span>
              </li>
              <li>
                <span class="text-foreground font-medium">{!! __('Weekday span', 'sage') !!}</span>
                <span
                  class="ml-1"
                  x-text="from && to ? fmt(from, { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' }) + ' – ' + fmt(to, { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' }) : (from ? fmt(from, { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' }) + ' → …' : '—')"
                ></span>
              </li>
              <li>
                <span class="text-foreground font-medium">{!! __('Nights (inclusive)', 'sage') !!}</span>
                <span
                  class="ml-1"
                  x-text="from && to ? (Math.round((d(to) - d(from)) / 86400000) + 1) + daysLabel : '—'"
                ></span>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="grid w-fit max-w-6xl grid-cols-1 gap-10 xl:grid-cols-3">
        <div class="min-w-0 space-y-2">
          <p class="text-muted-foreground text-xs font-medium uppercase tracking-wide">
            {!! __('Two months (label caption)', 'sage') !!}
          </p>
          <x-calendar
            class="w-full max-w-full rounded-lg border"
            :number-of-months="2"
            selected="{{ $kitSingleIso }}"
          />
        </div>
        <div class="min-w-0 space-y-2">
          <p class="text-muted-foreground text-xs font-medium uppercase tracking-wide">
            {!! __('Label caption', 'sage') !!}
          </p>
          <x-calendar
            class="rounded-lg border"
            caption-layout="label"
            mode="single"
            selected="{{ $kitSingleIso }}"
          />
        </div>
        <div class="min-w-0 space-y-2">
          <p class="text-muted-foreground text-xs font-medium uppercase tracking-wide">
            {!! __('Disabled + modifiers (booked)', 'sage') !!}
          </p>
          <p class="text-muted-foreground text-xs">
            {!! __('Same dates in disabled and modifiers; line-through from modifiers-class-names.', 'sage') !!}
          </p>
          <x-calendar
            class="rounded-lg border"
            mode="single"
            selected="{{ $kitSingleIso }}"
            :disabled="$kitBooked"
            :modifiers="['booked' => $kitBooked]"
            :modifiers-class-names="['booked' => '[&>button]:line-through opacity-100']"
          />
        </div>
      </div>
      <div class="min-w-0 max-w-md space-y-2">
        <p class="text-muted-foreground text-xs font-medium uppercase tracking-wide">
          {!! __('Time zone (today highlight)', 'sage') !!}
        </p>
        <p class="text-muted-foreground text-xs">
          {!! __('Uses Intl for “today” in the given IANA zone (here: UTC).', 'sage') !!}
        </p>
        <x-calendar
          class="rounded-lg border"
          mode="single"
          month="{{ \Illuminate\Support\Carbon::today()->startOfMonth()->toDateString() }}"
          time-zone="UTC"
        />
      </div>
    </div>
  </div>
</section>

{!! get_the_posts_navigation() !!}
@endsection

@section('sidebar')
  @include('sections.sidebar')
@endsection
