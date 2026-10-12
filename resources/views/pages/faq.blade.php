@extends('layouts.public')

@section('title', 'Frequently asked questions | eBarangay')

@section('content')
    <section class="page-intro" aria-labelledby="faq-title">
        <div class="content-width">
            <p class="eyebrow">Help and information</p>
            <h1 id="faq-title">Frequently asked questions</h1>
            <p>Clear answers about eBarangay and finding current service information.</p>
        </div>
    </section>

    <section class="page-body" id="service-information">
        <div class="faq-list content-width">
            <details class="faq-item">
                <summary>What is eBarangay?</summary>
                <div class="faq-answer">eBarangay is a public portal intended to make barangay information and service guidance easier to find.</div>
            </details>
            <details class="faq-item">
                <summary>Where can I confirm service requirements?</summary>
                <div class="faq-answer">Requirements can vary by barangay and service. Confirm current details through your barangay's official channels before preparing documents or visiting an office.</div>
            </details>
            <details class="faq-item">
                <summary>Can I submit personal records on these pages?</summary>
                <div class="faq-answer">No. These are public information pages. Do not submit personal, case, health, or payment details through public links or messages.</div>
            </details>
            <details class="faq-item">
                <summary>Are online service requests available now?</summary>
                <div class="faq-answer">Not yet. This initial public section contains information pages only. Online requests should be added only after their requirements, privacy controls, and access rules are confirmed.</div>
            </details>
        </div>
    </section>
@endsection