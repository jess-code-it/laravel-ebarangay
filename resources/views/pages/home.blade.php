@extends('layouts.public')

@section('title', 'eBarangay | Local services, closer to home')

@section('content')
    <section class="hero" aria-labelledby="home-title">
        <img class="hero-photo" src="{{ asset('barangay-hall.jpg') }}" alt="Barangay Hall of Baybay in Alubijid, Philippines">
        <div class="hero-shade" aria-hidden="true"></div>
        <div class="hero-content">
            <p class="eyebrow">A public service portal</p>
            <h1 id="home-title">eBarangay</h1>
            <p class="hero-lede">A clearer way to connect with the information and services that matter close to home.</p>
            <div class="hero-actions">
                <a class="action-link action-primary" href="{{ route('about') }}">About the portal</a>
                <a class="action-link action-secondary" href="{{ route('faq') }}">Read common questions</a>
            </div>
        </div>
        <p class="photo-credit">Representative photo: Barangay Hall of Baybay, Alubijid</p>
    </section>

    <section class="starting-points" aria-labelledby="start-title">
        <div class="content-width">
            <div class="section-heading">
                <p class="eyebrow">Start here</p>
                <h2 id="start-title">Find the information you need.</h2>
                <p>Learn what eBarangay is for and where to look for reliable service information.</p>
            </div>
            <div class="pathway-grid">
                <a class="pathway" href="{{ route('about') }}">
                    <span class="pathway-number">01</span>
                    <h3>About eBarangay</h3>
                    <span>Purpose and principles</span>
                </a>
                <a class="pathway" href="{{ route('faq') }}">
                    <span class="pathway-number">02</span>
                    <h3>Common questions</h3>
                    <span>Answers for residents</span>
                </a>
                <a class="pathway" href="{{ route('faq') }}#service-information">
                    <span class="pathway-number">03</span>
                    <h3>Service information</h3>
                    <span>Requirements and next steps</span>
                </a>
            </div>
        </div>
    </section>
@endsection