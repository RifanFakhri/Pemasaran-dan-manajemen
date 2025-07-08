@extends('layouts.app')

@section('title', 'Grand Telar Residence')

@section('page.content')
  @include('page.content.home')
  @include('page.content.about')
  @include('page.content.keuntungan')
  @include('page.content.properti')
  @include('page.content.faq', ['faqs' => $faqs])
  @include('page.content.lokasi', ['places' => $places])
  @include('page.content.kpr')
  @include('page.content.promo')
@endsection



