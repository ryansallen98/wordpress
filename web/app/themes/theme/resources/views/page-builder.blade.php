{{-- 
  Template Name: Page Builder
 --}}

@extends('layouts.app')

@section('content')
  @if (has_flexible('flexible_content'))
    @php
      the_flexible('flexible_content');
    @endphp
  @endif
@endsection
